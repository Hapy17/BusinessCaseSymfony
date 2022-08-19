<?php

namespace App\Controller\Back;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\AbstractRepository;
use App\Repository\OrderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_admin_order_index', methods: ['GET'])]
    public function index(
        OrderRepository $orderRepository,
        PaginatorInterface $paginator,
        Request $request
        ): Response
    {

        $qb = $orderRepository->getQbAll();

        $orders = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        dump($qb);

        return $this->render('back/order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    // #[Route('/new', name: 'app_admin_order_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, OrderRepository $orderRepository): Response
    // {
    //     $order = new Order();
    //     $form = $this->createForm(OrderType::class, $order);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $orderRepository->add($order, true);

    //         return $this->redirectToRoute('app_admin_order_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('back/order/new.html.twig', [
    //         'order' => $order,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_admin_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        

        return $this->render('back/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_admin_order_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response
    // {
    //     $form = $this->createForm(OrderType::class, $order);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $orderRepository->add($order, true);

    //         return $this->redirectToRoute('app_admin_order_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('back/order/edit.html.twig', [
    //         'order' => $order,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_admin_order_delete', methods: ['POST'])]
    // public function delete(Request $request, Order $order, OrderRepository $orderRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
    //         $orderRepository->remove($order, true);
    //     }

    //     return $this->redirectToRoute('app_admin_order_index', [], Response::HTTP_SEE_OTHER);
    // }
}
