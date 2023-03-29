<?php 
namespace App\entites;

class Reservation 
{

    private $_idMdt;
    private $_idParticipant;
    private $_nbPlace;
    private $_date;
    private $_description;


    
    public function __construct($data = array()){
        if(!empty($data)){
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data) {
        foreach($data as $key => $value){
            $method='set'.ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    public function getId_mdt(){
        return $this->_idMdt;
    }

    public function setId_mdt($idMdt){
        $this->_idMdt=$idMdt;
        return $this;
    }

    public function getId_participant(){
        return $this->_idParticipant;
    }

    public function setId_participant($idParticipant){
        $this->_idParticipant=$idParticipant;
        return $this;
    }

    public function getNb_place(){
        return $this->_nbPlace;
    }

    public function setNb_place($nbPlace){
        $this->_nbPlace=$nbPlace;
        return $this;
    }

    public function getDate_resa(){
        return $this->_date;
    }

    public function setDate_resa($date){
        $this->_date=$date;
        return $this;
    }

    public function getDescription(){
        return $this->_description;
    }

    public function setDescription($description){
        $this->_description=$description;
        return $this;
    }

}
?>