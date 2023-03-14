<?php

namespace App\controllers;

use App\controllers\EventsController;

use App\modeles\EventManager;
use App\modeles\UserManager;
use App\modeles\MediaManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


  class PagesController{

    private $eventsController;

    public function __construct($eventsController) {
        $this->eventsController = $eventsController;
    }

    public function home() {

        $eventsController = new EventsController();
        $events = $this->eventsController->getEvenements();
        $favoriteEvent = $this->eventsController->showFavoriteEvent();
        

        // Récupérer l'utilisateur correspondant à l'événement
        // $userId = $events->getId_User();
        // $user = UserManager::find($userId);
        // Récupérer le média correspondant à l'événement
        
        $users = array();
        $medias = array();
        foreach ($events as $event) {

          // Récupérer l'utilisateur correspondant à l'événement
          $userId = $event->getId_User();
          $user = UserManager::find($userId);
          $users[] = $user;

        // Récupérer les médias correspondants à l'événement
        $eventId = $event->getId_event();
        $media = MediaManager::findByEvent($eventId);
        $medias[] = $media;

        }

        // $localisationEvent = $this->eventsController->getEventByLocalisation();
        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader, [
          'date_format' => 'd/m/Y',
      ]);
        // $this->twig->getExtension('Twig_Extension_Core')->setLocale('fr_FR');
          echo $this->twig->render('pages/home.html.twig', ['list' => $events, 'favoriteEvent'=> $favoriteEvent, 'user'=> $users, 'media'=> $medias]);
      }
     
    public function about()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/about.html.twig');
    }

    public function contact()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/contact.html.twig');
    }

    public function connexion()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/connexion.html.twig');
    }

    public function inscription()
    {
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/inscription.html.twig');
    }

    public function error() {
      
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/error.html.twig');
    }

    public function templateEvent() {
      
      $this->loader = new FilesystemLoader('templates');
      $this->twig = new Environment($this->loader);

      echo $this->twig->render('pages/templateEvent.html.twig');
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