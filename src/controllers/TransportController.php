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
      if(isset($_SESSION['user_id'])){
        $this->session=true;
      }else{
        $this->session=false;
      }
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
        'user' => $user, 'session'=>$this->session
    ));
    }

    public function addTransport(){

      if(isset($_SESSION['user_id'])){
        $session=$_SESSION['user_id'];

      // Récupérer l'user correspondant à l'identifiant dans l'URL
      $user = UserManager::find($session);

      // Récupérer l'id participant correspondant à l'identifiant dans l'URL
      $participants = ParticipantManager::findById($session);

      $typeTransport = TypeTransportManager::findAll();

      $events = EventManager::findByParticipant($session);
      $idEvents = [];
      foreach ($events as $event){
          $idEvent = $event->getId_event();
          $idEvents[] = $idEvent;
      }

      $lieu= LieuManager::findAll();

      // Vérifier si le participant a déjà proposé un transport pour cet événement
      foreach ($events as $event){
          $transports = TransportManager::findByParticipant($session, $idEvents);
          if (!empty($transports)) {

              // Afficher un message d'erreur
              echo "Vous avez déjà proposé un transport pour l'événement " . $event->getTitre() . ".";
          }
      }


      $id_participants = array();
      for($i = 0; $i < count($participants); $i++) {
          $id_participants[] = $participants[$i]->getId_participant();
      }
        // Vérifier si l'identifiant de participant existe
        if (count($participants) < 1) {
        // Si l'identifiant de participant n'existe pas, rediriger l'utilisateur
        header("Location: ?controller=participant&action=TransportFailed");
        exit();

      
    }
    
      

      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);
      echo $this->twig->render('transports/addTransport.html.twig', array('lieu'=>$lieu, 'user'=> $user, 'listTypeTransport'=> $typeTransport, 'listEvent'=> $events, 'listParticipant' => $participants, 'session'=>$this->session));
      
    }
  }

  public function add(){

    if(isset($_SESSION['user_id'])){
      $session=$_SESSION['user_id'];


      if (empty($_POST['titre_event']) || empty($_POST['type_transport']) || empty($_POST['places']) || empty($_POST['prix']) || empty($_POST['contact']) || empty($_POST['date_depart']) || empty($_POST['heure_depart']) || empty($_POST['lieu']) ) {
        $messageTitre = "Le champs titre est obligatoire";
        $messagePlaces = "Le champs places est obligatoire";
        $messagePrix = "Le champs prix est obligatoire";
        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('transports/addTransport.html.twig', [
        'messageTitre' => $messageTitre, 'session'=>$this->session]);
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

    $id_participant = ParticipantManager::findParticipantByEvent($id_event,$session);

    $transport = new Transport();

    $transport->setId_event($id_event);
    $transport->setDate_depart_transport($date_depart);
    $transport->setNb_place($nb_place);
    $transport->setNb_dispo($nb_dispo);
    $transport->setHeure_depart($heure_depart);
    $transport->setHeure_arrivee($heure_arrivee);
    $transport->setDescriptif($content);
    $transport->setTarif($prix);
    $transport->setInfo_contact($contact);
    $transport->setId_type_transport($id_type_transport);
    $transport->setId_lieu($id_lieu);
    $transport->setId_participant($id_participant);

    $newTransport = TransportManager::add($id_event, $_POST['type_transport'], $_POST['date_depart'], $_POST['heure_depart'], $_POST['heure_arrivee'], $_POST['places'], $_POST['places'], $_POST['prix'], $_POST['contact'], $_POST['description'], $_POST["lieu"], $id_participant);

    // Récupérer la localisation correspondant au transport
    $localisationId = $transport->getId_lieu();
    $localisation = LieuManager::find($localisationId);

    // Récupérer l'événement correspondant au transport
    $eventId = $transport->getId_Event();
    $event = EventManager::find($eventId);

    // Récupérer les types de transports correspondant au transport
    $typeId = $transport->getID_Type_Transport();  
    $typeTransport = TypeTransportManager::find($typeId);

    $this->loader = new FilesystemLoader('templates');
    $this->twig = new Environment($this->loader);

    echo $this->twig->render('transports/templateTransport.html.twig', array(
      
      'transport' => $transport,
      'localisation' => $localisation,
      'event' => $event,
      'type' => $typeTransport, 'session'=>$this->session
    ));
    }
  }

  public function seeTransport()
    {
      if(isset($_SESSION['user_id'])){
        $session=$_SESSION['user_id'];

              // Récupérer le participant correspondant à l'identifiant dans l'URL
        $participant = ParticipantManager::findByUser($session);

        // Récupérer tous les participants associés à l'utilisateur
        $participants = ParticipantManager::findByUser($session, true);
        
        $id_participants = array();
        foreach ($participants as $participant) {
            $id_participants[] = $participant->getId_participant();
        }

        // Récupérer une liste de tous les transports associés aux participants
        $transportManager = new TransportManager();
        $transports = array();
        foreach ($id_participants as $id_participant) {
            $transports = array_merge($transports, $transportManager->getTransportByParticipant($id_participant));
        }

        $eventIds = array();
        foreach($transports as $transport){
          $eventId = $transport->getId_event();
          $eventIds[] = $eventId;

        }

        $events = array();
        foreach ($eventIds as $eventId) {
            $event = EventManager::find($eventId);
            $events[] = $event;
        }

        $lieu= LieuManager::findAll();

        $typeTransports = array();
        foreach ($transports as $transport) {
            $typeId = $transport->getId_type_transport();
            $typeTransport = TypeTransportManager::find($typeId);
            $typeTransports[] = $typeTransport;
        }

        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('transports/seeTransport.html.twig',  ['user'=>$session, 'auto_reload' => true , 'list'=> $transports, 'typeTransport' => $typeTransports, 'event'=> $events, 'lieu' => $lieu, 'session'=>$this->session]);
              
      }
    }


    public function formUpdate(){

      if(isset($_SESSION['user_id'])){
        $session = $_SESSION['user_id'];

        $participantId = ParticipantManager::findByUser($session);

        $lieu= LieuManager::findAll();
        $typeTransport = TypeTransportManager::findAll();

        $transportId =  $_GET['id_transport'];
        $transport = TransportManager::find($transportId);
        
        $eventId = $transport->getId_event();
        $event = EventManager::find($eventId); 

        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('transports/formUpdate.html.twig',  ['lieu'=>$lieu, 'list'=> $typeTransport, 'auto_reload' => true , 'transport'=> $transport, 'event'=>$event, 'session'=>$this->session]);
      }
    }



  public function update() {

    if(isset($_SESSION['user_id'])){
      $session = $_SESSION['user_id'];

    // Vérifier si l'utilisateur est connecté et s'il a les autorisations nécessaires
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $session) {
      $transportId = $_POST['transport_id'];
      
      // Vérifier si le transport existe et s'il appartient à l'utilisateur
      $transport = TransportManager::find($transportId);

      $participantId = ParticipantManager::findByUser($session);
      if($transport && $transport->getId_participant() == $participantId) {
        // Traitement des données de formulaire et mise à jour du transport
        $session = $_SESSION['user_id'];
        // Récupérer le participant correspondant à l'identifiant dans l'URL
        $participantId = ParticipantManager::findByUser($session);
        
        if(empty($_POST['type_transport']) || empty($_POST['date_depart']) || empty($_POST['lieu']) || empty($_POST['contact']) || empty($_POST['prix']) ) {
            $message = "Les champs type de transport, date, ville, contact et prix sont obligatoires";
            $loader = new FilesystemLoader('templates');
            $twig = new Environment($loader);
            echo $twig->render('transports/formUpdate.html.twig', ['message' => $message, 'session'=>$this->session]);

        } else {

            $transportId = $_POST['transport_id'];
            $typeTransportId = $_POST['type_transport'];
            $date_depart = $_POST['date_depart'];
            $heure_depart = $_POST['heure_depart'];
            $heure_arrivee = !empty($_POST['heure_arrivee']) ? $_POST['heure_arrivee'] : '';
            $info_contact = $_POST['contact'];
            $prix = $_POST['prix'];
            $nb_places = !empty($_POST['places']) ? $_POST['places'] : '';
            $description = !empty($_POST['description']) ? $_POST['description'] : '';
            $lieuId = $_POST["lieu"];
            $eventId = $_POST['event_id'];

            $transport = new Transport();
            $transport->setId_event($eventId);
            $transport->setId_lieu($lieuId);
            $transport->setId_type_transport($typeTransportId);
            $transport->setDate_depart_transport($date_depart);
            $transport->setHeure_depart($heure_depart);
            $transport->setHeure_arrivee($heure_arrivee);
            $transport->setNb_dispo($nb_places);
            $transport->setTarif($prix);
            $transport->setInfo_contact($info_contact);
            $transport->setDescriptif($description);
            $transport->setId_participant($participantId);
            $transport->setId_mdt($transportId);

            TransportManager::update($transport);

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
            echo $this->twig->render('transports/seeTransport.html.twig',  ['user'=>$session, 'auto_reload' => true , 'list'=> $transports, 'typeTransport' => $typeTransports, 'event'=> $eventId, 'session'=>$this->session]);
        }
      } else {
        // Le transport n'existe pas ou n'appartient pas à l'utilisateur
        // Afficher un message d'erreur ou rediriger vers une page d'erreur
        echo "Transport n'existe pas ou ne vous appartient pas";
      }
    } else {
      // L'utilisateur n'est pas connecté ou n'a pas les autorisations nécessaires
      // Afficher un message d'erreur ou rediriger vers une page de connexion
      echo "Vous ne pouvez pas faire ça";
    }
  }

  }

  public function delete(){
    if(isset($_SESSION['user_id'])){
      $session = $_SESSION['user_id'];

      $transportId =  $_GET['id_transport'];

      $transport = TransportManager::delete($transportId);
      $messageDelete = "Le transport a bien été supprimé";
      // Récupérer le participant correspondant à l'identifiant dans l'URL
      $participantId = ParticipantManager::findByUser($session);
      
      header("Location: ?controller=users&action=profil&id=$session");
        exit();
  }
    }
}

?>