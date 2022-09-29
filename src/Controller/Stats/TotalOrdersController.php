<?php

namespace App\Controller\Stats;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TotalOrdersController extends AbstractController
{
    public function __construct(
        private OrderRepository $orderRepository,
    ) {}

    public function __invoke(): JsonResponse
    {
        $totalOrder = $this->orderRepository->findTotalOrder();

        return new JsonResponse($totalOrder);
    }
}
