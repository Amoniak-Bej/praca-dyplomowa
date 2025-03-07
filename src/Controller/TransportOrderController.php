<?php

namespace App\Controller;

use App\Entity\TransportOrder;
use App\Form\TransportOrderType;
use App\Repository\TransportOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/transportOrder')]
#[IsGranted('ROLE_MANAGE_TRANSPORT_ORDERS')]
class TransportOrderController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_transport_order')]
    public function index(TransportOrderRepository $transportOrderRepository)
    {
        $orders = $transportOrderRepository->findAll();

        return $this->render('transport_order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/new', name: 'app_transport_order_new')]
    public function new(Request $request){
        $transportOrder = new TransportOrder();
        $form = $this->createForm(TransportOrderType::class, $transportOrder);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $em->persist($transportOrder);
                $em->flush();
                $transportOrder->setOrderNumber();
                $em->persist($transportOrder);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie dodano zlecenie transportowe!');

                return $this->json(['success' => true]);
            }catch (\Exception $e){
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się dodać zlecenia transportowego, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('transport_order/new.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'app_transport_order_edit')]
    public function edit(TransportOrder $transportOrder, Request $request){
        $form = $this->createForm(TransportOrderType::class, $transportOrder);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->em;
            $em->getConnection()->beginTransaction();
            try {
                $transportOrder->setOrderNumber();
                $em->persist($transportOrder);
                $em->flush();
                $em->getConnection()->commit();
                $this->addFlash('success', 'Pomyślnie edytowano zlecenie transportowe!');
                return  $this->redirectToRoute('app_transport_order');
            }catch (\Exception $e){
                if ($em->getConnection()->isTransactionActive()) {
                    $em->getConnection()->rollBack();
                }
                $this->addFlash('error', 'Nie udało się edytować zlecenia transportowego, sprawdź pola formularza oraz spróbuj ponownie!');
            }
        }
        return $this->render('transport_order/edit.html.twig',[
            'form' => $form
        ]);

    }

    #[Route('/delete/{id}', name: 'app_transport_order_delete')]
    public function delete(TransportOrder $transportOrder){
        $em = $this->em;
        $em->getConnection()->beginTransaction();
        try {
            $transportOrder->setDeletedAt(new \DateTime());
            $user = $this->getUser();
            if ($user != null) {
                $transportOrder->setDeletedBy($user);
            }
            $em->persist($transportOrder);
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