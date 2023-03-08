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

    
    // public function all() {
 
    //   $sql="SELECT * FROM event";
    //   $query=$this->_db->prepare($sql);
    //   $query->execute();

    //   $list = [];
    //   // $results=$req->fetchAll(PDO::FETCH_ASSOC);
      
    //  // var_dump($results);
    //   // we create a list of Post objects from the database results
    //   foreach($query as $event) {
    //       //var_dump($post);
    //     $list[] = new Event($event);
    //   }

    //   return $list;
    // }

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

        $title = $_POST["titre_event"];
        $date_debut = $_POST["date_debut_event"];
        $date_fin = $_POST["date_fin_event"];
        $resume = $_POST["resume_event"];
        $content = $_POST["description_event"];
        $code = $_POST["code_unique"];
        $statut = $_POST["statut_coup_coeur"];

        $query=$db->prepare("INSERT INTO event (titre_event, date_debut_event,date_fin_event,resume_event,description_event,code_unique,statut_coup_coeur) 
          VALUES(:titre_event, :date_debut_event,:date_fin_event,:resume_event,:description_event,:code_unique,:statut_coup_coeur)");
          $id= $_POST["id_user"];
          //On indique les bindValue du nom et du mot de passe
          $query->bindValue(':titre_event',$title,PDO::PARAM_STR);
          $query->bindValue(':date_debut_event',$date_debut,PDO::PARAM_STR);
          $query->bindValue(':date_fin_event',$date_fin,PDO::PARAM_STR);

          $query->execute();

        $event = new Event($title, $date_debut, $date_fin, $resume, $content, $code, $statut);

        return $event;     
    }

    public static function update($id){

        $id = $_GET['id'];

        // créer une requête SELECT pour récupérer les données de l'article
        $db = Db::getInstance();
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