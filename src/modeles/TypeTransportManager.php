<?php

namespace App\modeles;

use App\modeles\ParticipantManager;
use App\entites\Event;
use App\entites\Transport;
use App\entites\TypeTransport;
use \PDO;


  class TypeTransportManager{


    private $_db;

    public function __construct(){
        $this->_db = DbConnection::getInstance();
    }
    
    public static function find($idTypeTransport) {
      $db = DbConnection::getInstance();
      // instancier la connexion à la base de données
      // Préparation de la requête SQL
      $req = $db->prepare('SELECT * FROM type_transport WHERE id_type_transport = :id_type_transport');
      // Bind des valeurs
      $req->bindValue(':id_type_transport', $idTypeTransport);
      // Exécution de la requête
      $req->execute();
      // Récupération du résultat
      $data = $req->fetch();
      // Création de l'objet Utilisateur correspondant
      return new TypeTransport($data);
  }

  public static function findAll() {

    $db = DbConnection::getInstance();

    $listTypeTransport = [];
    $req = $db->prepare('SELECT * FROM type_transport ');
    $req->execute();
    $reponse= $req->fetchAll();
    foreach( $reponse as $data){
      $listTypeTransport[] = new TypeTransport($data);
    }
    return $listTypeTransport;
}
}