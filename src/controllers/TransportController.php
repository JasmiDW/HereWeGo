<?php

namespace App\controllers;

use App\modeles\UserManager;
use App\entites\Event;
use App\entites\Lieu;
use App\entites\Participant;
use App\entites\Transport;
use App\modeles\EventManager;
use App\modeles\PageManager;
use App\modeles\LieuManager;
use App\modeles\ParticipantManager;
use App\modeles\TransportManager;
use App\modeles\TypeTransportManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


  class TransportController {

    private $transportManager;


    public function __construct(){
      $this->transportManager = new TransportManager();
    }

    public function getTransport()
    {
      $transports = TransportManager::getTransport();
      return $transports;
    }

    public function show() {
      
      if (!isset($_GET['id'])) {
        return call('pages', 'error');
      }

      // Récupérer le transport correspondant à l'identifiant dans l'URL
      $transportId = $_GET['id'];
      $transports = TransportManager::find($transportId);

      // Récupérer la localisation correspondant au transport
      $localisationId = $transports->getId_lieu();
      $localisation = LieuManager::find($localisationId);

      // Récupérer l'événement correspondant au transport
      $eventId = $transports->getId_Event();
      $event = EventManager::find($eventId);

      //Récupérer le participant correspondant au transport
      $participantId = $transports->getId_participant();

      $userId = ParticipantManager::findUser($participantId);
      $user = UserManager::find($userId);

      var_dump($user);

      // Récupérer les types de transports correspondant au transport
      $typeId = $transports->getID_Type_Transport();  
      $typeTransport = TypeTransportManager::find($typeId);

      $nbPlacesDispo = TransportManager::getNbDispo($transportId);


      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('transports/templateTransport.html.twig', array(
        'transport' => $transports,
        'localisation' => $localisation,
        'event' => $event,
        'type' => $typeTransport,
        'nbPlacesDispo' => $nbPlacesDispo,
        'user' => $user
    ));
    }

    public function addTransport(){

      if(isset($_SESSION['user_id'])){
        $session=$_SESSION['user_id'];
        $id_user = ['user_id'];

      // Récupérer l'user correspondant à l'identifiant dans l'URL
      $userId = $_GET['id'];
      $user = UserManager::find($userId);

      // Récupérer l'id participant correspondant à l'identifiant dans l'URL
      $participant = ParticipantManager::findByUser($userId);

      $typeTransport = TypeTransportManager::findAll();

      $event = EventManager::findByParticipant($userId);

      $lieu= LieuManager::findAll();

      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('transports/addTransport.html.twig', array('lieu'=>$lieu, 'user'=> $user, 'listTypeTransport'=> $typeTransport, 'listEvent'=> $event, 'participant' => $participant));
      
    }
  }

  public function add(){

    if(isset($_SESSION['user_id'])){
      $session=$_SESSION['user_id'];
      $id_user = ['user_id'];

      if (empty($_POST['titre_event']) || empty($_POST['type_transport']) || empty($_POST['places']) || empty($_POST['prix']) || empty($_POST['contact']) || empty($_POST['date_depart']) || empty($_POST['heure_depart']) || empty($_POST['lieu']) ) {
        $messageTitre = "Le champs titre est obligatoire";
        $messagePlaces = "Le champs places est obligatoire";
        $messagePrix = "Le champs prix est obligatoire";
        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('transports/addTransport.html.twig', [
        'messageTitre' => $messageTitre]);
    }

    $id_event = $_POST['titre_event'];
    $id_type_transport = $_POST['type_transport'];
    $date_depart = $_POST['date_depart'];
    $heure_depart = $_POST['heure_depart'];
    $heure_arrivee = !empty($_POST['heure_arrivee']) ? $_POST['heure_arrivee'] : '';
    $nb_place= $_POST['places'];
    $nb_dispo= $_POST['places'];
    $prix = $_POST['prix'];
    $contact = $_POST['contact'];
    $content = !empty($_POST['description']) ? $_POST['description'] : '';
    $id_lieu = $_POST["lieu"];
    $id_participant = $_POST['id_participant'];


    $transport = new Transport();

    $transport->setId_event($id_event);
    $transport->setDate_depart_transport($date_depart);
    $transport->setNb_place($nb_place);
    $transport->setNb_dispo($nb_dispo);
    $transport->setHeure_depart($heure_depart);
    $transport->setHeure_arrivee($heure_arrivee);
    $transport->setDescriptif($content);
    $transport->setTarif($prix);
    $transport->setContact($contact);
    $transport->setId_type_transport($id_type_transport);
    $transport->setId_lieu($id_lieu);
    $transport->setId_participant($id_participant);

    $newTransport = TransportManager::add($transport);

    // Récupérer la localisation correspondant au transport
    $localisationId = $transport->getId_lieu();
    $localisation = LieuManager::find($localisationId);

    // Récupérer l'événement correspondant au transport
    $eventId = $transport->getId_Event();
    $event = EventManager::find($eventId);

    // Récupérer les types de transports correspondant au transport
    $typeId = $transport->getID_Type_Transport();  
    $typeTransport = TypeTransportManager::find($typeId);

    //Récupérer l'user correspondant au transport

    $this->loader = new FilesystemLoader('templates');
    $this->twig = new Environment($this->loader);

    echo $this->twig->render('transports/templateTransport.html.twig', array(
      'transport' => $transport,
      'localisation' => $localisation,
      'event' => $event,
      'type' => $typeTransport
    ));
    }
  }

  public function seeTransport()
    {
      if(isset($_SESSION['user_id'])){
        $session=$_SESSION['user_id'];

      // Récupérer le participant correspondant à l'identifiant dans l'URL
      $userId = $_GET['id'];
      $participantId = ParticipantManager::find($userId);

      // Récupérer une liste d'événement correspondant à l'utilisateur
      $transportManager = new TransportManager();
      $transports = $transportManager->getTransportByParticipant($participantId);

      //Récupérer les événements correspondants aux transport 
      $eventId = EventManager::find($participantId);
      
      
      
      $typeTransports = array();
      foreach ($transports as $transport) {
          $typeId = $transport->getId_type_transport();
          $typeTransport = TypeTransportManager::find($typeId);
          $typeTransports[] = $typeTransport;
      }

      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('transports/seeTransport.html.twig',  ['user'=>$user, 'auto_reload' => true , 'list'=> $transports, 'typeTransport' => $typeTransports, 'event'=> $eventId]);
      
    }
  }

  public function formUpdate(){

    if(isset($_SESSION['user_id'])){
      $session = $_SESSION['user_id'];

    $lieu= LieuManager::findAll();
    $typeTransport = TypeTransportManager::findAll();

    $transportId =  $_GET['id_transport'];
    $transport = TransportManager::find($transportId);
    
    $eventId = $transport->getId_event();
    $event = EventManager::find($eventId); 

    $this->loader = new FilesystemLoader('templates');
    $this->twig = new Environment($this->loader);
    echo $this->twig->render('transports/formUpdate.html.twig',  ['lieu'=>$lieu, 'list'=> $typeTransport, 'auto_reload' => true , 'transport'=> $transport, 'event'=>$event]);
  }
}



public function update() {
  if(isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];

      if(empty($_POST['type_transport']) || empty($_POST['date_depart']) || empty($_POST['lieu'])  || empty($_POST['contact'])) {
          $message = "Les champs type de transport, date, ville et contact sont obligatoires";
          $loader = new FilesystemLoader('templates');
          $twig = new Environment($loader);
          echo $twig->render('transports/formUpdate.html.twig', ['message' => $message]);
      } else {
          $transportId = $_GET['id_transport'];
          $type_transport = $_POST['type_transport'];
          $date_depart = $_POST['date_depart'];
          $heure_depart = $_POST['heure_depart'];
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
          echo $twig->render('events/seeEvent.html.twig', ['list' => $events, 'categorie' => $categories]);
      }
  }
}

}

?>