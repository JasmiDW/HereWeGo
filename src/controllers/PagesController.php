<?php

namespace App\controllers;

use App\controllers\EventsController;

use App\modeles\EventManager;
use App\modeles\UserManager;
use App\modeles\MediaManager;
use App\modeles\CategorieManager;
use App\modeles\CouleurManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


  class PagesController{

    private $eventsController;
    private $session;

    public function __construct($eventsController) {
        $this->eventsController = $eventsController;
        if(isset($_SESSION['user_id'])){
          $this->session=true;
        }else{
          $this->session=false;
        }
        
    }

    public function home() {

        $eventsController = new EventsController();
        $events = $this->eventsController->getEvenements();
        $favoriteEvent = $this->eventsController->showFavoriteEvent();
        
        $users = array();
        $categories = array();
        foreach ($events as $event) {

        // Récupérer l'utilisateur correspondant à l'événement
        $userId = $event->getId_User();
        $user = UserManager::find($userId);
        $users[] = $user;

        $categorieId = $event->getId_categorie();
        $categorie = CategorieManager::find($categorieId);
        $categories[] = $categorie;

        }

        // $localisationEvent = $this->eventsController->getEventByLocalisation();
        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader, [
          'date_format' => 'd/m/Y', 'debug'=> true
      ]);
       $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        // $this->twig->getExtension('Twig_Extension_Core')->setLocale('fr_FR');
          echo $this->twig->render('pages/home.html.twig', ['list' => $events, 'favoriteEvent'=> $favoriteEvent, 'listCategorie'=> $categories,'user'=> $users, 'session'=>$this->session]);
      }
     

    public function about()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/about.html.twig',['session'=>$this->session]);
    }

    public function contact()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/contact.html.twig',['session'=>$this->session]);
    }

    public function connexion()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/connexion.html.twig',['session'=>$this->session]);
    }

    public function inscription()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/inscription.html.twig',['session'=>$this->session]);
    }

    public function error() {
      
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/error.html.twig',['session'=>$this->session]);
    }

    public function event() {
      
      $eventsController = new EventsController();
      $events = $this->eventsController->getEvenements();
      $favoriteEvent = $this->eventsController->showFavoriteEvent();
      
      $users = array();
      $categories = array();
      foreach ($events as $event) {

      // Récupérer l'utilisateur correspondant à l'événement
      $userId = $event->getId_User();
      $user = UserManager::find($userId);
      $users[] = $user;

      $categorieId = $event->getId_categorie();
      $categorie = CategorieManager::find($categorieId);
      $categories[] = $categorie;

      }

      // $localisationEvent = $this->eventsController->getEventByLocalisation();
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader, [
        'date_format' => 'd/m/Y', 'debug'=> true
    ]);
     $this->twig->addExtension(new \Twig\Extension\DebugExtension());
      // $this->twig->getExtension('Twig_Extension_Core')->setLocale('fr_FR');
        echo $this->twig->render('pages/event.html.twig', ['list' => $events, 'favoriteEvent'=> $favoriteEvent, 'listCategorie'=> $categories,'user'=> $users, 'session'=>$this->session]);
    }

    public function filtres() {
      
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/filtres.html.twig');
    }

    public function showProfil() {
      
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('users/showProfil.html.twig');
    }

  }
  
?>