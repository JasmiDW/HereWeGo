<?php

namespace App\controllers;

use App\entites\Utilisateurs;
use App\modeles\UtilisateurManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\modeles\PageManager;

class UtilisateursController
{
    private $loader;
    private $twig;
    private $userManager;
    private $loginUser;
    private $pageManager;

    public function __construct()
    {
        
    }

    public function index(){
        if($this->loginUser !=""){
            // Affiche tous les utilisateurs
            $utilisateurs = $this->userManager->getAll();
            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);

            echo $this->twig->render('users/index.html.twig', ['loginUser'=> $this->loginUser, 'users'=>$utilisateurs, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }else{
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }
    }

    public function show(){
        if($this->loginUser !=""){
            // Affiche un utilisateur
            if (!isset($_GET['id']))
            return call('pages', 'error');

            $user = $this->userManager->get($_GET['id']);
            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);

            echo $this->twig->render('users/show.html.twig', ['loginUser'=> $this->loginUser, 'user'=>$user, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }else{
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }
        
    }

    public function add() {
        if($this->loginUser !=""){
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('users/add.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }else{
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }
        
    }

    public function edit() {
        if($this->loginUser !=""){
            if (!isset($_GET['id'])){
                echo $this->twig->render('pages/error.html.twig', ['auto_reload' => true]);
            }else{
                $user = $this->userManager->get($_GET['id']);
                $this->loader = new \Twig\Loader\FilesystemLoader('templates');
                $this->twig = new \Twig\Environment($this->loader);
                echo $this->twig->render('user/edit.html.twig', ['loginUser'=> $this->loginUser, 'user'=>$user,'auto_reload' => true, 'programTitle' => $this->programmTitle]);
            }
        }else{
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }
        
    }

    public function create(){
        if($this->loginUser !=""){
            $email=(!empty($_POST["email"]))? $_POST["email"]:"";
            $plainPassword=(!empty($_POST["password"]))? $_POST["password"]:"";
            if($email != "" && $plainPassword != ""){
                $nom=(!empty($_POST["nom"]))? $_POST["nom"]:"";
                $prenom=(!empty($_POST["prenom"]))? $_POST["prenom"]:"";
                
                $passwordHashed=password_hash($plainPassword, PASSWORD_BCRYPT);
        
                $user=new Utilisateur();
                $user->setEmail($email);
                $user->setPrenom($prenom);
                $user->setNom($nom);
                $user->setPassword($passwordHashed);
               
                $this->userManager->add($user);
                header("location: index.php?controller=admin_users&action=index");
            }else{
                $this->loader = new \Twig\Loader\FilesystemLoader('templates');
                $this->twig = new \Twig\Environment($this->loader);
                echo $this->twig->render('pages/error.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
            } 
        }else{
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }
        
    }

    public function delete(){
        if($this->loginUser !=""){
            if (!isset($_GET['id'])){
                $this->loader = new \Twig\Loader\FilesystemLoader('templates');
                $this->twig = new \Twig\Environment($this->loader);
                echo $this->twig->render('pages/error.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
            }else{
                $id=$_GET["id"];
                if($id>0){
                    $user=$this->userManager->get($id);
    
                    $this->userManager->delete($user);
                    header("location: index.php?controller=admin_users&action=index");
                }
            }
        }else{
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }
        
    }

    public function update() {
        if($this->loginUser !=""){
            if (!isset($_POST['id'])){
                $this->loader = new \Twig\Loader\FilesystemLoader('templates');
                $this->twig = new \Twig\Environment($this->loader);
                echo $this->twig->render('pages/error.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
            } 
            $id=$_POST["id"];
    
            if($id>0){
                $email=(!empty($_POST["email"]))? $_POST["email"]:"";
                $plainPassword=(!empty($_POST["password"]))? $_POST["password"]:"";
                if($email != "" && $plainPassword != "") {
                    $nom=(!empty($_POST["nom"]))? $_POST["nom"]:"";
                    $prenom=(!empty($_POST["prenom"]))? $_POST["prenom"]:"";
                       
                    $user=$this->userManager->get($id);
                    $passwordHashed=password_hash($plainPassword, PASSWORD_BCRYPT);
            
                    $user->setEmail($email);
                    $user->setPrenom($prenom);
                    $user->setNom($nom);
                    $user->setPassword($passwordHashed);
                   
                    $this->userManager->update(($user));
        
                    header("location: index.php?controller=admin_users&action=index");
                }else{
                    $this->loader = new \Twig\Loader\FilesystemLoader('templates');
                    $this->twig = new \Twig\Environment($this->loader);
                    echo $this->twig->render('pages/error.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
                }            
            }
        }else{
            $this->loader = new \Twig\Loader\FilesystemLoader('templates');
            $this->twig = new \Twig\Environment($this->loader);
            echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
        }

    }
    
}

?>