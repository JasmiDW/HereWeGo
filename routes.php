<?php

use App\controllers\PagesController;
use App\controllers\EventsController;
use App\controllers\UserController;
use App\controllers\TransportController;
use App\controllers\MediaManager;
use App\modeles\EventManager;

function call($controller, $action){

  switch($controller){
      case "pages":
        $eventsController = New EventsController();
        $controller = new PagesController($eventsController);
        break;

      case "events":
          $controller = new EventsController();
          break;

      case "users":
        $controller = new UserController();
        break;

      case "transports":
        $controller = new TransportController();
  }
  $controller->{ $action }();
}

$controllers = array(
  'pages' => ['home', 'about', 'connexion', 'contact', 'inscription', 'error','filtres','templateTransport','event'],
  'events' => ['show','formAddEvent','seeEvent','add','formUpdate','update','delete'],
  'participant' => ['addParticipant'],
  'transports' => ['show','addTransport','add','seeTransport','formUpdate','update','delete'],
  'users' => ['show','profil','login','seeProfil','logout','formUpdateProfil','deleteProfil','update','updateProfileImage']
  );

if(array_key_exists($controller, $controllers)){
  if(in_array($action, $controllers[$controller])){
      
      call($controller, $action);
  }else{
      call("pages", "error");
  }
}else{
  call("pages", "error");
}
