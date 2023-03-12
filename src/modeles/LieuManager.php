<?php

namespace App\modeles;

use App\entites\Lieu;
use App\controllers\LieuController;

class LieuManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }


    public static function find($idLieu) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM lieux WHERE id_lieu = :id_lieu');
        // Bind des valeurs
        $req->bindValue(':id_lieu', $idLieu);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new Lieu($data);
    }

    public static function findAll() {

        $db = DbConnection::getInstance();

        $listVille = [];
        $req = $db->prepare('SELECT * FROM lieux ');
        $req->execute();
        $reponse= $req->fetchAll();
        foreach( $reponse as $data){
          $listVille[] = new Lieu($data);
        }
        return $listVille;
    }

    public static function findByVille($nomLieu) {

      $db = DbConnection::getInstance();
      // instancier la connexion à la base de données
      // Préparation de la requête SQL
      $req = $db->prepare('SELECT id_lieu FROM lieux WHERE ville = :ville');
      // Bind des valeurs
      $req->bindValue(':ville', $nomLieu);
      // Exécution de la requête
      $req->execute();
      // Récupération du résultat
      $data = $req->fetch();
      // Création de l'objet Utilisateur correspondant
      return new Lieu($data);
  }

  
}