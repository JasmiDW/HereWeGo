<?php

namespace App\controllers;

use App\entites\User;
use App\entites\Categorie;
use App\entites\Participant;
use App\modeles\UserManager;
use App\modeles\EventManager;
use App\modeles\LieuManager;
use App\modeles\StatutManager;
use App\modeles\CategorieManager;
use App\modeles\ParticipantManager;
use App\modeles\TransportManager;
use App\modeles\MediaManager;
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
        if(isset($_SESSION['user_id'])){
            $this->session=true;
            $this->user_id = $_SESSION['user_id'];
          }else{
            $this->session=false;
            $this->user_id = null;
          }
        
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
            $events = $eventManager->getEvent($userId);


            $categories = array();
            foreach ($events as $categorie) {
                $categorieId = $categorie->getId_Categorie();
                $categorie = CategorieManager::find($categorieId);
                $categories [] = $categorie;
            }

            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);

            echo $this->twig->render('users/showProfil.html.twig', ['user'=>$user, 'auto_reload' => true , 'list'=> $events, 'categorie' => $categorie, 'session'=>$this->session, 'userSession'=>$this->user_id]);
    
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

                var_dump(password_verify($password, $password_hash));
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
                    $message="Identifiants invalidesaaaaaaaaaaaaa";
                    $this->loader = new FilesystemLoader('templates');
                    $this->twig = new Environment($this->loader);
                    echo $this->twig->render('pages/connexion.html.twig',['message'=>$message]);
                }
            }else{
                $message="Identifiants invalidesiofnoqmegnf";
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
        echo $this->twig->render('users/profil.html.twig', ['user'=>$user, 'listStatut'=>$statuts, 'session'=>$this->session, 'userSession'=>$this->user_id]);

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
        echo $this->twig->render('users/seeProfil.html.twig', ['user'=>$user, 'session'=>$this->session, 'userSession'=>$this->user_id]);
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
        echo $this->twig->render('users/formUpdateProfil.html.twig', ['user'=>$user, 'lieu'=>$lieu, 'listStatut'=>$statuts, 'session'=>$this->session, 'userSession'=>$this->user_id]);
    }
}

    public function deleteProfil(){
        
        if(isset($_SESSION['user_id'])){
            $session=$_SESSION['user_id'];

        // Récupérer l'user correspondant à l'identifiant dans l'URL
        $id_user = $_GET['id_user'];
        $user = UserManager::find($id_user);
        $statut = $user->getId_Statut();
        

        if ($statut !== 1){
            $participants = ParticipantManager::findParticipant($id_user);

            // Supprimer tous les participants associés à l'utilisateur
            foreach ($participants as $participant) {
                // Récupérer l'ID du participant
                $id_participant = $participant->getId_participant();
                
                // Supprimer le transport associé à l'id_participant
                $transport = TransportManager::deleteByParticipant($id_participant);
                
                $user = ParticipantManager::deleteByUser($id_user);
                
                }

        }else {
            $events = EventManager::getEventById($id_user);
            // Supprimer tous les evenements associés à l'utilisateur
            foreach ($events as $event) {
                // Récupérer l'ID de l'event
                $id_event = $event->getId_event();

                $media = MediaManager::delete($id_event);
                
                // Supprimer l'evenement associé à l'id_user
                $event = EventManager::deleteByUser($id_user);
                
                }
        }
            $user = UserManager::deleteProfil($id_user);

            session_destroy();

        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('users/deleteProfil.html.twig', ['user'=>$user]);
    }
}

    public function update() {
        if(isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $user = UserManager::find($userId);
            $statutId = $user->getId_statut();
            
            if ($statutId == 1) {
                $raisonSocialeRequired = true;
            } else {
                $raisonSocialeRequired = false;
            }

            if(!empty($_POST['password'])) {
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $password = $hashed_password;
            } else {
                // Si le champ de mot de passe est vide, vous pouvez récupérer l'ancien mot de passe depuis la base de données.
                $user = UserManager::find($userId);
                $password = $user->getPassword();
            }

            if($raisonSocialeRequired && empty($_POST['raison_sociale']) || empty($_POST['mail'])) {
                $message = "Les champs raison sociale, mail, telephone et password sont obligatoires";

                // Récupérer l'user correspondant à l'identifiant dans l'URL
                $userId = $_GET['id_user'];
                $user = UserManager::find($userId);

                $lieu= LieuManager::findAll();

                $loader = new FilesystemLoader('templates');
                $twig = new Environment($loader);
                echo $twig->render('users/formUpdateProfil.html.twig', ['message' => $message, 'user'=>$user, 'lieu'=>$lieu, 'session'=>$this->session, 'userSession'=>$this->user_id]);

            } else {
                $userId = $_GET['id_user'];
                $rs = $_POST['raison_sociale'];
                $nom = !empty($_POST['nom']) ? $_POST['nom'] : '';
                $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '';
                $mail = $_POST['mail'];
                
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
                echo $this->twig->render('users/seeProfil.html.twig', ['user'=>$user, 'session'=>$this->session, 'userSession'=>$this->user_id]);
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
                $uploadsDir = "public/media/users/";
                $tempFile = $image['tmp_name'];
                $newFileName = $uderId . date('Ymd') . "." . $extension;
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



    public function add(){

        if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mail']) || empty($_POST['password'])) {
            $message = "Les champs nom, prenom, mail et mot de passe sont obligatoires";
            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);
            echo $this->twig->render('pages/inscription.html.twig', [
            'message' => $message]);
        }

        $statut = $_POST['statut'];
            if ($statut == 'organisateur') {
                $statutId = 1; 
            } elseif ($statut == 'utilisateur') {
                $statutId = 2; 
            } else {
                $statutId = 3;
            }

        $raison_sociale = !empty($_POST['raison_sociale']) ? $_POST['raison_sociale'] : NULL;
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];

        $password=password_hash($_POST['password'], PASSWORD_BCRYPT);

        $id_lieu = $_POST['lieu'];
        $telephone = !empty($_POST['telephone']) ?  $_POST['telephone'] : '';

        $genre = $_POST['genre'];
        if ($genre == 'homme') {
            $genreDB = 1; // Homme
        } elseif ($genre == 'femme') {
            $genreDB = 0; // Femme
        } else {
            $genreDB = 3;
        }

        $dateInscription = date('Y/m/d');

        if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            // afficher un message d'erreur pour indiquer que l'adresse e-mail est invalide ou manquante
            $messageMail = "Le mail est invalide.";
        }

        $user = New User();

        $user->setRaison_sociale($raison_sociale);
        $user->setNom_user($nom);
        $user->setPrenom_user($prenom);
        $user->setGenre($genreDB); 
        $user->setMail_user($mail);
        $user->setPassword($password);
        $user->setId_lieu($id_lieu);
        $user->setTel_user($telephone);
        
        $user->setDateInscription($dateInscription);
        $user->setId_statut($statutId);

        $id_user= UserManager::add($user);

        $to = $_POST['mail'];
        $subject = 'Confirmation d\'inscription';
        $message = 'Bonjour ' . $_POST['prenom'] . ',<br><br>';
        $message .= 'Nous sommes heureux de vous compter parmi nos nouveaux membres. Votre inscription a bien été prise en compte.<br><br>';
        $message .= 'Cordialement,<br>';
        $message .= 'L\'équipe HereWeGo';

        $headers = 'From: webmaster@herewego.com' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";

        mail($to, $subject, $message, $headers);

        $message = "Bienvenue chez HereWeGo. Les événements sont à portée de vous.";
            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);
            echo $this->twig->render('pages/loginSuccess.html.twig', [
            'message' => $message]);
    
        }

        
}

?>