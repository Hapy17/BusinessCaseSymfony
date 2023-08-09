<?php

namespace App\Controller\Stats;

use App\Repository\ContainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MontantTotalController extends AbstractController
{
    public function __construct(
        private ContainRepository $containRepository,
    ) {}

    public function __invoke(): JsonResponse
    {
        $montantTotal = $this->containRepository->findTotalSales();

        return new JsonResponse($montantTotal);
    }
}
