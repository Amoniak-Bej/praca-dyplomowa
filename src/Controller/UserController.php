<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Entity\User;
use App\Form\DriverType;
use App\Form\UserType;
use App\Repository\DriverRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/user')]
#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_user')]
    public function index(UserRepository $userRepository)
    {

        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }


    #[Route('/new', name: 'app_user_new')]
    public function new(Request $request,UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hashedPassword);
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($user);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie dodano użytkownika!');
                return $this->redirectToRoute('app_user');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się dodac użytkownika, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/edit/{id}', name: 'app_user_edit')]
    public function edit(User $user, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $form = $this->createForm(UserType::class, $user, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $newPassword = $form->get('password')->getData();
                if (!empty($newPassword)) {
                    $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                    $user->setPassword($hashedPassword);
                }

                $em->persist($user);
                $em->flush();
                $em->getConnection()->commit();

                $this->addFlash('success', 'Pomyślnie edytowano użytkownika!');
                return $this->redirectToRoute('app_user');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się edytować użytkownika, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}