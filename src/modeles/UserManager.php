<?php

namespace App\modeles;

use App\entites\User;
use App\controllers\UserController;
use \PDO;

class UserManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }


    public static function getLogin($login){

        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM utilisateur WHERE mail_user = :mail_user";
        $req = $db->prepare($sql);
        $req->execute(array(':mail_user' => $login));
        $reponse = $req->fetch();
        $user = new User($reponse);

        return $user;
    }

    public function addUser(User $user) {
        // Préparation de la requête SQL
        $req = $this->_db->prepare('INSERT INTO utilisateur (rs, email, nom, prenom, genre, password, tel, photo, badge, date_inscription, lieu_id, statut_id) VALUES(:rs, :email, :nom, :prenom, :password, :tel, :photo, :badge, :date_inscription, :lieu_id, :statut_id)');
        // Bind des valeurs
        $req->bindValue(':rs', $user->getRS());
        $req->bindValue(':email', $user->getMail_user());
        $req->bindValue(':nom', $user->getNom_user());
        $req->bindValue(':prenom', $user->getPrenom_user());
        $req->bindValue(':genre', $user->getGenre());
        $req->bindValue(':password', $user->getPassword());
        $req->bindValue(':tel', $user->getTel_user());
        $req->bindValue(':photo', $user->getPhoto());
        $req->bindValue(':badge', $user->getBadge());
        $req->bindValue(':date_inscription', $user->getDateInscription());
        $req->bindValue(':lieu_id', $user->getId_lieu());
        $req->bindValue(':statut_id', $user->getStatutId());
        // Exécution de la requête
        $req->execute();
    }

    public static function find($userId) {
        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM utilisateur WHERE id_user = :id_user');
        // Bind des valeurs
        $req->bindValue(':id_user', $userId);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new User($data);
    }

    public static function update(User $user) {

        $db = DbConnection::getInstance();
        // Préparation de la requête SQL
        $req = $db->prepare('UPDATE utilisateur 
                            SET raison_sociale = :rs,
                            mail_user = :email,
                            nom_user = :nom, 
                            prenom_user = :prenom, 
                            password = :password, 
                            tel_user = :telephone, 
                            id_lieu = :id_lieu
                            WHERE id_user = :id_user');

        // Bind des valeurs
        $req->bindValue(':rs', $user->getRaison_sociale() !== null ? $user->getRaison_sociale() : null, PDO::PARAM_STR);
        $req->bindValue(':email', $user->getMail_user());
        $req->bindValue(':nom', $user->getNom_user());
        $req->bindValue(':prenom', $user->getPrenom_user());
        $req->bindValue(':password', $user->getPassword());
        $req->bindValue(':telephone', $user->getTel_user());
        $req->bindValue(':id_lieu', $user->getId_lieu());
        $req->bindValue(':id_user', $user->getId_user());

        // Exécution de la requête
        $req->execute();

        $lieuManager = new LieuManager($db);
        $lieu = $lieuManager->find($user->getId_lieu());
        $user->setLieu($lieu);

        return $user;

        }

    public static function deleteProfil($id_user) {
        $db = DbConnection::getInstance();

        $req = $db->prepare("DELETE FROM utilisateur WHERE id_user = :id_user");

        $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $req->execute();

    }

}

?>

