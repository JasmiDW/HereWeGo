<?php

namespace App\modeles;

use App\entites\User;
use App\controllers\UserController;

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
        $req->bindValue(':tel', $user->getTel());
        $req->bindValue(':photo', $user->getPhoto());
        $req->bindValue(':badge', $user->getBadge());
        $req->bindValue(':date_inscription', $user->getDateInscription());
        $req->bindValue(':lieu_id', $user->getLieuId());
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

    public function updateUser(User $user) {
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

        $utilisateur=new User($result);
        return $utilisateur;

    }

    public function deleteUser(User $user) {
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
            $user = new User($data);
            $users[] = $user;
        }
        return $users;
    }
}

?>

