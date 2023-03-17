<?php 
namespace App\entites;

class Participant
{

    private $_idParticipant;
    private $_statut;
    private $_idEvent;
    private $_idUser;


    
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

    public function getId_participant(){
        return $this->_idParticipant;
    }

    public function setId_participant($idParticipant){
        $this->_idParticipant=$idParticipant;
        return $this;
    }

    public function getStatut(){
        return $this->_statut;
    }

    public function setURL($statut){
        $this->_statut=$statut;
        return $this;
    }

    public function getId_Event(){
        return $this->_idEvent;
    }

    public function setId_Event($idEvent){
        $this->_idEvent=$idEvent;
        return $this;
    }

    public function getId_User(){
        return $this->_idUser;
    }

    public function setId_User($idUser){
        $this->_idUser=$idUser;
        return $this;
    }

}
?>