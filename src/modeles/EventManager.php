<?php

namespace App\modeles;

use App\modeles\ParticipantManager;
use App\entites\Event;
use \PDO;


  class EventManager{


    private $_db;

    public function __construct(){
        $this->_db = DbConnection::getInstance();
    }
    
    public static function getEvenements()
    {
      require_once 'DbConnection.php';
      require_once 'src/entites/event.php';
      $list = [];
      $db = DbConnection::getInstance();
      $req=$db->prepare('SELECT event.id_event, event.titre_event, event.date_debut_event, event.date_fin_event, event.resume_event, event.nb_places, event.code_unique, MIN(media.url) as url_photo FROM event LEFT JOIN media  ON event.id_event = media.id_event
      GROUP BY event.id_event');
     
      $req->execute();
      $results=$req->fetchAll(PDO::FETCH_ASSOC);
     // var_dump($results);
      // we create a list of Post objects from the database results
      foreach($results as $event) {

        $list[] = new Event($event);
      }

      return $list;

      
    }

    public static function getEventById($userId)
  {
    require_once 'DbConnection.php';
    require_once 'src/entites/event.php';
    $list = [];
    $db = DbConnection::getInstance();
    $req=$db->prepare('SELECT event.*, media.url
    FROM event
    LEFT JOIN media ON event.id_event = media.id_event
    WHERE event.id_user = :userId');
    $req->bindParam(':userId', $userId, PDO::PARAM_INT);
    $req->execute();
    $results=$req->fetchAll(PDO::FETCH_ASSOC);

    // we create a list of Event objects from the database results
    foreach($results as $event) {
        $list[] = new Event($event);
    }

    return $list;
  }

    public function showFavoriteEvent()
    {
        $db = DbConnection::getInstance();
        // instancier la connexion à la base de données
        $req=$db->prepare ("SELECT * FROM event WHERE statut_coupcoeur = 1 LIMIT 1"); // requête SQL pour récupérer l'événement favori
        $req->execute(); // exécuter la requête SQL
        $favoriteEvent = $req->fetch(); // récupérer le premier événement qui répond à la condition
        
        return new Event($favoriteEvent);
    }

    public static function find($id) {
      $db = DbConnection::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT event.* , utilisateur.id_user, utilisateur.raison_sociale, lieux.ville
      FROM event 
      INNER JOIN utilisateur ON event.id_user = utilisateur.id_user
      INNER JOIN lieux ON event.id_lieu = lieux.id_lieu 
      WHERE id_event = :id_event');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id_event' => $id));
      $event = $req->fetch(PDO::FETCH_ASSOC);

      return new Event($event);
      
    }

    public static function remainingPlaces(Event $event)
    {
        // Récupération du nombre de participants pour l'événement
        $participantsCount = ParticipantManager::countByEvent($event);
        // Calcul du nombre de places restantes
        $remainingPlaces = $event->getNb_places() - $participantsCount;
        return $remainingPlaces;
        
    }

    public function create($title, $description, $idLieu, $codeUnique = null) {
      if ($codeUnique === null) {
        // Récupérer l'objet Lieu correspondant à l'ID spécifié
        $lieu = LieuManager::find($idLieu);
    
        // Générer un code unique avec les 5 derniers caractères de l'identifiant unique et le département
        $codeUnique = substr(uniqid(), -5) . date('Y') . $lieu->getDepartement();
      }
      
    
      return $event;
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