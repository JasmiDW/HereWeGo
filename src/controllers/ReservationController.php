<?php

namespace App\controllers;

use App\modeles\UserManager;
use App\entites\Event;
use App\entites\Participant;
use App\entites\Reservation;
use App\modeles\EventManager;
use App\modeles\LieuManager;
use App\modeles\ParticipantManager;
use App\modeles\ReservationManager;
use App\modeles\TransportManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ReservationController{

    private $ReservationManager;

    public function __construct(){
        $this->reservationManager = new ReservationManager();
    }


    public function add()
    {
        if(isset($_SESSION['user_id'])){
            $session=$_SESSION['user_id'];
    
            // Récupérer le transport correspondant à l'ID
            $transportId = $_GET['id'];
            $transportManager = new TransportManager();
            $transport = $transportManager->find($transportId);
    
            // Récupérer l'événement correspondant au transport
            $eventId = $transport->getId_Event();
            $eventManager = new EventManager();
            $event = $eventManager->find($eventId);
            
            //Récupérer le participant correspondant à l'id user
            $participantManager = new ParticipantManager();
            $participant = $participantManager->findByUserEvent($session,$event->getId_event());
    
            // Ajouter une reservation pour le participant
            $date = date("Y-m-d");
            if(isset($_POST['places'])){
                $places = $_POST['places'];
                
                // Vérifier si la réservation est possible
                $remainingPlaces = $transportManager->remainingPlaces($transportId);
                if ($remainingPlaces < $places) {
                    // Afficher un message d'erreur si la réservation n'est pas possible
                    // ...
                } else {
                    // Ajouter la réservation
                    $reservationManager = new ReservationManager();
                    $reservation = new Reservation();
                    $reservation->setId_participant($participant->getId_event());
                    $reservation->setDate($date);
                    $reservation->setId_transport($transportId);
                    $reservation->setNb_place($places);
                    $reservationManager->add($reservation);
    
                    // Mettre à jour le nombre de places disponibles pour le transport
                    $transport->setNb_dispo($transport->getNb_dispo() - $places);
                    $transportManager->update($transport);
                }

                
            }

            header("location: ?controller=reservation&action=success");
    }
} 
    public function success(){
            $message = "Merci de votre réservation à ce transport. Hâte de vous retrouver !";
            $this->loader = new FilesystemLoader('templates');
            $this->twig = new Environment($this->loader);
            echo $this->twig->render('reservation/success.html.twig', [
            'message' => $message]);

    }
//     public function addR(){
//         if(isset($_SESSION['user_id'])) {
//             $userId = $_SESSION['user_id'];

//             $eventId = $_GET['id'];

//             $participant = New Participant();

//             $participant->setId_event($eventId);
//             $participant->setId_user($userId);

//             $id_participant = ParticipantManager::add($participant);

//             $message = "Merci de votre participation à cet événement. Hâte de vous retrouver !";
//             $this->loader = new FilesystemLoader('templates');
//             $this->twig = new Environment($this->loader);
//             echo $this->twig->render('pages/participationSuccess.html.twig', [
//             'message' => $message]);

//     }

// }

//     public function TransportFailed(){
//         if(isset($_SESSION['user_id'])) {
//             $userId = $_SESSION['user_id'];

//             $message = "Vous devez participer à un événement avant de pourvoir proposer un transport.";
//             $this->loader = new FilesystemLoader('templates');
//             $this->twig = new Environment($this->loader);
//             echo $this->twig->render('transports/transportFailed.html.twig', [
//             'message' => $message]);
//         }
//     }
    
}

?>