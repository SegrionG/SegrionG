<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdrienController extends AbstractController
{
    /**
     * @Route("/adrien", name="adrien")
     */
    public function index(): Response
    {
        return $this->render('adrien/index.html.twig', [
            'controller_name' => 'AdrienController',
        ]);
    }
}
