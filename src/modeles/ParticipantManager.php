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

    public static function find($idParticipant) {
        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM participant WHERE id_particpant = :id_participant');
        // Bind des valeurs
        $req->bindValue(':id_participant', $idParticipant);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new Participant($data);
    }

    public function updateUser(Utilisateur $user) {
        // Préparation de la requête SQL
        $req = $this->_db->prepare('UPDATE utilisateur SET email = :email, nom = :nom, prenom = :prenom, password = :password, tel = :tel, photo = :photo , lieu_id = :lieu_id WHERE id_user = :id_user');

        // Bind des valeurs
        $req->bindValue(':email', $user->getMail_user());
        $req->bindValue(':nom', $user->getNom_user());
        $req->bindValue(':prenom', $user->getPrenom_user());
        $req->bindValue(':password', $user->getPassword());
        $req->bindValue(':tel', $user->getTel());
        $req->bindValue(':photo', $user->getPhoto());

        $req->bindValue(':date_inscription', $user->getDateInscription());
        $req->bindValue(':lieu_id', $user->getLieuId());


        // Vérification de la valeur de la raison sociale
        if ($user->getRS() !== null) {
            $req->bindValue(':rs', $user->getRS());
        } else {
            $req->bindValue(':rs', null, PDO::PARAM_NULL);
        }

        // Exécution de la requête
        $req->execute();

        $lieuManager = new LieuManager($this->_db);
        $lieu = $lieuManager->getLieuById($user->getLieuId());
        $user->setLieu($lieu);

        $result=$req->fetch(PDO::FETCH_ASSOC);

        $utilisateur=new Utilisateur($result);
        return $utilisateur;

    }

    public function deleteUser(Utilisateur $user) {
        $sql = "DELETE FROM utilisateur WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $user->getId_user(), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $users = [];
        foreach ($result as $data) {
            $user = new Utilisateur($data);
            $users[] = $user;
        }
        return $users;
    }

}

?>