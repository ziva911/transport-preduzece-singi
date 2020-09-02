<?php
error_reporting(E_ALL & ~E_NOTICE);
define('DIR_INCLUDES' , './includes/');
define('DIR_TEMPLATE' , './templates/');
define('DIR_SCRIPTS' , './scripts/');
define('DIR_CONFIG' , './config/');
define('DIR_FRAGS' , 'fragments/');
include(DIR_CONFIG.'functions.php');
include(DIR_CONFIG.'constants.php');


session_start();
$session_id = session_id();
check_session();

$connection = new mysqli('localhost', 'root', '', 'autoprevoznik');
   if ($connection->connect_error) die("Greška: " . $connection->connect_error);
  

//echo $_SESSION['ime']."<br>".$_SESSION['ulogovan']."<br>".$_SESSION['rola']."<br>".$_SESSION['post_data']."<br><br>";
//if($_SESSION['search']['datum']??'' && $_SESSION['search']['linija']??'')


$modul =$_GET['modul'] ?? '';
$modul_name=modul_name_check($modul);

switch ($modul_name){
	case 'pocetna':
	case 'red_voznje':
	case 'najam':
	case 'o_nama':
	case 'kontakt':
	case 'login':
	include ($modul_name);
	break;
	default:
	$write_out=file_get_contents(DIR_TEMPLATE . 'error404.php');
	break;
}


include(DIR_TEMPLATE . 'header.php');

include(DIR_TEMPLATE . 'navigation.php');

include(DIR_INCLUDES . DIR_FRAGS .'checkDB.php');


$bread = array("pocetna");

include(DIR_TEMPLATE . 'body.php');


include(DIR_TEMPLATE . 'footer.php');
$connection->close();

?> 