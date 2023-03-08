<?php 
namespace App\entites;

class Transport 
{
    private $_idMdt;
    private $_libelleMdt;
    private $_tarif;
    private $_contact;
    private $_descriptif;
    private $_dateDepart;
    private $_nbPlace;
    private $_nbDispo;
    private $_heureDepart;
    private $_heureArrivee;
    private $_idLieu;
    private $_idParticipant;
    private $_idEvent;
    private $_idTypeTransport;



    
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

    public function getLibelle_mdt(){
        return $this->_libelleMdt;
    }

    public function setLibelle_mdt($libelleMdt){
        $this->_libelleMdt=$libelleMdt;
        return $this;
    }

    public function getTarif(){
        return $this->_tarif;
    }

    public function setTarif($tarif){
        $this->_tarif=$tarif;
        return $this;
    }

    public function getContact(){
        return $this->_contact;
    }

    public function setContact($contact){
        $this->_contact=$contact;
        return $this;
    }

    public function getDescriptif(){
        return $this->_descriptif;
    }

    public function setDescriptif($descriptif){
        $this->_descriptif=$descriptif;
        return $this;
    }

    public function getDate_depart_transport(){
        return $this->_dateDepart;
    }

    public function setDate_depart_transport($dateDepart){
        $this->_dateDepart=$dateDepart;
        return $this;
    }

    public function getNb_place(){
        return $this->_nbPlace;
    }

    public function setNb_place($nbPlace){
        $this->_nbPlace=$nbPlace;
        return $this;
    }

    public function getNb_dispo(){
        return $this->_nbDispo;
    }

    public function setNb_dispo($nbDispo){
        $this->_nbDispo=$nbDispo;
        return $this;
    }

    public function getHeure_depart(){
        return $this->_heureDepart;
    }

    public function setHeure_depart($heureDepart){
        $this->_heureDepart=$heureDepart;
        return $this;
    }

    public function getHeure_arrivee(){
        return $this->_heureArrivee;
    }

    public function setHeure_arrivee($heureArrivee){
        $this->_heureArrivee=$heureArrivee;
        return $this;
    }

    public function getId_lieu(){
        return $this->_idLieu;
    }

    public function setId_lieu($idLieu){
        $this->_idLieu=$idLieu;
        return $this;
    }

    public function getId_participant(){
        return $this->_idParticipant;
    }

    public function setId_participant($idParticipant){
        $this->_idParticipant=$idParticipant;
        return $this;
    }
    public function getId_event(){
        return $this->_idEvent;
    }

    public function setId_event($idEvent){
        $this->_idEvent=$idEvent;
        return $this;
    }

    public function getId_type_transport(){
        return $this->_idTypeTransport;
    }

    public function setId_type_transport($idTypeTransport){
        $this->_idTypeTransport=$idTypeTransport;
        return $this;
    }
}
?>