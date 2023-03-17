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

      //Récupérer l'user correspondant au transport
      $participantId = $transports->getId_participant();
      $participant = ParticipantManager::find($participantId);
      $userParticipant = UserManager::find($participant);
      var_dump($participantId);

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
    var_dump($transport);

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
}

?>