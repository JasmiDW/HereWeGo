<?php 
namespace App\entites;

class Categorie
{

    private $_idCategorie;
    private $_libelleCategorie;
    private $_iconeFA;
    private $_idCouleur;



    
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

    public function getId_Categorie(){
        return $this->_idCategorie;
    }

    public function setId_Categorie($idCategorie){
        $this->_idCategorie=$idCategorie;
        return $this;
    }

    public function getLibelle_Categorie(){
        return $this->_libelleCategorie;
    }

    public function setLibelle_Categorie($libelleCategorie){
        $this->_libelleCategorie=$libelleCategorie;
        return $this;
    }

    public function getIcone_Fontawesome(){
        return $this->_iconeFA;
    }

    public function setIcone_Fontawesome($iconeFA){
        $this->_iconeFA=$iconeFA;
        return $this;
    }

    public function getId_Couleur(){
        return $this->_idCouleur;
    }

    public function setId_Couleur($idCouleur){
        $this->_idCouleur=$idCouleur;
        return $this;
    }

}
?>