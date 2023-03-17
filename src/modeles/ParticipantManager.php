<?php

namespace App\modeles;

use App\entites\Participant;
use App\controllers\ParticpantController;
use App\entites\Event;
use \PDO;

class ParticipantManager {

    private $_db;

    public function __construct(){
        $this->_db = DbConnection::getInstance();
    }

    public static function countByEvent(Event $event) {
        // On récupère la connexion à la base de données
        $db = DbConnection::getInstance();
        // On prépare la requête SQL pour compter le nombre de participants pour l'événement
        $stmt = $db->prepare("SELECT COUNT(*) FROM participant WHERE id_event = :id_event");
        // On lie le paramètre :id_event avec l'ID de l'événement
        $stmt->bindValue(":id_event", $event->getId_event(), PDO::PARAM_INT);
        // On exécute la requête SQL
        $stmt->execute();
        // On récupère le nombre de participants pour l'événement
        $count = $stmt->fetchColumn();
        // On renvoie le nombre de participants
        return $count;
        
    }

    public function addParticipant(Participant $participant, $statut) {
        $db = DbConnection::getInstance();
        // Préparation de la requête SQL
        $req = $this->_db->prepare('INSERT INTO participant (statut, id_event, id_user) VALUES(:statut, :id_event, :id_user)');
        // Bind des valeurs
        $req->bindValue(':statut', $statut);
        $req->bindValue(':id_event', $participant->getId_event());
        $req->bindValue(':id_user', $participant->getId_user());
        // Exécution de la requête
        $req->execute();
    }

    public static function findByUser($idUser) {
        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM participant WHERE id_user = :id_user');
        // Bind des valeurs
        $req->bindValue(':id_user', $idUser);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new Participant($data);
    }

    public static function find($idParticipant) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM participant WHERE id_participant = :id_participant');
        // Bind des valeurs
        $req->bindValue(':id_participant', $idParticipant);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new Participant($data);
    }


}

?>