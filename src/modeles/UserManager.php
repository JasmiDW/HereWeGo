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

    public static function add(User $user) {

        $db = DbConnection::getInstance();

        
        // Préparation de la requête SQL
        $req = $db->prepare('INSERT INTO utilisateur (raison_sociale, mail_user, nom_user, prenom_user, genre, password, tel_user, date_inscription, id_lieu, id_statut) VALUES(:raison_sociale, :mail_user, :nom_user, :prenom_user, :genre, :pwhHash, :tel_user, :date_inscription, :id_lieu, :id_statut)');
        // Bind des valeurs
        $req->bindValue(':raison_sociale', $user->getRaison_sociale(),PDO::PARAM_STR);
        $req->bindValue(':mail_user', $user->getMail_user(),PDO::PARAM_STR);
        $req->bindValue(':nom_user', $user->getNom_user(),PDO::PARAM_STR);
        $req->bindValue(':prenom_user', $user->getPrenom_user(),PDO::PARAM_STR);
        $req->bindValue(':genre', $user->getGenre(),PDO::PARAM_INT);
        $req->bindValue(':pwhHash', $user->getPassword(), PDO::PARAM_STR);
        $req->bindValue(':tel_user', $user->getTel_user(),PDO::PARAM_STR);
        $req->bindValue(':date_inscription', $user->getDateInscription(),PDO::PARAM_STR);
        $req->bindValue(':id_lieu', $user->getId_lieu(),PDO::PARAM_INT);
        $req->bindValue(':id_statut', $user->getId_statut(),PDO::PARAM_INT);
        // Exécution de la requête
        $req->execute();

        $id_user = $db->lastInsertId();
        return $id_user;
    }

    public static function find($userId) {

        $db = DbConnection::getInstance();
        $userId = intval($userId);
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

    public static function updateProfileImage(User $obj){
            
        $db = DbConnection::getInstance();
    
        $sql="UPDATE utilisateur SET url_photo = :url_photo WHERE id_user = :id_user";
            
            $query = $db ->prepare($sql);
            $query->bindValue(':id_user',$obj->getId_user(), PDO::PARAM_INT);
            $query->bindValue(':url_photo', $obj->getUrl_photo(), PDO::PARAM_STR);

            $query->execute();
            
            return $obj;
    }

}

?>

