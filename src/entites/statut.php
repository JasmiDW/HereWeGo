<?php 
namespace App\entites;

class Statut 
{

    
    private $_idStatut;
    private $_libelleStatut;

    
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

    public function getId_statut(){
        return $this->_idStatut;
    }

    public function setId_statut($idStatut){
        $this->_idStatut=$idStatut;
        return $this;
    }

    public function getlibelle_statut(){
        return $this->_libelleStatut;
    }

    public function setlibelle_statut($libelleStatut){
        $this->_libelleStatut=$libelleStatut;
        return $this;
    }

}