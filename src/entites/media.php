<?php 
namespace App\entites;

class Media 
{

    private $_idPhoto;
    private $_url;
    private $_idEvent;


    
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

    public function getId_photos(){
        return $this->_idPhoto;
    }

    public function setId_photos($idPhoto){
        $this->_idPhoto=$idPhoto;
        return $this;
    }

    public function getURL(){
        return $this->_url;
    }

    public function setURL($url){
        $this->_url=$url;
        return $this;
    }

    public function getId_Event(){
        return $this->_idEvent;
    }

    public function setId_Event($idEvent){
        $this->_idEvent=$idEvent;
        return $this;
    }

}
?>