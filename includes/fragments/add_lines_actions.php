<?php 
    include("../../config/functions.php");
    session_start();
    include("../../config/classes.php");
    if(isset($_POST['stationName']) && isset($_POST['stationTimeH']) && isset($_POST['stationTimeM']) && isset($_POST['distanceFromStart']) )
    {
	    $stationName = $_POST['stationName'];
	    $stationTimeH = $_POST['stationTimeH'];
	    $stationTimeM = $_POST['stationTimeM'];
	    $distanceFromStart = $_POST['distanceFromStart'];
				
    $rez = new Stajaliste($stationName, $stationTimeH, $stationTimeM, $distanceFromStart);
    $txt = $rez->__toJson();
    $var = $_SESSION['post_data'];
    
    if($var=="" || $var==NULL) {
      $_SESSION['post_data']= "[".$txt."]";
      header("Location:../../index.php?modul=dodavanje_linija");
      exit();
    }
    else {
      $stari = $_SESSION['post_data'];
      $set = json_decode($stari);
      $game = json_decode($txt);
      array_push($set, $game);      
      $ready = json_encode($set);
      $_SESSION['post_data'] = $ready;
      header("Location:../../index.php?modul=dodavanje_linija");
      exit();
    }

  } 
?>