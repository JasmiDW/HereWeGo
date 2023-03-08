<?php

namespace App\modeles;

use App\entites\Categorie;

use \PDO;


  class CategorieManager{


    private $_db;

    public function __construct(){
        $this->_db = DbConnection::getInstance();
    }
    
    public static function find($idCategorie) {
      $db = DbConnection::getInstance();
      // instancier la connexion à la base de données
      // Préparation de la requête SQL
      $req = $db->prepare('SELECT * FROM categorie WHERE id_categorie = :id_categorie');
      // Bind des valeurs
      $req->bindValue(':id_categorie', $idCategorie);
      // Exécution de la requête
      $req->execute();
      // Récupération du résultat
      $data = $req->fetch();
      // Création de l'objet Utilisateur correspondant
      return new Categorie($data);
  }
}