<?php

namespace App\modeles;

use App\entites\Color;
use \PDO;

class CouleurManager {

    private $_db;

    public function __construct() {
        $this->_db = DbConnection::getInstance();
    }

    public static function find($colorId) {
        $db = DbConnection::getInstance();
        $colorId = intval($colorId);
    
        $list = [];
        $req = $db->prepare('SELECT * FROM `couleurs` WHERE id_couleur = :id_couleur');
        $req->execute(array('id_couleur' => $colorId));
        $results = $req->fetchAll(PDO::FETCH_ASSOC);
            
        foreach($results as $color) {
            $list[] = new Color($color);
        }
            
        return $list; 
    }

    }
