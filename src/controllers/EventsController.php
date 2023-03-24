<?php

namespace App\controllers;


use App\entites\Event;
use App\entites\Lieu;
use App\entites\TypeTransport;
use App\entites\Categorie;
use App\entites\Media;
use App\modeles\EventManager;
use App\modeles\UserManager;
use App\modeles\PageManager;
use App\modeles\LieuManager;
use App\modeles\MediaManager;
use App\modeles\CouleurManager;
use App\modeles\ParticipantManager;
use App\modeles\TransportManager;
use App\modeles\TypeTransportManager;
use App\modeles\CategorieManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


  class EventsController {

    private $eventManager;
    private $transportManager;
    private $session;

    public function __construct(){
        $this->eventManager = new EventManager();
        $this->transportController = new TransportManager();
        if(isset($_SESSION['user_id'])){
          $this->session=true;
        }else{
          $this->session=false;
        }
    }

    public function getEvenements()
    {
      $events = EventManager::getEvenements();
      return $events;
    }

    public function showFavoriteEvent()
    {
      $favoriteEvent = $this->eventManager->showFavoriteEvent();
      return $favoriteEvent;
    }
    
    public function show() {
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id'])) {
        return call('pages', 'error');
      }
    
      // Récupérer l'événement correspondant à l'identifiant dans l'URL
      $eventId = $_GET['id'];

      $event = EventManager::find($eventId);

      // Récupérer les categories correspondant à chaque événement
      $idCategorie = $event->getId_Categorie();  
      $categorie = CategorieManager::find($idCategorie);

      //Récupérer la couleur qui correspond à la catégorie 
      $colorId = $categorie->getId_couleur();
      $color = CouleurManager::find($colorId);

      // Récupérer l'utilisateur correspondant à l'événement
      $userId = $event->getId_User();
      $user = UserManager::find($userId);

      // Récupérer la localisation correspondant à l'événement
      $localisationId = $event->getId_lieu();
      $localisation = LieuManager::find($localisationId);
    
      // Calculer le nombre de places restantes pour l'événement
      $remainingPlaces = EventManager::remainingPlaces($event);
    
      // Récupérer les transports correspondant à l'événement
      $transportManager = new TransportManager();
      $listTransports = $transportManager->getTransport($eventId);

      // Récupérer les médias correspondant à l'événement
      $mediaManager = new MediaManager();
      $media = $mediaManager->findAllByEvent($eventId);

            // initialiser $typeTransport à null
      $typeTransport = null;

      $localisations = array();
            
      if (!empty($listTransports)) {
          foreach ($listTransports as $transport) {
              $localisationId = $transport->getId_lieu();
              $localisation = LieuManager::find($localisationId);
              $localisations[] = $localisation;
          
              // récupérer les types de transports correspondant à chaque transport
              $typeId = $transport->getID_Type_Transport();  
              $typeTransport = TypeTransportManager::find($typeId);
          }
      }

      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      $this->twig->addExtension(new \Twig\Extension\DebugExtension());
      echo $this->twig->render('events/templateEvent.html.twig', array(
          'event' => $event,
          'user' => $user,
          'localisation' => $localisation,
          'remainingPlaces' => $remainingPlaces,
          'listTransports' => $listTransports,
          'typeTransport' => $typeTransport,
          'categorie' => $categorie,
          'media' => $media,
          'color' =>$color, 'session'=>$this->session
      ));
    }

    public function formAddEvent(){

      if(isset($_SESSION['user_id'])){
        $session=$_SESSION['user_id'];
        $id_user = ['user_id'];

      // Récupérer l'user correspondant à l'identifiant dans l'URL
      $userId = $_GET['id'];
      $user = UserManager::find($userId);

      $lieu= LieuManager::findAll();
      $categorie = CategorieManager::findAll();


      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);


      echo $this->twig->render('events/addEvent.html.twig', array('lieu'=>$lieu, 'categorie'=>$categorie, 'user'=> $user, 'session'=>$this->session));
      
    }
  }

    public function add(){

      if(isset($_SESSION['user_id'])){
        $session=$_SESSION['user_id'];


        if (empty($_POST['titre_event']) || empty($_POST['date_debut_event']) || empty($_POST['resume_event'])) {
          $message = "Les champs titre, date et resumé sont obligatoires";
          $this->loader = new FilesystemLoader('templates');
          $this->twig = new Environment($this->loader);
          echo $this->twig->render('events/addEvent.html.twig', [
          'message' => $message, 'session'=>$this->session]);
      }

      $titre_event = $_POST['titre_event'];
      $date_debut = $_POST['date_debut_event'];
      $date_fin = !empty($_POST['date_fin_event']) ? $_POST['date_fin_event'] : '';
      $nb_place= $_POST['places'];
      $resume = $_POST['resume_event'];
      $content = !empty($_POST['description_event']) ? $_POST['description_event'] : '';
      $id_lieu = $_POST["lieu"];
      $id_categorie = $_POST['categorie'];

      $event = new Event();

      $event->setTitre_event($titre_event);
      $event->setDate_Debut_event($date_debut);
      $event->setDate_Fin_event($date_fin);
      $event->setNb_places($nb_place);
      $event->setResume_event($resume);
      $event->setDescription_event($content);
      $event->setId_Categorie($id_categorie);
      $event->setId_lieu($id_lieu);
      $event->setId_user($session);

      $id_event = EventManager::add($event);

      var_dump($id_event);

      $image = $_FILES['photo'];
      // Vérifier si le fichier est une image valide
      $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
      $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
      if(!in_array($extension, $allowedExtensions)){
          return "Le fichier doit être une image valide (JPG, JPEG, PNG ou GIF)";
      }
      
        // Déplacer le fichier vers le dossier de téléchargement
        $uploadsDir = "public/media/events";
        $tempFile = $image['tmp_name'];
        $newFileName = "-" . $id_event . date('Ymd') . "." . $extension;
        $targetFile = $uploadsDir . $newFileName;
        if(move_uploaded_file($tempFile, $targetFile)){

          $media = new Media();

          $media->setURL($targetFile);
          $media->setId_event($id_event);
        

        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('events/templateEvent.html.twig', [
            'event' => $event, 'session'=>$this->session]);
       }else{
      return "Une erreur s'est produite lors du téléchargement de l'image";
  }
}
    }
      
    public function seeEvent()
    {
      if(isset($_SESSION['user_id'])){
        $session=$_SESSION['user_id'];
        $id_user = ['user_id'];

      // Récupérer l'user correspondant à l'identifiant dans l'URL
      $userId = $_GET['id'];
      $user = UserManager::find($userId);

      // Récupérer une liste d'événement correspondant à l'utilisateur
      $eventManager = new EventManager();
      $events = $eventManager->getEventById($userId);
      

      $categories = array();
      foreach ($events as $event) {
          $categorieId = $event->getId_Categorie();
          $categorie = CategorieManager::find($categorieId);
          $categories[] = $categorie;
      }

      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('events/seeEvent.html.twig',  ['user'=>$user, 'auto_reload' => true , 'list'=> $events, 'categories' => $categories, 'session'=>$this->session]);
      
    }
  }

  public function formUpdate(){

    if(isset($_SESSION['user_id'])){
      $session = $_SESSION['user_id'];
      $id_user = $session['user_id'];

    $lieu= LieuManager::findAll();
    $categorie = CategorieManager::findAll();

    $eventId =  $_GET['id_event']; 
    $event = EventManager::find($eventId);

    
    $this->loader = new FilesystemLoader('templates');
    $this->twig = new Environment($this->loader);
    echo $this->twig->render('events/formUpdate.html.twig',  ['lieu'=>$lieu, 'categorie'=>$categorie, 'auto_reload' => true , 'event'=> $event, 'session'=>$this->session]);
  }
}



