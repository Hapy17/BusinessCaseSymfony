<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {

        $bestRatingProducts = $this->productRepository->getBestRatingProducts();
        dump($bestRatingProducts);

        return $this->render('front/home/index.html.twig', [
            'bestRatingProducts' => $bestRatingProducts
        ]);
    }
}
