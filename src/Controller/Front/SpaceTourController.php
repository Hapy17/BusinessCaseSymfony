<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpaceTourController extends AbstractController
{
    #[Route('/spaceTour', name: 'app_spaceTour')]
    public function index(): Response
    {
        return $this->render('front/spaceTour/index.html.twig', [
            'controller_name' => 'SpaceTourController',
        ]);
    }
}
