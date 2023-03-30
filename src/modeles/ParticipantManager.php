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

    

    public static function add(Participant $participant) {
        $db = DbConnection::getInstance();
        // Préparation de la requête SQL
        $req = $db->prepare('INSERT INTO participant ( id_event, id_user) VALUES( :id_event, :id_user)');
        // Bind des valeurs
        $req->bindValue(':id_event', $participant->getId_event());
        $req->bindValue(':id_user', $participant->getId_user());
        // Exécution de la requête
        $req->execute();
    }

    public static function findByUser($idUser) {
        $db = DbConnection::getInstance();
        $list = [];
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM participant WHERE id_user = :id_user');
        // Bind des valeurs
        $req->bindValue(':id_user', $idUser);
        // Exécution de la requête
        $req->execute();
        $results=$req->fetchAll(PDO::FETCH_ASSOC);
   
      foreach($results as $participant) {
           $list[] = new Participant($participant);
      }
   
       return $list;
    }

    public static function findById($idUser) {
        $db = DbConnection::getInstance();
        $list = [];
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT id_participant FROM participant WHERE id_user = :id_user');
        // Bind des valeurs
        $req->bindValue(':id_user', $idUser);
        // Exécution de la requête
        $req->execute();
        $results=$req->fetchAll(PDO::FETCH_ASSOC);
   
      foreach($results as $participant) {
           $list[] = new Participant($participant);
      }
   
       return $list;
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

    public static function findUser($idParticipant) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT id_user FROM participant WHERE id_participant = :id_participant');
        // Bind des valeurs
        $req->bindValue(':id_participant', $idParticipant);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new Participant($data);
    }

    public static function findParticipant($idUser) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        $list = [];
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM participant WHERE id_user = :id_user');
        // Bind des valeurs
        $req->bindValue(':id_user', $idUser);
        // Exécution de la requête
        $req->execute();
        $results=$req->fetchAll(PDO::FETCH_ASSOC);
   
        foreach($results as $participant) {
             $list[] = new Participant($participant);
        }
     
         return $list;
    }

    public static function findByUserEvent($idUser, $idEvent) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        $list = [];
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM participant WHERE id_user = :id_user AND id_event = :id_event');
        // Bind des valeurs
        $req->bindValue(':id_user', $idUser);
        $req->bindValue(':id_event', $idEvent);
        // Exécution de la requête
        $req->execute();
        $results=$req->fetchAll(PDO::FETCH_ASSOC);
   
        foreach($results as $participant) {
             $list[] = new Participant($participant);
        }
     
         return $list;
    }

    public static function countParticipants($idEvent) {
        $db = DbConnection::getInstance();
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT COUNT(*) FROM participant WHERE id_event = :id_event');
        // Bind des valeurs
        $req->bindValue(':id_event', $idEvent);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $count = $req->fetchColumn();
        // Retourner le nombre de participants
        return $count;
    }

    public static function deleteByUser($userId){
        $db = DbConnection::getInstance();
        $userId = intval($userId);
          $query = $db->prepare("DELETE FROM participant WHERE id_user =:id_user");
          $query->bindValue(':id_user', $userId, PDO::PARAM_INT);
          $query->execute();
    }

    public static function findParticipantByEvent($idEvent, $idUser) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données

        // Préparation de la requête SQL
        $req = $db->prepare('SELECT id_participant FROM participant WHERE id_event = :id_event AND id_user = :id_user');
        // Bind des valeurs
        $req->bindValue(':id_event', $idEvent, PDO::PARAM_INT);
        $req->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        // Exécution de la requête
        $req->execute();

        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return $data['id_participant'];
    }

    public static function findMedia($idUser, $idParticipant) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données

        // Préparation de la requête SQL
        $req = $db->prepare('SELECT url_photo, utilisateur.id_user,id_participant FROM utilisateur 
        INNER JOIN participant ON utilisateur.id_user = participant.id_user
        WHERE utilisateur.id_user = :id_user AND participant.id_participant = :id_participant LIMIT 1');
        // Bind des valeurs
        $req->bindValue(':id_participant', $idParticipant, PDO::PARAM_INT);
        $req->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        // Exécution de la requête
        $req->execute();

        // Récupération du résultat
        $data = $req->fetch();

        return $data['url_photo'];
    }

}

?>