<?php

use App\controllers\PagesController;
use App\controllers\EventsController;
use App\controllers\UserController;
use App\controllers\TransportController;
use App\modeles\EventManager;

function call($controller, $action){

  switch($controller){
      case "pages":
        require_once 'src/controllers/PagesController.php';
        require_once 'src/controllers/EventsController.php';
        require_once 'src/modeles/EventManager.php';
        $eventsController = New EventsController();
        $controller = new PagesController($eventsController);
        break;

      case "events":
          require_once 'src/controllers/PagesController.php';
          require_once 'src/controllers/EventsController.php';
          require_once 'src/modeles/EventManager.php';

          $controller = new EventsController();
          break;

      case "users":
        require_once 'src/controllers/PagesController.php';
        require_once 'src/controllers/EventsController.php';
        require_once 'src/controllers/UserController.php';
        require_once 'src/modeles/EventManager.php';

        $controller = new UserController();
        break;

      case "transports":
        $controller = new TransportController();
  }
  $controller->{ $action }();
}

$controllers = array(
  'pages' => ['home', 'about', 'connexion', 'contact', 'inscription', 'error','filtres','templateTransport'],
  'events' => ['show','addEvent','seeEvent','add','formUpdate','update','delete'],
  'participant' => ['addParticipant'],
  'transports' => ['show'],
  'users' => ['show','profil','login','seeProfil','logout','updateProfil','deleteProfil']
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
