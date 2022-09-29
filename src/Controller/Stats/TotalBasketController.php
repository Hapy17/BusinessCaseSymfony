<?php

namespace App\Controller\Stats;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TotalBasketController extends AbstractController
{
    public function __construct(
        private BasketRepository $basketRepository,
    ) {}

    public function __invoke(): JsonResponse
    {
        $totalBasket = $this->basketRepository->findTotalBasket();

        return new JsonResponse($totalBasket);
    }
}
