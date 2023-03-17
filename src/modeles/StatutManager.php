<?php

namespace App\modeles;

use App\entites\Statut;
use App\controllers\StatutController;

class StatutManager {

    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }


    public static function find($idStatut) {

        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        // Préparation de la requête SQL
        $req = $db->prepare('SELECT * FROM statut WHERE id_statut = :id_statut');
        // Bind des valeurs
        $req->bindValue(':id_statut', $idStatut);
        // Exécution de la requête
        $req->execute();
        // Récupération du résultat
        $data = $req->fetch();
        // Création de l'objet Utilisateur correspondant
        return new Statut($data);
    }

    public static function findAll() {

        $db = DbConnection::getInstance();

        $listStatut = [];
        $req = $db->prepare('SELECT * FROM statut ');
        $req->execute();
        $reponse= $req->fetchAll();
        foreach( $reponse as $data){
          $listStatut[] = new Statut($data);
        }
        return $listStatut;
    }
   
    

  
}