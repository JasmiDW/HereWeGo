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

    public function addEvent()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('events/addEvent.html.twig');
      
    }

    public function seeEvent()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('events/seeEvent.html.twig');
      
    }




}

?>