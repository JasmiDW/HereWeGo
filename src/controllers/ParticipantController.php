<?php

namespace App\controller;

use App\modeles\UserManager;
use App\entites\Event;
use App\entites\Participant;
use App\modeles\EventManager;
use App\modeles\LieuManager;
use App\modeles\ParticipantManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ParticipantController {

    private $ParticipantManager;

    public function __construct(){
        $this->participantManager = new ParticipantManager();
    }


    public function addParticipant($id_event)
    {
        // Vérifier que l'utilisateur est connecté
        if (!$this->session->get('user')) {
            // Rediriger vers la page de connexion
            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);

            echo $this->twig->render('pages/connexion.html.twig');
        } 
        
        // Récupérer l'événement correspondant à l'ID
            $eventManager = new EventManager();
            $event = $eventManager->show($id_event);

            // Ajouter l'utilisateur comme participant
            $participantManager = new ParticipantManager();
            $userConnexion = $this->session->get('user');
            $participant = new Participant($userConnexion->getId_user(), $event);
            $participantManager->addParticipant($participant);

            // Récupérer les informations nécessaires pour afficher la page de l'événement
            $user = UserManager::find($events->getId_User());
            $localisation = LieuManager::find($events->getId_lieu());
            $remainingPlaces = $eventsManager->remainingPlaces($events);

            // Afficher la page de l'événement
            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);

            echo $this->twig->render('events/templateEvent.html.twig', array(
                'event' => $event,
                'user' => $user,
                'localisation' => $localisation,
                'remainingPlaces' => $remainingPlaces,
            ));
    }
    
}

?>