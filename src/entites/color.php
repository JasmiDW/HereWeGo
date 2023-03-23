<?php 
namespace App\entites;

class Color
{

    private $_idColor;
    private $_libelleCouleur;
    private $_codeHexa;


    
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

    public function getId_couleur(){
        return $this->_idColor;
    }

    public function setId_couleur($idColor){
        $this->_idColor=$idColor;
        return $this;
    }

    public function getLibelle_couleur(){
        return $this->_libelleCouleur;
    }

    public function setLibelle_couleur($libelleCouleur){
        $this->_libelleCouleur=$libelleCouleur;
        return $this;
    }

    public function getCode_hexadecimal(){
        return $this->_codeHexa;
    }

    public function setCode_hexadecimal($codeHexa){
        $this->_codeHexa=$codeHexa;
        return $this;
    }

}
?>