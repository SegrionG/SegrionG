<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterfaces;


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

    /**
     * @Route("/formget", name="formget")
     */
    public function formget(Request $request, EntityManagerInterface $manager): Response
    {
        $username = $request -> request -> get("username") ;
        $password = $request -> request -> get("password") ;
        if( ($username == "root") && ($password == "toor") ) {
            $msg = 'Le mdp et le user sont correctes';
        }
        elseif($username == "admin") {
            $msg = 'Vous êtes identifié en tant que admin';
        }
        else {
            $msg = 'Le mdp et le user ne sont pas correctes';
        }
        return $this->render('adrien/formget.html.twig', [
            'controller_name' => 'AdrienController','login' => $username, 'mdp' => $password , 'message' => $msg]);  
        
    }
}
