<?php

namespace App\modeles;

use App\entites\Media;
use App\controllers\MediaController;
use \PDO;

class MediaManager {

    private $_db;

    public function __construct() {
        $this->_db = DbConnection::getInstance();
    }

    public static function findByEvent($eventId) {
        $db = DbConnection::getInstance();
        $eventId = intval($eventId);
    
        $list = [];
        $req = $db->prepare('SELECT * FROM `media` WHERE id_event = :id_event');
        $req->execute(array('id_event' => $eventId));
        $results = $req->fetchAll(PDO::FETCH_ASSOC);
            
        foreach($results as $media) {
            $list[] = new Media($media);
        }
            
        return $list; 
    }

        public static function updateImage(Media $obj){
            
        $db = DbConnection::getInstance();
    
        $sql="UPDATE SET url_photo = :url_photo WHERE id_user = :id_user";
            
            $query = $db ->prepare($sql);
            $query->bindValue(':id_user',$obj->getId_user(), PDO::PARAM_INT);
            $query->bindValue(':url_photo', $obj->getUrl_photo(), PDO::PARAM_STR);

            $query->execute();
            
            return $obj;
        }
    }

