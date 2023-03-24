<?php 
namespace App\entites;

use App\modeles\LieuManager;


class Event 
{

    private $_idEvent;
    private $_resume;
    private $_title;
    private $_content;
    private $_codeUnique;
    private $_dateDebut;
    private $_dateFin;
    private $_nbPlaces;
    private $_idUser;
    private $user;
    private $_idLieu;
    private $_ville;
    private $_idCategorie;
    private $url_photo;
    private $_libelleColor;
    private $_codeHexa;
    
    


    public function __construct($value = array()){
      if(!empty($value))
      $this->hydrate($value);
    }

  public function hydrate($donnees){
    foreach ($donnees as $key => $value){
    // On récupère le nom du setter correspondant à l'attribut.
    $method = 'set'.ucfirst($key);
    // Si le setter correspondant existe.
    if (method_exists($this, $method)){
        // On appelle le setter.
        $this->$method($value);
    }
    }
}

    public function getId_event(){
        return $this->_idEvent;
    }

    public function setId_event($idEvent){
        $this->_idEvent=$idEvent;
        return $this;
    }

    public function getResume_event(){
        return $this->_resume;
    }

    public function setResume_event($resume){
        $this->_resume=$resume;
        return $this;
    }

    public function getTitre_event(){
        return $this->_title;
    }

    public function setTitre_event($title){
        $this->_title=$title;
        return $this;
    }

    public function getDescription_event(){
        return $this->_content;
    }

    public function setDescription_event($content){
        $this->_content=$content;
        return $this;
    }

    public function getCode_unique(){
        return $this->_codeUnique;
    }

    public function setCode_unique($codeUnique){
        $this->_codeUnique=$codeUnique;
        return $this;
    }

    public function getDate_Debut_event(){
        return $this->_dateDebut;
    }

    public function setDate_Debut_event($dateDebut){
        $this->_dateDebut=$dateDebut;
        return $this;
    }

    public function getDate_Fin_event(){
        return $this->_dateFin;
    }

    public function setDate_Fin_event($dateFin){
        $this->_dateFin=$dateFin;
        return $this;
    }

    public function getNb_places(){
        return $this->_nbPlaces;
    }

    public function setNb_places($nbPlaces){
        $this->_nbPlaces=$nbPlaces;
        return $this;

    }
    
    public function getId_categorie(){
        return $this->_idCategorie;
    }

    public function setId_categorie($idCategorie){
        $this->_idCategorie=$idCategorie;
        return $this;
    }

    public function getUrl_photo(){
        return $this->url_photo;
    }

    public function setUrl_photo($photos){
        //echo "____".$photos;
        $this->url_photo=$photos;
        return $this;
    }

    public function getId_user() {
        return $this->_idUser;
      }
    
      public function setId_user($idUser) {
        $this->_idUser = $idUser;
        return $this;
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

    public function getLibelle_couleur(){
        return $this->_libelleColor;
    }

    public function setLibelle_couleur($libelleColor){
        $this->_libelleColor=$libelleColor;
        return $this;
    }

    public function getCode_hexadecimal(){
        return $this->_codeHexa;
    }

    public function setCode_hexadecimal($codeHexa){
        $this->_codeHexa=$codeHexa;
        return $this;
    }

    public function getLibelle_categorie(){
        return $this->_libelleCategorie;
    }

    public function setLibelle_categorie($libelleCategorie){
        $this->_libelleCategorie=$libelleCategorie;
        return $this;
    }
   

}
?>