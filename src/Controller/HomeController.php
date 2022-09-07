<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(
        private ProductRepository $productRepository,
        private ReviewRepository $reviewRepository
    )
    {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        $bestRatingProducts = $this->productRepository->getBestRatingProducts();
        $randProducts = $this->productRepository->getRandProducts();
        $lastReviews = $this->reviewRepository->getLastReviews();

        return $this->render('front/home/index.html.twig', [
            'bestRatingProducts' => $bestRatingProducts,
            'randProducts' => $randProducts,
            'lastReviews' => $lastReviews
        ]);
    }
}
