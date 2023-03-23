<?php

namespace App\controllers;

use App\entites\User;
use App\entites\Categorie;
use App\modeles\UserManager;
use App\modeles\EventManager;
use App\modeles\LieuManager;
use App\modeles\StatutManager;
use App\modeles\CategorieManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\modeles\PageManager;



class UserController 
{
    private $loader;
    private $twig;
    private $userManager;
    private $loginUser;
    private $pageManager;

    public function __construct()
    {
        
    }

    public function show(){

        // Affiche un utilisateur
        if (!isset($_GET['id'])){
            return call('pages', 'error');
        }
            // Récupérer l'user correspondant à l'identifiant dans l'URL
            $userId = $_GET['id'];
            $user = UserManager::find($userId);

            // Récupérer une liste d'événement correspondant à l'utilisateur
            $eventManager = new EventManager();
            $events = $eventManager->getEventById($userId);


            $categories = array();
            foreach ($events as $categorie) {
                $categorieId = $categorie->getId_Categorie();
                $categorie = CategorieManager::find($categorieId);
                $categories [] = $categorie;
            }

            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);

            echo $this->twig->render('users/showProfil.html.twig', ['user'=>$user, 'auto_reload' => true , 'list'=> $events, 'categorie' => $categorie]);
    
    }

    public function login(){

        if(!empty($_POST['mail'])&&!empty($_POST['password'])){
            $login=$_POST['mail'];

            $result = UserManager::getLogin($login);
            // si l'utilisateur existe
            if($result->getPassword()){
                // on vérifie le mot de passe saisi
                $password=$_POST['password'];
                $password_hash=$result->getPassword();
                if(password_verify($password, $password_hash)){
                    // si la vérification est réussie, on initialise la variable de session 'user'
                    $_SESSION['user_id'] = $result->getId_user();
                    $id_user = $_SESSION['user_id'];
                    $id_statut = $result->getId_statut();

                     // Récupérer l'utilisateur correspondant à l'événement
                     $user = UserManager::find($result->getId_user());
    
                     $statuts = array();
                     $id_statut = $user->getId_statut();
                     $statut = StatutManager::find($id_statut);
                     $libelle_statut = $statut->getLibelle_statut();
                     $statuts [] = $libelle_statut;

                     $this->loader = new FilesystemLoader('templates');
                     $this->twig = new Environment($this->loader);
                     echo $this->twig->render('users/profil.html.twig',['user'=>$user, 'listStatut'=>$statuts]);

                }else{
                    $message="Identifiants invalides";
                    $this->loader = new FilesystemLoader('templates');
                    $this->twig = new Environment($this->loader);
                    echo $this->twig->render('pages/connexion.html.twig',['message'=>$message]);
                }
            }else{
                $message="Identifiants invalides";
                $this->loader = new FilesystemLoader('templates');
                $this->twig = new Environment($this->loader);
                echo $this->twig->render('pages/connexion.html.twig',['message'=>$message]);
            }
        }
    }

    public function profil(){

        if(isset($_SESSION['user_id'])){

        // Récupérer l'user correspondant à l'identifiant dans l'URL
        $userId = $_SESSION['user_id'];
        $user = UserManager::find($userId);

        $statuts = array();
        $id_statut = $user->getId_statut();
        $statut = StatutManager::find($id_statut);
        $libelle_statut = $statut->getLibelle_statut();
        $statuts [] = $libelle_statut;

        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('users/profil.html.twig', ['user'=>$user, 'listStatut'=>$statuts]);

        }else{

            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);
            echo $this->twig->render('users/loginfailed.html.twig');
        }

    }

    public function seeProfil(){

        if(isset($_SESSION['user_id'])){
            $session=$_SESSION['user_id'];
            $id_user = ['user_id'];

        // Récupérer l'user correspondant à l'identifiant dans l'URL
        $userId = $_GET['id'];
        $user = UserManager::find($userId);
            
        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('users/seeProfil.html.twig', ['user'=>$user]);
        }
        
    }


    public function logout(){
        unset($_SESSION['user_id']);
        header("location: ?controller=pages&action=home");
    }

    public function formUpdateProfil(){

        if(isset($_SESSION['user_id'])){
            $session=$_SESSION['user_id'];

        // Récupérer l'user correspondant à l'identifiant dans l'URL
        $userId = $_GET['id_user'];

        // Récupérer l'utilisateur correspondant à l'événement
        $user = UserManager::find($userId);

        $statuts = array();
        $id_statut = $user->getId_statut();
        $statut = StatutManager::find($id_statut);
        $libelle_statut = $statut->getLibelle_statut();
        $statuts [] = $libelle_statut;

        $lieu= LieuManager::findAll();

        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('users/formUpdateProfil.html.twig', ['user'=>$user, 'lieu'=>$lieu, 'listStatut'=>$statuts]);
    }
}

    public function deleteProfil(){
        
        if(isset($_SESSION['user_id'])){
            $session=$_SESSION['user_id'];

        // Récupérer l'user correspondant à l'identifiant dans l'URL
        $id_user = $_GET['id_user'];
        $user = UserManager::deleteProfil($id_user);

        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('users/deleteProfil.html.twig', ['user'=>$user]);
    }
}

    public function update() {
        if(isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
      
            if(empty($_POST['raison_sociale']) || empty($_POST['mail']) || empty($_POST['telephone']) || empty($_POST['password'])) {
                $message = "Les champs raison sociale, mail, telephone et password sont obligatoires";

                // Récupérer l'user correspondant à l'identifiant dans l'URL
                $userId = $_GET['id_user'];
                $user = UserManager::find($userId);

                $lieu= LieuManager::findAll();

                $loader = new FilesystemLoader('templates');
                $twig = new Environment($loader);
                echo $twig->render('users/formUpdateProfil.html.twig', ['message' => $message, 'user'=>$user, 'lieu'=>$lieu]);

            } else {
                $userId = $_GET['id_user'];
                $rs = $_POST['raison_sociale'];
                $nom = !empty($_POST['nom']) ? $_POST['nom'] : '';
                $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '';
                $mail = $_POST['mail'];
                $password = $_POST['password'];
                $adresse = $_POST['adresse'];
                $lieuId = $_POST["lieu"];
                $telephone = $_POST['telephone'];

      
                $user = new User();
                $user->setRaison_sociale($rs);
                $user->setNom_user($nom);
                $user->setPrenom_user($prenom);
                $user->setMail_user($mail);
                $user->setPassword($password);
                $user->setTel_user($telephone);
                $user->setId_lieu($lieuId);
                $user->setId_user($userId);
      
                UserManager::update($user);

                 // Récupérer l'user correspondant à l'identifiant dans l'URL
                 $userId = $_GET['id_user'];
                 $user = UserManager::find($userId);
      
                $this->loader = new FilesystemLoader('templates');
                $this->twig = new Environment($this->loader);
                echo $this->twig->render('users/seeProfil.html.twig', ['user'=>$user]);
            }
            }
        }
        
        public function updateProfileImage(){
            if(isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $image = $_FILES['photo'];
                // Vérifier si le fichier est une image valide
                $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                if(!in_array($extension, $allowedExtensions)){
                    return "Le fichier doit être une image valide (JPG, JPEG, PNG ou GIF)";
                }
                
                // Déplacer le fichier vers le dossier de téléchargement
                $uploadsDir = "public/media/";
                $tempFile = $image['tmp_name'];
                $newFileName = date('Ymd') . "." . $extension;
                $targetFile = $uploadsDir . $newFileName;
                if(move_uploaded_file($tempFile, $targetFile)){

                    $user = new User();
                    $user->setId_user($userId);
                    $user->setUrl_photo($targetFile);

                    UserManager::updateProfileImage($user);

                    $message = 'La photo de profil a bien été mis à jour.';

                     // Récupérer l'user correspondant à l'identifiant dans l'URL
                    $userId = $_GET['id_user'];
                    $user = UserManager::find($userId);

                    $this->loader = new FilesystemLoader('templates');
                    $this->twig = new Environment($this->loader);
                    echo $this->twig->render('users/seeProfil.html.twig', ['user'=>$user, 'message'=>$message]);

                }else{
                    return "Une erreur s'est produite lors du téléchargement de l'image";
                }
            }else{
                return "L'utilisateur n'est pas connecté";
            }
        }



    // public function create(){
    //     if($this->loginUser !=""){
    //         $email=(!empty($_POST["email"]))? $_POST["email"]:"";
    //         $plainPassword=(!empty($_POST["password"]))? $_POST["password"]:"";
    //         if($email != "" && $plainPassword != ""){
    //             $nom=(!empty($_POST["nom"]))? $_POST["nom"]:"";
    //             $prenom=(!empty($_POST["prenom"]))? $_POST["prenom"]:"";
                
    //             $passwordHashed=password_hash($plainPassword, PASSWORD_BCRYPT);
        
    //             $user=new Utilisateur();
    //             $user->setEmail($email);
    //             $user->setPrenom($prenom);
    //             $user->setNom($nom);
    //             $user->setPassword($passwordHashed);
               
    //             $this->userManager->add($user);
    //             header("location: index.php?controller=admin_users&action=index");
    //         }else{
    //             $this->loader = new \Twig\Loader\FilesystemLoader('templates');
    //             $this->twig = new \Twig\Environment($this->loader);
    //             echo $this->twig->render('pages/error.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
    //         } 
    //     }else{
    //         $this->loader = new \Twig\Loader\FilesystemLoader('templates');
    //         $this->twig = new \Twig\Environment($this->loader);
    //         echo $this->twig->render('pages/acces_denied.html.twig', ['loginUser'=> $this->loginUser, 'auto_reload' => true, 'programTitle' => $this->programmTitle]);
    //     }
        
    // }

    
}

?>