<?php

check_session();
?>
<div id='nav'>
	<ul>
		
<?php 
//Korisnik
if($_SESSION['rola']<=2)
	echo '
		<li><div class="test"><a href="./index.php?modul=pocetna">Početna</a></div></li>
		<li><div class="test"><a href="./index.php?modul=red_voznje">Red vožnje</a></div></li>';
if($_SESSION['rola']==2)
	echo '<li><div class="test"><a href="./index.php?modul=moje_rezervacije">Moje rezervacije</a></div></li>';
if($_SESSION['rola']<=2)
	echo '<li><div class="test"><a href="./index.php?modul=o_nama">O nama</a></div></li>
		<li><div class="test"><a href="./index.php?modul=kontakt">Kontakt</a></div></li>';
//
?>
<?php 
//Kondukter/moderator
if($_SESSION['rola']==3)
	echo '<li><div class="test"><a href="./index.php?modul=prodaja_karata">Prodaja karata</a></div></li>
		<li><div class="test"><a href="./index.php?modul=rezervacije">Pregled rezervacija</a></div></li>';
	
	$_SESSION['search'] = array();	
	array_push($_SESSION['search'],date('Y-m-d'));
    $user = $_SESSION['ulogovan'];
    $datum = date('Y-m-d');
    $sql = "SELECT employee_id FROM employees WHERE user_id='$user' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    $employee = $row['employee_id'];

    $sql = "SELECT timetable_id FROM warrants WHERE warrant_date='$datum' AND conducter_id='$employee' LIMIT 1";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    $linija = $row['timetable_id'];
    array_push($_SESSION['search'],$linija);
//		
?>
<?php 
//Administrator
if($_SESSION['rola']==4)
	echo '<li><div class="test"><a href="./index.php?modul=pregled_linija">Pregled linija</a></div></li>
		<li><div class="test"><a href="./index.php?modul=dodavanje_linija">Nove linije</a></div></li>
		<li><div class="test"><a href="./index.php?modul=poslovi">Zaposleni</a></div></li>';
//
?>



		<li><div class="test"><?php if($_SESSION['ulogovan'])echo '<a style="text-decoration:none;" href="./index.php?modul=logout">Odjavi se</a>';
																		else echo '<a style="text-decoration:none;" href="./index.php?modul=login">Prijavi se</a>'; ?></a></div></li>
	</ul>
</div>
<div class="cleaner"></div>


