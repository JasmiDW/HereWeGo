<?php

session_start();

require_once("DbConnection.php");
require_once 'vendor/autoload.php';

if(isset($_GET["controller"]) && isset($_GET["action"])){
    $controller=$_GET["controller"];
    $action=$_GET["action"];
}elseif(isset($_POST["controller"]) && isset($_POST["action"])){
    $controller=$_POST["controller"];
    $action=$_POST["action"];
}else{
    $controller="pages";
    $action="home";
}

require_once('routes.php');


?>