public function update() {
  if(isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];

      if(empty($_POST['titre_event']) || empty($_POST['date_debut_event']) || empty($_POST['resume_event'])) {
          $message = "Les champs titre, date et resumé sont obligatoires";
          $loader = new FilesystemLoader('templates');
          $twig = new Environment($loader);
          echo $twig->render('events/formUpdate.html.twig', ['message' => $message]);
      } else {
          $eventId = $_GET['id_event'];
          $titre_event = $_POST['titre_event'];
          $date_debut = $_POST['date_debut_event'];
          $date_fin = !empty($_POST['date_fin_event']) ? $_POST['date_fin_event'] : '';
          $nb_places = $_POST['places'];
          $resume = $_POST['resume_event'];
          $description = !empty($_POST['description_event']) ? $_POST['description_event'] : '';
          $lieuId = $_POST["lieu"];
          $categorieId = $_POST['categorie'];

          $event = new Event();
          $event->setId_event($eventId);
          $event->setTitre_event($titre_event);
          $event->setDate_Debut_event($date_debut);
          $event->setDate_Fin_event($date_fin);
          $event->setNb_places($nb_places);
          $event->setResume_event($resume);
          $event->setDescription_event($description);
          $event->setId_lieu($lieuId);
          $event->setId_Categorie($categorieId);
          $event->setId_user($userId);

          EventManager::update($event);

          // Récupérer une liste d'événement correspondant à l'utilisateur
          $eventManager = new EventManager();
          $events = $eventManager->getEventById($userId);

          $categories = array();
          foreach ($events as $event) {
              $categorieId = $event->getId_Categorie();
              $categorie = CategorieManager::find($categorieId);
              $categories [] = $categorie;
          }

          $loader = new FilesystemLoader('templates');
          $twig = new Environment($loader);
          echo $twig->render('events/seeEvent.html.twig', ['list' => $events, 'categorie' => $categories, 'session'=>$this->session]);
      }
  }
}

  public function delete(){
    if(isset($_SESSION['user_id'])){
      $session = $_SESSION['user_id'];

      $eventId =  $_GET['id_event'];
      $event = EventManager::delete($eventId);

     // Récupérer une liste d'événement correspondant à l'utilisateur
     $eventManager = new EventManager();
     $events = $eventManager->getEventById($session);


     $categories = array();
     foreach ($events as $categorie) {
       $categorieId = $categorie->getId_Categorie();
       $categorie = CategorieManager::find($categorieId);
       $categories [] = $categorie;
   }

     $this->loader = new FilesystemLoader('templates');
     $this->twig = new Environment($this->loader);
     echo $this->twig->render('events/seeEvent.html.twig', [
       'list' => $events , 'categorie' => $categorie, 'session'=>$this->session
     ]);
}
}
  }

?>