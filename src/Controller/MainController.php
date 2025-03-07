<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER')]
class MainController extends AbstractController
{

    #[Route('/', name: 'app_dashboard')]
    public function dashboard()
    {
        return $this->render('main/dashboard.html.twig');
    }

    #[Route('/settings', name: 'app_settings')]
    public function settings(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);

            $user->setPassword($hashedPassword);

            $em->getConnection()->beginTransaction();
            try {
                $em->persist($user);
                $em->flush();
                $em->getConnection()->commit();

                $this->addFlash('success', 'Hasło zostało pomyślnie zmienione.');

                return $this->redirectToRoute('app_dashboard');
            }catch (\Exception $e){
                if ($em->getConnection()->isTransactionActive()){
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się zmienic hasła, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }

        return $this->render('main/settings.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

}