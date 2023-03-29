<?php

namespace App\modeles;

use App\entites\Reservation;
use App\controllers\ReservationController;
use \PDO;

class ReservationManager {

    private $_db;

    public function __construct() {
        $this->_db = DbConnection::getInstance();
    }

    public static function findAll($mdtId) {
        $db = DbConnection::getInstance();
        $mdtId = intval($mdtId);
    
        $list = [];
        $req = $db->prepare('SELECT * FROM `reserver` WHERE id_mdt = :id_mdt');
        $req->execute(array('id_mdt' => $mdtId));
        $results = $req->fetchAll(PDO::FETCH_ASSOC);
            
        foreach($results as $reservation) {
            $list[] = new Reservation($reservation);
        }
            
        return $list; 
    }


        public static function add(Reservation $obj){
            
            $db = DbConnection::getInstance();
        
            $sql="INSERT INTO reserver (id_participant, nb_place, date_resa)  VALUES (:id_participant, :nb_place, :date_resa)";
                
                $query = $db ->prepare($sql);
                $query->bindValue(':id_participant',$obj->getId_participant(), PDO::PARAM_INT);
                $query->bindValue(':nb_place', $obj->getNb_place(), PDO::PARAM_INT);
                $query->bindValue(':date_resa', $obj->getDate_resa(), PDO::PARAM_STR);
    
                $query->execute();
                
                return $obj;
            }

        public static function update(Reservation $obj){
        
            $db = DbConnection::getInstance();
        
            $sql="UPDATE reserver SET id_participant = :id_participant, nb_place = :nb_place, date_resa = :date_resa WHERE id_mdt = :id_mdt";
                
                $query = $db ->prepare($sql);
                $query->bindValue(':id_participant',$obj->getId_participant(), PDO::PARAM_INT);
                $query->bindValue(':nb_place', $obj->getNb_place(), PDO::PARAM_INT);
                $query->bindValue(':date_resa', $obj->getDate_resa(), PDO::PARAM_STR);
                $query->bindValue(':id_mdt',$obj->getId_mdt(), PDO::PARAM_INT);
    
                $query->execute();
                
                return $obj;
            }

        public static function delete($mdtId){
    
            $db = DbConnection::getInstance();
            $mdtId = intval($mdtId);
            $sql="DELETE FROM reserver WHERE id_mdt =:id_mdt ";
                
                $query = $db ->prepare($sql);
                $query->bindValue(':id_mdt', $mdtId, PDO::PARAM_INT);

    
                $query->execute();

        }

        public static function count(Reservation $reservation) {
            // On récupère la connexion à la base de données
            $db = DbConnection::getInstance();
            // On prépare la requête SQL pour compter le nombre de participants pour l'événement
            $stmt = $db->prepare("SELECT COUNT(*) FROM reserver WHERE id_mdt = :id_mdt");
            // On lie le paramètre :id_event avec l'ID de l'événement
            $stmt->bindValue(":id_mdt", $reservation->getId_mdt(), PDO::PARAM_INT);
            // On exécute la requête SQL
            $stmt->execute();
            // On récupère le nombre de participants pour l'événement
            $count = $stmt->fetchColumn();
            // On renvoie le nombre de participants
            return $count;
            
        }


    }