<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPageController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_productPage')]
    public function index(
        ProductRepository $productRepository,
        ReviewRepository $reviewRepository,
        int $id
    ): Response
    {
        $product = $productRepository->find($id);
        $randProducts = $productRepository->getRandProducts();
        $lastReviews = $reviewRepository->getLastReviewsByProduct($id);
        $avgRating = $reviewRepository->getAverageRatingByProduct($id);



        return $this->render('front/product_page/index.html.twig', [
            'product' => $product,
            'randProducts' => $randProducts,
            'lastReviews' => $lastReviews,
            'avgRating' => $avgRating
        ]);
    }
}
