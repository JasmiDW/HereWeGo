<?php

namespace App\controllers;


use App\entites\Event;
use App\entites\Lieu;
use App\entites\TypeTransport;
use App\entites\Categorie;
use App\modeles\EventManager;
use App\modeles\UserManager;
use App\modeles\PageManager;
use App\modeles\LieuManager;
use App\modeles\ParticipantManager;
use App\modeles\TransportManager;
use App\modeles\TypeTransportManager;
use App\modeles\CategorieManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


  class EventsController {

    private $eventManager;
    private $transportManager;

    public function __construct(){
        $this->eventManager = new EventManager();
        $this->transportController = new TransportManager();
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

      $localisations = array();
      foreach ($listTransports as $transport) {
        $localisationId = $transport->getId_lieu();
        $localisation = LieuManager::find($localisationId);
        $localisations[] = $localisation;
      
      // Récupérer les types de transports correspondant à chaque transport
      $typeId = $transport->getID_Type_Transport();  
      $typeTransport = TypeTransportManager::find($typeId);

      var_dump($localisation);
      }
      
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
    
      echo $this->twig->render('events/templateEvent.html.twig', array(
        'event' => $event,
        'user' => $user,
        'localisation' => $localisation,
        'remainingPlaces' => $remainingPlaces,
        'listTransports' => $listTransports,
        'typeTransport' => $typeTransport,
        'categorie' => $categorie
      ));
    }

    public function addEvent(){

      $lieu= LieuManager::findAll();
      $categorie = CategorieManager::findAll();


      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('events/addEvent.html.twig', array('lieu'=>$lieu, 'categorie'=>$categorie));
      
    }

    public function add(){
       
      $session=$_SESSION['user'];
      if (empty($_POST['titre']) || empty($_POST['debut']) || empty($_POST['lieu']) || empty($_POST['categorie']) || empty($_POST['resume'])) {
        throw new Exception('Merci de remplir les données nécessaires.');
    }

    $titre_event = $_POST['titre'];
    $date_debut = $_POST['date_debut_event'];
    $date_fin = !empty($_POST['date_fin_event']) ? $_POST['date_fin_event'] : '';
    $lieu = $_POST['lieu'];
    $categorie= $_POST['categorie'];
    $nb_place= $_POST['places'];
    $resume = $_POST['resume_event'];
    $content = !empty($_POST['description']) ? $_POST['description'] : '';

    if (isset($_FILES['photo']['name'])) {
        
        $fileName = $_FILES['photo']['name'];
        $fileNameArray = explode(".", $fileName);
        $extension = end($fileNameArray);
        $uploadedFileName = $date_debut. "." . $extension;
        $uploadedFileName = filter_var($uploadedFileName, FILTER_SANITIZE_STRING);
        $fileToUpload = "public/media/" . $uploadedFileName;
    
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $fileToUpload)) {
            $photo = $fileToUpload;
        } else {
            throw new Exception('Erreur lors du téléchargement de l\'image.');
        }
    } else {
        $photo = $_POST['photo_old'];
    }

    // Récupérer l'objet Lieu correspondant au nom du lieu
    $lieu = LieuManager::findByNom($nom_lieu);

    // Récupérer l'ID du lieu
    $id_lieu = $lieu->getId_lieu();

        
    $event = new Event();

    $event->setTitre_event($titre_event);
    $event->setDate_Debut_event($date_debut);
    $event->setDate_Fin_event($date_fin);
    $event->setNb_places($nb_place);
    $event->setResume_event($resume);
    $event->setDescription_event($content);
    $event->setId_Categorie($categorie);
    $event->setId_lieu($lieu);


    $id_event = EventManager::add($event);
 
     echo $this->twig->render('events/templateEvent.html.twig', [
        'id_event' => $id_event]);
    }
      

    public function seeEvent()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('events/seeEvent.html.twig');
      
    }
}

?>