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
      
      
    
      return $event;
    }

    public static function add(){

      $db = DbConnection::getInstance();

      // Récupérer l'user correspondant à l'identifiant dans l'URL
      $userId = $_POST['id_user'];

      $title = $_POST["titre_event"];
      $date_debut = $_POST["date_debut_event"];
      $date_fin = $_POST["date_fin_event"];
      $resume = $_POST["resume_event"];
      $content = $_POST["description_event"];
      $code = NULL;
      $id_lieu = $_POST["lieu"];
      $places = $_POST["places"];
      $id_categorie= $_POST["categorie"];
      $statut = 0;

      //Récupérer le code postal de l'id lieu
      $lieu= LieuManager::find($id_lieu);

      if ($code === null) {
        // Récupérer les deux premiers chiffres du code postal correspondant au lieu de l'événement
        $departement = substr($lieu->getCode_postal(), 0, 2);
        // Générer un code unique avec 5 caractères aléatoires, le tiret, les deux derniers chiffres de l'année en cours et les deux premiers chiffres du département
        $code = strtoupper(substr(uniqid(), -5) . '-' . date('y') . $departement);
      }

      $query=$db->prepare("INSERT INTO event (titre_event, date_debut_event, date_fin_event, resume_event, description_event, code_unique, id_user, nb_places, id_categorie, id_lieu, statut_coupcoeur) 
      VALUES(:titre_event, :date_debut_event, :date_fin_event, :resume_event, :description_event, :code_unique, :id_user, :places, :id_categorie, :id_lieu, :statut)");
  
      //On indique les bindValue du titre, date_debut_event, date_fin_event, resume_event, description_event, code_unique et statut_coup_coeur
      $query->bindValue(':titre_event',$title,PDO::PARAM_STR);
      $query->bindValue(':date_debut_event',$date_debut,PDO::PARAM_STR);
      $query->bindValue(':date_fin_event',$date_fin,PDO::PARAM_STR);
      $query->bindValue(':resume_event',$resume,PDO::PARAM_STR);
      $query->bindValue(':description_event',$content,PDO::PARAM_STR);
      $query->bindValue(':code_unique',$code,PDO::PARAM_STR);
      $query->bindValue(':id_user',$userId,PDO::PARAM_INT);
      $query->bindValue(':id_lieu',$id_lieu,PDO::PARAM_INT);
      $query->bindValue(':id_categorie',$id_categorie,PDO::PARAM_INT);
      $query->bindValue(':places',$places,PDO::PARAM_INT);
      $query->bindValue(':statut',$statut,PDO::PARAM_INT);
  
      $query->execute();
  
      $event = new Event($title, $date_debut, $date_fin, $resume,$content, $code, $id_lieu, $id_categorie, $statut, $places, $userId);
  
      return $event;
  }

    public static function update(Event $event){
      $db = DbConnection::getInstance();

      $query = $db->prepare("UPDATE event
          SET titre_event = :titre_event,
              date_debut_event = :date_debut_event,
              date_fin_event = :date_fin_event,
              resume_event = :resume_event,
              description_event = :description_event,
              id_lieu = :id_lieu,
              id_categorie = :id_categorie,
              nb_places = :places
          WHERE id_event = :id");

      $query->bindValue(':id', $event->getId_event(), PDO::PARAM_INT);
      $query->bindValue(':titre_event', $event->getTitre_event(), PDO::PARAM_STR);
      $query->bindValue(':date_debut_event', $event->getDate_Debut_event(), PDO::PARAM_STR);
      $query->bindValue(':date_fin_event', $event->getDate_Fin_event(), PDO::PARAM_STR);
      $query->bindValue(':resume_event', $event->getResume_event(), PDO::PARAM_STR);
      $query->bindValue(':description_event', $event->getDescription_event(), PDO::PARAM_STR);
      $query->bindValue(':id_lieu', $event->getId_lieu(), PDO::PARAM_INT);
      $query->bindValue(':id_categorie', $event->getId_Categorie(), PDO::PARAM_INT);
      $query->bindValue(':places', $event->getNb_places(), PDO::PARAM_INT);


      $query->execute();

    }

    
    public static function delete($id_event){

        $db = DbConnection::getInstance();
        $id_event = intval($id_event);

        $query = $db->prepare("DELETE FROM event WHERE id_event =:id_event");
        $query->bindValue('id_event',$id_event,PDO::PARAM_INT);
        $query->execute();
        
    }
}
?>