<?php

namespace App\controllers;

use App\modeles\UserManager;
use App\entites\Event;
use App\entites\Lieu;
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


      // Récupérer les types de transports correspondant au transport
      $typeId = $transports->getID_Type_Transport();  
      $typeTransport = TypeTransportManager::find($typeId);


      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('transports/templateTransport.html.twig', array(
        'transport' => $transports,
        'localisation' => $localisation,
        'event' => $event,
        'type' => $typeTransport
    ));
    }

  }
?>