<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Entity\Acces;
use App\Entity\Document;
use App\Entity\Autorisation;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdrienController extends AbstractController
{
    /**
     * @Route("/adrien", name="adrien")
     */
    public function index(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $profidd = $session -> get('numero');
        $vuser = $session -> get('user');
        return $this->render('adrien/index.html.twig', [
            'controller_name' => 'AdrienController','profidd' => $profidd,'vuser' => $vuser
        ]);
    }

    /**
     * @Route("/formget", name="formget")
     */
    public function formget(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $profidd = $session -> get('numero');
        $vuser = $session -> get('user');
        $vmdp = $session -> get('mdp');
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
            'controller_name' => 'AdrienController', 'vuser' => $vuser, 'vmdp' => $vmdp,'login' => $username, 'mdp' => $password , 'message' => $msg,'profidd' => $profidd]);  
        
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $username = $request -> request -> get("username") ;
        $password = $request -> request -> get("password") ;
        $usernameV = $manager -> getRepository(Utilisateur::class) -> findOneBy([ "Login" => $username]);
        $hash = $usernameV -> getPassword();

        if ($usernameV==NULL){
            $msg = "Utilisateur inconnu";
            $profidd = "-1";
            $vuser= "-1";
            $vmdp= "-1";
        }
        elseif (password_verify($password,$hash)){
            $msg = 'Le mdp et le user sont correctes';
            $profid = $usernameV->getId();
            $session -> set('numero', $profid);
            $session -> set('user', $username);
            $session -> set('mdp', $password);
            $profidd = $session -> get('numero');
            $vuser = $session -> get('user');
            $vmdp = $session -> get('mdp');
        }
        else {
            $msg = 'Le mdp  n\'est pas correct';
            $profidd = "-1";
            $vuser= "-1";
            $vmdp= "-1";
        }

        return $this->render('adrien/login.html.twig', [
            'controller_name' => 'AdrienController', 'vuser' => $vuser, 'vmdp' => $vmdp, 'vs' => $profidd,'profidd' => $profidd,'login' => $username,'message' => $msg, 'loginV' => $usernameV, 'mdp' => $password]);  
        
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
            $session -> set('numero', -1);
            $session -> set('user', -1);
            $session -> set('mdp', -1);
            $session -> clear();

        return $this->RedirectToRoute('adrien');
        
    }


     /**
     * @Route("/makelogin", name="makelogin")
     */
    public function makelogin(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $profidd = $session -> get('numero');
        $vuser = $session -> get('user');
        return $this->render('adrien/makelogin.html.twig', [
            'controller_name' => 'AdrienController', 'profidd' => $profidd,'vuser' => $vuser
        ]);
    }
        /**
     * @Route("/clogin", name="clogin")
     */
    public function clogin(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $profidd = $session -> get('numero');
        $vuser = $session -> get('user');
        $cusername = $request -> request -> get("Cusername") ;
        $cpassword = $request -> request -> get("Cpassword") ;
        if (strcmp ($cpassword,'')==0)
            $nusername=NULL;
        elseif (strcmp ($cusername,'')==0)
            $nusername=NULL;
        else {
            $nonhashpass = $cpassword;
            $cpassword = (password_hash($cpassword, PASSWORD_DEFAULT));
            $nusername = new Utilisateur();
            $nusername->setLogin($cusername);
            $nusername->setPassword($cpassword);
            $manager->persist($nusername);
            $manager->flush();
        }

        if($nusername==NULL){
            $message = "Le compte n'a pas été créé, ERROR !";
        }
        else{
            $message="Le compte a bien été crée.";
            $nautorisation = new Autorisation();
            if($nusername=='admin') {
                $bool1 = 1;
                $bool2 = 1;
                $nautorisation->setLecture($bool1);
                $nautorisation->setEcriture($bool2);
                $manager->persist($nautorisation);
                $manager->flush();
            }
            else{
                $bool1 = 1;
                $bool2 = 0;
                $nautorisation->setLecture($bool1);
                $nautorisation->setEcriture($bool2);
                $manager->persist($nautorisation);
                $manager->flush();
            }
        }

        return $this->render('adrien/clogin.html.twig', [
            'controller_name' => 'AdrienController','login' => $cusername, 'mdp' => $cpassword, 'message' => $message,'profidd' => $profidd,'vuser' => $vuser]);
    }
    /**
     * @Route("/listelogin", name="listelogin")
     */
    public function listelogin(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $profidd = $session -> get('numero');
        $vuser = $session -> get('user');
        $listelogin = $manager->getRepository(Utilisateur::class)->findAll();
        return $this->render('adrien/listelogin.html.twig',[
            'listelogin' => $listelogin,'profidd' => $profidd,'vuser' => $vuser ]); 
    }
        /**
     * @Route("/file2", name="file2")
     */
    public function file2(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $profidd = $session -> get('numero');
        $vuser = $session -> get('user');
        $path = "/home/etudrt/M4207CservgeraldesD2/public/file21";
        if(file_exists($path)) {}
        else{
        mkdir("file21");
        }
        return $this->render('adrien/file2.html.twig',[
            'profidd' => $profidd, $_FILES, $path,'vuser' => $vuser]); 
    }
            /**
     * @Route("/recupfile", name="recupfile")
     */
    public function recupfile(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $vuser = $session -> get('user');
        $date = date("y-m-d");  
        $bool = 1;
        $path = "/home/etudrt/M4207CservgeraldesD2/public/".basename($_FILES['file1']['name']);
        $profidd = $session -> get('numero');
        $_FILES['file1']['tmp_name'];
        $_FILES['file1']['name'];
        basename($_FILES['file1']['name']);
        move_uploaded_file($_FILES['file1']['tmp_name'],$path);
        $nfile = new Document();
        $nfile->setChemin($path);
        $nfile->setDate(new \DateTime($date));
        $nfile->setActif($bool);
        $manager->persist($nfile);
        $manager->flush();
        return $this->render('adrien/recupfile.html.twig',[
            'profidd' => $profidd, $_FILES,'vuser' => $vuser]); 
    }
    /**
     * @Route("/listefichier", name="listefichier")
     */
    public function listefichier(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $vuser = $session -> get('user');
        $profidd = $session -> get('numero');
        $listefichier = $manager->getRepository(Document::class)->findAll();

        return $this->render('adrien/listefichier.html.twig',[
            'listefichier' => $listefichier,'profidd' => $profidd,'vuser' => $vuser ]); 
    }
}
