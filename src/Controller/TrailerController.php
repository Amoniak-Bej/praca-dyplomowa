<?php

namespace App\Controller;

use App\Entity\Trailer;
use App\Entity\Vehicle;
use App\Form\TrailerType;
use App\Form\VehicleType;
use App\Repository\TrailerRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/trailer')]
#[IsGranted('ROLE_MANAGE_VEHICLES')]
class TrailerController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_trailer')]
    public function index(TrailerRepository $trailerRepository)
    {

        $trailers = $trailerRepository->findAll();

        return $this->render('trailer/index.html.twig', [
            'trailers' => $trailers
        ]);
    }


    #[Route('/new', name: 'app_trailer_new')]
    public function new(Request $request)
    {
        $trailer = new Trailer();
        $form = $this->createForm(TrailerType::class, $trailer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('changedMileage')->getData()) {
                $trailer->setMileageDate(new \DateTime());
            }
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($trailer);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie dodano naczępę!');
                return $this->redirectToRoute('app_trailer');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się dodac naczepy, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('trailer/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/edit/{id}', name: 'app_trailer_edit')]
    public function edit(Trailer $trailer, Request $request)
    {
        $form = $this->createForm(TrailerType::class, $trailer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('changedMileage')->getData()) {
                $trailer->setMileageDate(new \DateTime());
            }
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($trailer);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie edytowano naczepę!');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się edytować naczepy, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('trailer/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_trailer_delete')]
    public function delete(Trailer $trailer)
    {
        $em = $this->em;
        $em->getConnection()->beginTransaction();
        try {
            $trailer->setDeletedAt(new \DateTime());
            $user = $this->getUser();
            if ($user != null) {
                $trailer->setDeletedBy($user);
            }
            $em->persist($trailer);
            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            if ($em->getConnection()->isTransactionActive()) {
                $em->getConnection()->rollBack();
            }
            return new Response('Nie udało się usunąć naczepy!', 500);
        }
        return new Response('Usunięto!', 200);
    }

}