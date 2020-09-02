<?php

function modul_name_check($modul){
	return
	($modul == '')	?''	:DIR_INCLUDES.'modul_'.$modul.'.php';
	
}
function station_name_check($station){
	return
	($station->name == '')	?0	:1;
	
}

function matrica($niz)
{
    $length=count($niz);
    $matrica=array();
    $pomocni=array();
    $i=0;
    foreach ($niz as $value){ 
        $i++;
         array_push($pomocni,  $value);
        if($i%5==0) {
            $pomocni[0]=$i/5;
            array_push($matrica,  $pomocni);
           
            $pomocni=[];
        }
	} 
	return $matrica;

}
function ispisiIndex($i){
	alert($i);
	return false;

}
function ukloniStanicu($array, $i){
	
	if($array!=NULL)array_splice($array, $i, 1);
	
	return $array;
	

}
function pronadjiLiniju($array, $start, $end){
    for($i=0;$i<count($array); $i++){
        for($j=0;$j<count($array[$i]); $j++)
            if($array[$i][$j][1] == $start)
                for($k=$j+1;$k<count($array[$i]); $k++)
                    if($array[$i][$k][1] == $end) {
                        print_r($array[$i]);
                        
                    }
            
   
    }

}

function check_session() {
	global $cookie_name, $session_id;
	if (!$_COOKIE['PHPSESSID']) {
		start_session($session_id);
	}
}
function start_session($session_id) {
	$_SESSION['id'] = $session_id;
	$_SESSION['server_name'] = $_SERVER['SERVER_NAME'];
	$_SESSION['server_addr'] = $_SERVER['SERVER_ADDR'];
	$_SESSION['server_port'] = $_SERVER['SERVER_PORT'];
	$_SESSION['remote_addr'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['ulogovan'] = 0;
	$_SESSION['ime'] = "";
	$_SESSION['rola'] = 1;
	$_SESSION['post_data'] = "";
}

function ajax_poruka($poruka)
{
	/* Ispisivanje poruke na ekranu u alert box-u */
	echo '<script language="javascript" type="text/javascript">alert("'.$poruka.'")</script>';
	/* Prekini izvršavanje programa */
	exit;
}
function ajax_poruka2($poruka)
{
	/* Ispisivanje poruke na ekranu u alert box-u */
	echo '<script language="javascript" type="text/javascript">alert("'.$poruka.'")</script>';
	/* Prekini izvršavanje programa */
	
}

function ajax_idi_na_stranicu($stranica)
{
	/* Redirekcija pomoću JavaScript-a. Koristiti je kada se stranica ispisuje u iframe-u */
	echo '<script language="javascript" type="text/javascript">window.top.location="'.$stranica.'";</script>';
	/* Prekini izvršavanje programa */
	exit;
}

function idi_na_stranicu($stranica)
{
	/* Redirekcija */
	header("location: ./$stranica");
	/* Prekini izvršavanje programa */
	exit;
}
function pronadjiDan($day)
{
	switch ($day){
		case 'Monday':
			return 1;
		break;
		case 'Tuesday':
			return 2;
		break;
		case 'Wednesday':
			return 3;
		break;
		case 'Thursday':
			return 4;
		break;
		case 'Friday':
			return 5;
		break;
		case 'Saturday':
			return 6;
		break;
		default:
		return 7;
		break;
	} 
}
function vratiDan($day)
{
	switch ($day){
		case '1':
			return 'Ponedeljak';
		break;
		case '2':
			return 'Utorak';
		break;
		case '3':
			return 'Sreda';
		break;
		case '4':
			return 'Četvrtak';
		break;
		case '5':
			return 'Petak';
		break;
		case '6':
			return 'Subota';
		break;
		default:
		return 'Nedelja';
		break;
	} 
}
function vratiMesec($month)
{
	switch ($month){
		case '1':
			return 'Januar';
		break;
		case '2':
			return 'Februar';
		break;
		case '3':
			return 'Mart';
		break;
		case '4':
			return 'April';
		break;
		case '5':
			return 'Maj';
		break;
		case '6':
			return 'Jun';
		break;
		case '7':
			return 'Jul';
		break;
		case '8':
			return 'Avgust';
		break;
		case '9':
			return 'Septembar';
		break;
		case '10':
			return 'Oktobar';
		break;
		case '11':
			return 'Novembar';
		break;
		default:
		return 'Decembar';
		break;
	} 
}

?>