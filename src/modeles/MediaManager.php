<?php

namespace App\modeles;

use App\entites\Media;
use App\controllers\MediaController;
use \PDO;

class MediaManager {

    private $_db;

    public function __construct($db) {
        $this->_db = DbConnection::getInstance();
    }

    public static function findByEvent($eventId) {
        $db = DbConnection::getInstance();
        // we make sure $id is an integer
        $eventId = intval($eventId);
        $req = $db->prepare('SELECT * FROM `media`
        WHERE id_event = :id_event');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id_event' => $eventId));
        $media = $req->fetch(PDO::FETCH_ASSOC);
  
        return new Media($media);
        
    }

        public static function add(Media $obj){
            
        $db = DbConnect::getInstance();
    
        $sql="INSERT INTO medias(categorie_file,title,url_file,date_modif,id_artwork,id_language,id_artist)VALUES(:categorie_file,:title,:url_file,:date_modif,:id_artwork,:id_language,:id_artist)";
            
            $query = $db  ->prepare($sql);
            $query->bindValue(':categorie_file', $obj->getCategorie_file(), PDO::PARAM_STR);
            $query->bindValue(':title',$obj->getTitle(), PDO::PARAM_STR);
            $query->bindValue(':url_file', $obj->getUrl_file(), PDO::PARAM_STR);
            $query->bindValue(':date_modif', $obj->getDate_modif(), PDO::PARAM_STR);
            $query->bindValue(':id_artwork', $obj->getId_artwork(), PDO::PARAM_INT);
            $query->bindValue(':id_language',$obj->getId_language(), PDO::PARAM_STR);
            $query->bindValue(':id_artist',$obj->getId_artist(), PDO::PARAM_INT);
            $query->execute();
            
            return $id_file=$db->lastInsertId();
        }
    }

