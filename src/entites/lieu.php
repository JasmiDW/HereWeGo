<?php 
namespace App\entites;

class Lieu 
{

    private $_idLieu;
    private $_ville;
    private $_adresse;
    private $_longitude;
    private $_latitude;
    private $_departement;


    
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

    public function getId_lieu(){
        return $this->_idLieu;
    }

    public function setId_lieu($idLieu){
        $this->_idLieu=$idLieu;
        return $this;
    }

    public function getVille(){
        return $this->_ville;
    }

    public function setVille($ville){
        $this->_ville=$ville;
        return $this;
    }

    public function getAdresse(){
        return $this->_adresse;
    }

    public function setAdresse($adresse){
        $this->_adresse=$adresse;
        return $this;
    }

    public function getLongitude(){
        return $this->_longitude;
    }

    public function setLongitude($longitude){
        $this->_longitude=$longitude;
        return $this;
    }

    public function getLatitude(){
        return $this->_latitude;
    }

    public function setLatitude($latitude){
        $this->_latitude=$latitude;
        return $this;
    }

    public function getDepartement(){
        return $this->_departement;
    }

    public function setDepartement($departement){
        $this->_departement=$departement;
        return $this;
    }


}
?>