<?php 
namespace App\entites;

class User 
{

    private $_id;
    private $_rs;
    private $_email;
    private $_nom;
    private $_prenom;
    private $_genre;
    private $_password;
    private $_tel;
    private $_photo;
    private $_dateInscription;
    private $_badge;
    private $_lieuId;
    private $_lieu;
    private $_statutId;
    private $_statut;

    
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

    public function getId_user(){
        return $this->_id;
    }

    public function setId_user($id){
        $this->_id=$id;
        return $this;
    }

    public function getRaison_sociale(){
        return $this->_rs;
    }

    public function setRaison_sociale($rs){
        $this->_rs=$rs;
        return $this;
    }

    public function getMail_user(){
        return $this->_email;
    }

    public function setMail_user($email){
        $this->_email=$email;
        return $this;
    }

    public function getNom_user(){
        return $this->_nom;
    }

    public function setNom_user($nom){
        $this->_nom=$nom;
        return $this;
    }

    public function getPrenom_user(){
        return $this->_prenom;
    }

    public function setPrenom_user($prenom){
        $this->_prenom=$prenom;
        return $this;
    }

    public function getGenre(){
        return $this->_genre;
    }

    public function setGenre($genre){
        $this->_genre=$genre;
        return $this;
    }

    public function getPassword(){
        return $this->_password;
    }

    public function setPassword($password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->_password = $hash;
        return $this;
    }

    public function getTel_user(){
        return $this->_tel;
    }

    public function setTel_user($tel){
        $this->_tel=$tel;
        return $this;
    }

    public function getPhoto(){
        return $this->_photo;
    }

    public function setPhoto($photo){
        $this->_photo=$photo;
        return $this;
    }

    public function getBadge(){
        return $this->_badge;
    }

    public function setBadge($badge){
        $this->_badge=$badge;
        return $this;
    }
    
    public function getDateInscription(){
        return $this->_dateInscription;
    }

    public function setDateInscription($dateInscription){
        $this->_dateInscription=$dateInscription;
        return $this;
    }
    
    public function getId_lieu(){
        return $this->_lieuId;
    }
    
    public function setId_lieu($lieuId){
        $this->_lieuId = $lieuId;
        return $this;
    }
    
    public function getLieu(){
        return $this->_lieu;
    }
    
    public function setLieu($lieu){
        $this->_lieu = $lieu;
        return $this;
    }

    public function getId_statut(){
        return $this->_statutId;
    }
    
    public function setId_statut($statutId){
        $this->_statutId = $statutId;
        return $this;
    }
    
    public function getStatut(){
        return $this->_statut;
    }
    
    public function setStatut($statut){
        $this->_statut = $statut;
        return $this;
    }

}
?>