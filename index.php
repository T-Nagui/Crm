<?php/** * Page index qui ce charge de dispatcher les affiche * @  mail : tech.neji.17@gmail.com */ session_start();/*if(filter_input(INPUT_SERVER, 'HTTPS')!="on") {$redirect= "https://www.".filter_input(INPUT_SERVER, 'HTTP_HOST').filter_input(INPUT_SERVER, 'REQUEST_URI');header("Location:$redirect"); } */include_once 'Connextion.php';ini_set('display_errors',1);error_reporting(E_ALL & ~E_NOTICE);setlocale (LC_TIME, 'fr_FR.utf8','fra');date_default_timezone_set('Europe/Paris');define('WEBRT', dirname(__FILE__));  // On défini où se trouve le webrootdefine('DROOT', dirname(realpath(__FILE__)).'/');define('WEBRoot', 'http://mtc-healthcare.com/clients/crm');  // On défini la racine du projetdefine('DS', DIRECTORY_SEPARATOR);  // On défini les spérateurs require 'librairie/loadall.php';// connection système $cnx=  filter_input(INPUT_POST,'cnx'); if($cnx==1){   $Login=  filter_input(INPUT_POST,'Login');    $mdp=  filter_input(INPUT_POST,'mdp');    $MsgConx=Con($Login, $mdp);    if($MsgConx!=1){        $_SESSION['msg']=$MsgConx;        $_SESSION['type']="alert-danger";    }else{        $_SESSION['msg']='Bonjour '.$_SESSION['user']['login'];         $_SESSION['type']="alert-success";    }}// récupération des fichier et reperoire le lien index.php?page=chemain/du/fichier sans extation$Pga = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);/*$Link = $Pga;$Last = strrev($Pga);*/$Dex = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING);if ($Dex != "") {    deconnexion();}if ($Pga == '') {    $Pga = 'default';}if (!file_exists("pages/" . $Pga . ".php")) {    if (!file_exists("pages/" . $Pga . "/default.php")) {        $pgerecherch = "pages/" . $Pga . ".php";        $Pga = '404';    } else {        $Pga = $Pga . "/default";    }}if(!isset($_SESSION) || empty($_SESSION['user']) || $_SESSION['user']['active']==0){ include 'tpl/login.php';}else{ob_start();include "pages/" . $Pga . '.php';$pages = ob_get_contents();ob_end_clean();    include 'tpl/Start.php';}