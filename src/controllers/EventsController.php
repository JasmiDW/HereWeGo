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

      if (empty($_POST['titre']) || empty($_POST['debut']) || empty($_POST['fin']) || empty($_POST['lieu']) || empty($_POST['categorie'])) {
        throw new Exception('Merci de remplir les données nécessaires.');
    }

    $titre_event = $_POST['titre'];
    $prenom_artist = !empty($_POST['debut']) ? $_POST['debut'] : '';
    $date_naissance = $_POST['date_naissance'];
    $date_deces = !empty($_POST['date_deces']) ? $_POST['date_deces'] : '';
    $site_internet = !empty($_POST['site_internet']) ? $_POST['site_internet'] : '';
    $nationalite = $_POST['nationalite'];
    $categorie1_artist = !empty($_POST['categorie1_artist']) ? $_POST['categorie1_artist'] : '';
    $categorie2_artist = !empty($_POST['categorie2_artist']) ? $_POST['categorie2_artist'] : '';

    if (isset($_FILES['photo']['name'])) {
        
        $fileName = $_FILES['photo']['name'];
        $fileNameArray = explode(".", $fileName);
        $extension = end($fileNameArray);
        $uploadedFileName = $nom_artist. "." . $extension;
        $uploadedFileName = filter_var($uploadedFileName, FILTER_SANITIZE_STRING);
        $fileToUpload = "uploads/profil_artiste/" . $uploadedFileName;
    
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $fileToUpload)) {
            $photo = $fileToUpload;
        } else {
            throw new Exception('Erreur lors du téléchargement de l\'image.');
        }
    } else {
        $photo = $_POST['photo_old'];
    }

        
    $event = new Event();

    $event->setNom_artist($nom_artist);
    $event->setPrenom_artist($prenom_artist);
    $event->setPhoto($photo);
    $event->setDate_naissance($date_naissance);
    $event->setDate_deces($date_deces);
    $event->setNationalite($nationalite);
    $event->setSite_Internet($site_internet);
    $event->setCategorie1_artist($categorie1_artist);
    $event->setCategorie2_artist($categorie2_artist);

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