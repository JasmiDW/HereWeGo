<?php

namespace App\modeles;

use App\entites\Media;
use App\controllers\MediaController;

class MediaManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function addMedia(Media $user) {
        // Préparation de la requête SQL
        $req = $this->_db->prepare('INSERT INTO media (url, id_event) VALUES(:url, :id_event)');
        // Bind des valeurs
        $req->bindValue(':url', $media->getURL());
        $req->bindValue(':id_event', $media->getId_event());
        // Exécution de la requête
        $req->execute();
    }

    public static function find($idMedia) {
        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM media WHERE id_media = :id_media');
        // Bind des valeurs
        $req->bindValue(':id_media', $idMedia);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new Media($data);
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