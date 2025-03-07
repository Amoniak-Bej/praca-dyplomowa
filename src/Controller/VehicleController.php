<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/vehicle')]
#[IsGranted('ROLE_MANAGE_VEHICLES')]
class VehicleController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_vehicle')]
    public function index(VehicleRepository $vehicleRepository)
    {

        $vehicles = $vehicleRepository->findAll();

        return $this->render('vehicle/index.html.twig', [
            'vehicles' => $vehicles
        ]);
    }


    #[Route('/new', name: 'app_vehicle_new')]
    public function new(Request $request)
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('changedMileage')->getData()) {
                $vehicle->setMileageDate(new \DateTime());
            }
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($vehicle);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie dodano pojazd!');
                return $this->redirectToRoute('app_vehicle');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się dodac pojazdu, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('vehicle/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/edit/{id}', name: 'app_vehicle_edit')]
    public function edit(Vehicle $vehicle, Request $request)
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('changedMileage')->getData()) {
                $vehicle->setMileageDate(new \DateTime());
            }
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($vehicle);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie edytowano pojazd!');
            } catch (\Exception $e) {
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się dodac pojazdu, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('vehicle/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_vehicle_delete')]
    public function delete(Vehicle $vehicle)
    {
        $em = $this->em;
        $em->getConnection()->beginTransaction();
        try {
            $vehicle->setDeletedAt(new \DateTime());
            $user = $this->getUser();
            if ($user != null) {
                $vehicle->setDeletedBy($user);
            }
            $em->persist($vehicle);
            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            if ($em->getConnection()->isTransactionActive()) {
                $em->getConnection()->rollBack();
            }
            return new Response('Nie udało się usunąć pojazdu!', 500);
        }
        return new Response('Usunięto!', 200);
    }
}