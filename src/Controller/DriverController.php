<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Entity\Trailer;
use App\Form\DriverType;
use App\Form\TrailerType;
use App\Repository\DriverRepository;
use App\Repository\TrailerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/driver')]
#[IsGranted('ROLE_MANAGE_DRIVERS')]
class DriverController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_driver')]
    public function index(DriverRepository $driverRepository)
    {

        $drivers = $driverRepository->findAll();

        return $this->render('driver/index.html.twig', [
            'drivers' => $drivers
        ]);
    }


    #[Route('/new', name: 'app_driver_new')]
    public function new(Request $request)
    {
        $driver = new Driver();
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($driver);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie dodano kierowce!');
                return $this->redirectToRoute('app_driver');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się dodac kierowcy, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('driver/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/edit/{id}', name: 'app_driver_edit')]
    public function edit(Driver $driver, Request $request)
    {
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($driver);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie edytowano kierowcę!');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się edytować kierowcy, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('driver/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_driver_delete')]
    public function delete(Driver $driver)
    {
        $em = $this->em;
        $em->getConnection()->beginTransaction();
        try {
            $driver->setDeletedAt(new \DateTime());
            $user = $this->getUser();
            if ($user != null) {
                $driver->setDeletedBy($user);
            }
            $em->persist($driver);
            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            if ($em->getConnection()->isTransactionActive()) {
                $em->getConnection()->rollBack();
            }
            return new Response('Nie udało się usunąć kierowcy!', 500);
        }
        return new Response('Usunięto!', 200);
    }


}