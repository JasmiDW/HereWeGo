<?php 
namespace App\entites;

class TypeTransport
{

    private $_idTypeTransport;
    private $_libelle;
    private $_iconeFA;



    
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

    public function getId_type_transport(){
        return $this->_idTypeTransport;
    }

    public function setId_type_transport($idTypeTransport){
        $this->_idTypeTransport=$idTypeTransport;
        return $this;
    }

    public function getLibelle_Type_Transport(){
        return $this->_libelle;
    }

    public function setLibelle_Type_Transport($libelle){
        $this->_libelle=$libelle;
        return $this;
    }

    public function getIcone_Fontawesome(){
        return $this->_iconeFA;
    }

    public function setIcone_Fontawesome($iconeFA){
        $this->_iconeFA=$iconeFA;
        return $this;
    }

}
?>