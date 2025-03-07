<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Trailer;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\TransportOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reservation')]
#[IsGranted('ROLE_MANAGE_RESERVATIONS')]
class ReservationController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_reservation')]
    public function index(ReservationRepository $reservationRepository){
        $reservations = $reservationRepository->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/new', name: 'app_reservation_new')]
    public function new(Request $request): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($reservation);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie dodano rezerwację!');
                return $this->redirectToRoute('app_reservation_edit',[
                    'id' => $reservation->getId()
                ]);
            }catch (\Exception $e){
                if ($em->getConnection()->isTransactionActive()){
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się dodac rezerwacji, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_reservation_edit')]
    public function edit(Reservation $reservation,Request $request, TransportOrderRepository $transportOrderRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($reservation);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie edytowano rezerwację!');

            }catch (\Exception $e){
                if ($em->getConnection()->isTransactionActive()){
                    $em->getConnection()->rollBack();
                }
            }
        }

        $transportOrders = $transportOrderRepository->findAll();

        $assignedOrders = $reservation->getTransportOrders();

        return $this->render('reservation/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation,
            'transportOrders' => $transportOrders,
            'assignedOrders' => $assignedOrders
        ]);
    }

    #[Route('/delete/{id}', name: 'app_reservation_delete')]
    public function delete(Reservation $reservation)
    {
        $em = $this->em;
        $em->getConnection()->beginTransaction();
        try {
            $reservation->setDeletedAt(new \DateTime());
            $user = $this->getUser();
            if ($user != null) {
                $reservation->setDeletedBy($user);
            }
            $em->persist($reservation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            if ($em->getConnection()->isTransactionActive()) {
                $em->getConnection()->rollBack();
            }
            return new Response('Nie udało się usunąć rezerwacji!', 500);
        }
        return new Response('Usunięto!', 200);
    }


    #[Route('/{id}/update-orders', name: 'app_reservation_update_orders', methods: ['POST'])]
    public function updateOrders(Reservation $reservation, Request $request, TransportOrderRepository $orderRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $selectedOrders = $data['transportOrders'] ?? [];


        foreach ($reservation->getTransportOrders() as $transportOrder){
            $reservation->removeTransportOrder($transportOrder);
        }


        foreach ($selectedOrders as $orderId) {
            $order = $orderRepository->findOneBy(['id' => $orderId]);
            if ($order) {
                $reservation->addTransportOrder($order);
            }
        }

        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }



    #[Route('/calendar/data', name: 'app_reservation_calendar_data', methods: ['GET'])]
    public function calendarData(ReservationRepository $reservationRepository): JsonResponse
    {
        $reservations = $reservationRepository->findAll();
        $data = [];

        /** @var Reservation $reservation */
        foreach ($reservations as $reservation) {
            $reservationId = 'res-' . $reservation->getId();

            $data[] = [
                'id' => $reservationId,
                'content' => $reservation->getVehicle()->getLicenseNumber(),
                'start' => $reservation->getStartDate()->format('Y-m-d H:i:s'),
                'end' => $reservation->getEndDate()->format('Y-m-d H:i:s'),
                'className' => 'reservation-event',
                'group' => $reservationId
            ];

            foreach ($reservation->getTransportOrders() as $order) {
                $data[] = [
                    'id' => 'order-' . $order->getId(),
                    'content' => $order->getOrderNumber() . ' (' . $order->getFromCity() . ' ➝ ' . $order->getToCity() . ')',
                    'start' => $order->getLoadingDateTime()->format('Y-m-d H:i:s'),
                    'end' => $order->getUnloadingDateTime()->format('Y-m-d H:i:s'),
                    'className' => 'order-event',
                    'group' => $reservationId
                ];
            }
        }

        return new JsonResponse($data);
    }


}