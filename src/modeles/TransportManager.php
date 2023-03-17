<?php

namespace App\modeles;

use App\modeles\ParticipantManager;
use App\entites\Event;
use App\entites\Transport;
use \PDO;


  class TransportManager{


    private $_db;

    public function __construct(){
        $this->_db = DbConnection::getInstance();
    }
    
    public static function getTransport($eventId)
    {
      require_once 'DbConnection.php';
      require_once 'src/entites/Transport.php';
      
      $list = [];
      $db = DbConnection::getInstance();
      $req=$db->prepare('SELECT moyen_de_transport.*, participant.id_participant, lieux.id_lieu, type_transport.id_type_transport FROM moyen_de_transport 
      LEFT JOIN event ON moyen_de_transport.id_event = event.id_event 
      LEFT JOIN lieux ON moyen_de_transport.id_lieu = lieux.id_lieu 
      LEFT JOIN participant ON moyen_de_transport.id_participant = participant.id_participant 
      LEFT JOIN type_transport ON moyen_de_transport.id_type_transport = type_transport.id_type_transport  
      WHERE event.id_event = :id_event 
      GROUP BY moyen_de_transport.id_mdt');
     
      $req->bindParam(':id_event', $eventId, PDO::PARAM_INT);
      $req->execute();
      $results=$req->fetchAll(PDO::FETCH_ASSOC);

      foreach($results as $transport) {
          $list[] = new Transport($transport);
      }
      
      return $list;
 
    }

    public static function getNbDispo($transportId){
      $db = DbConnection::getInstance();
      $req = $db->prepare('SELECT nb_dispo FROM moyen_de_transport WHERE id_mdt = :id_mdt');
      $req->bindParam(':id_mdt', $transportId, PDO::PARAM_INT);
      $req->execute();
      $transport = $req->fetch();
      return $transport['nb_dispo'];

  }

    public static function find($id) {
      $db = DbConnection::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT moyen_de_transport.*, participant.id_participant, event.id_event, lieux.id_lieu, lieux.ville
                            FROM moyen_de_transport 
                            INNER JOIN participant ON moyen_de_transport.id_participant = participant.id_participant
                            INNER JOIN lieux ON moyen_de_transport.id_lieu = lieux.id_lieu
                            INNER JOIN event ON moyen_de_transport.id_event = event.id_event 
                            WHERE id_mdt = :id_mdt');

      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id_mdt' => $id));
      $transport = $req->fetch(PDO::FETCH_ASSOC);

      return new Transport($transport);
      
    }

    // public static function delete($id){
    //     $db = DbConnection::getInstance();
    //     // we make sure $id is an integer
    //     $id = intval($id);
    //     $sql="DELETE FROM event WHERE id=:id";
    //     $query=$this->_db->prepare($sql);
    //     $query->bindValue(':id', $obj->getId(), PDO::PARAM_INT);
    //     $query->execute();
    // //   $req=$db->prepare("DELETE FROM event WHERE id= :id");
    // //   $req->execute(array('id' => $id));
    // //   $event = $req->fetch();

    //   return "$id a bien été supprimée de la base de données.";
    // }

    public static function add(){
        $db = DbConnection::getInstance();

        $id_event = $_POST['titre_event'];
        $id_type_transport = $_POST['type_transport'];
        $date_depart = $_POST['date_depart'];
        $heure_depart = $_POST['heure_depart'];
        $heure_arrivee = !empty($_POST['heure_arrivee']) ? $_POST['heure_arrivee'] : '';
        $nb_place = $_POST['places'];
        $nb_dispo = $_POST['places'];
        $prix = $_POST['prix'];
        $contact = $_POST['contact'];
        $content = !empty($_POST['description']) ? $_POST['description'] : '';
        $id_lieu = $_POST["lieu"];
        $id_participant = $_POST['id_participant'];

        $query=$db->prepare("INSERT INTO moyen_de_transport (id_event, id_type_transport, date_depart_transport, heure_depart, heure_arrivee, nb_place, nb_dispo, tarif, info_contact, descriptif, id_lieu, id_participant) 
          VALUES(:id_event, :id_type_transport, :date_depart_transport, :heure_depart, :heure_arrivee, :nb_place, :nb_dispo, :tarif, :info_contact, :descriptif, :id_lieu, :id_participant )");

          //On indique les bindValue du nom et du mot de passe
          $query->bindValue(':id_event',$id_event,PDO::PARAM_INT);
          $query->bindValue(':id_type_transport',$id_type_transport,PDO::PARAM_INT);
          $query->bindValue(':date_depart_transport',$date_depart,PDO::PARAM_STR);
          $query->bindValue(':heure_depart',$heure_depart,PDO::PARAM_STR);
          $query->bindValue(':heure_arrivee',$heure_arrivee,PDO::PARAM_STR);
          $query->bindValue(':nb_place',$nb_place,PDO::PARAM_INT);
          $query->bindValue(':nb_dispo',$nb_dispo,PDO::PARAM_INT);
          $query->bindValue(':tarif',$prix,PDO::PARAM_INT);
          $query->bindValue(':info_contact',$contact,PDO::PARAM_STR);
          $query->bindValue(':descriptif',$content,PDO::PARAM_STR);
          $query->bindValue(':id_lieu',$id_lieu,PDO::PARAM_INT);
          $query->bindValue(':id_participant',$id_participant,PDO::PARAM_INT);

          $query->execute();

        $transport = new Transport();

        return $transport;     
    }

    public static function update($id){

        $id = $_GET['id'];

        // créer une requête SELECT pour récupérer les données de l'article
        $db = DbConnection::getInstance();
        $requete = $db->prepare("SELECT * FROM event WHERE id = :id");
        $requete->bindValue(':id', $id, PDO::PARAM_INT);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_ASSOC);

        // stocker les données récupérées dans des variables
        $title = $result["titre_event"];
        $date_debut = $result["date_debut_event"];
        $date_fin = $result["date_fin_event"];
        $resume = $result["resume_event"];
        $content = $result["description_event"];

        $requete=$db->prepare("UPDATE event
          SET titre = :titre_event, :date_debut_event,:date_fin_event,:resume_event,:description_event,:code_unique,:statut_coup_coeur
          WHERE id=:id");
          $id = $_GET["id"];
          $title = $_POST["titre"];
          $content = $_POST["description"];
          $date= $_POST["date"];

          $requete->bindValue(':titre',$title, PDO::PARAM_STR);
          $requete->bindValue(':description_article',$content, PDO::PARAM_STR);
          $requete->bindValue(':date_article',$date, PDO::PARAM_STR);
          $requete->bindValue(':id',$id, PDO::PARAM_INT);

          $requete->execute();

          $post = new Post($result);
          return $post; 

    }
}
?>