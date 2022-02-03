<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

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
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, EntityManagerInterface $manager): Response
    {
        $username = $request -> request -> get("username") ;
        $password = $request -> request -> get("password") ;
        $usernameV = $manager -> getRepository(Utilisateur::class) -> findOneBy([ "Login" => $username]);

        if ($usernameV==NULL)
            $msg = "Utilisateur inconnu";
        elseif ($password == $usernameV -> getPassword() ){
            $msg = 'Le mdp et le user sont correctes';
        }
        else {
            $msg = 'Le mdp  n\'est pas correct';
        }

        return $this->render('adrien/login.html.twig', [
            'controller_name' => 'AdrienController','login' => $username,'message' => $msg, 'loginV' => $usernameV, 'mdp' => $password]);  
        
    }
}
