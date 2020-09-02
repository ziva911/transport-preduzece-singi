<?php 
//error_reporting(E_ALL & ~E_NOTICE);
include("../../config/functions.php");
include("../../config/classes.php");
$_SESSION['search'] = array();

$conn = new mysqli('localhost', 'root', '', 'autoprevoznik');
//if ($conn->connect_error) die("Greška: " . $conn->connect_error);

if (isset($_GET['getCurrent'])  && isset($_GET['datum']) && isset($_GET['linija'])) {

   $datum = $_GET['datum'];
   $linija = $_GET['linija'];
    
      $path = $_SERVER['REQUEST_URI'];
      $names = explode("/", $path);
      $x=count($names);
      $putanja = "./includes/".$names[--$x];

      $putanja_niz = explode("?", $putanja);
      $putanja = $putanja_niz[1];
      $putanja_niz = explode("&", $putanja);
      
      $datum = str_replace("datum=","",$putanja_niz[0]);
      $linija = str_replace("linija=","",$putanja_niz[1]);
      
      session_start();
      $_SESSION['search']=array();
      array_push($_SESSION['search'],$datum);
      array_push($_SESSION['search'],$linija);
      
      $conn->close();
      
      if($_GET['getCurrent'] == 'Prodaja')
      header("Location: ../../index.php?modul=prodaja_karata");
      elseif($_GET['getCurrent'] == 'Rezervacije')
      header("Location: ../../index.php?modul=rezervacije");
      exit();
   
}
else {
   $conn->close();
   ajax_poruka2("Niste ispravno uneli podatke!");
   if($_GET['getCurrent'] == 'Prodaja')
      header("Location: ../../index.php?modul=prodaja_karata");
      elseif($_GET['getCurrent'] == 'Rezervacije')
      header("Location: ../../index.php?modul=rezervacije");
   exit();
}
?>