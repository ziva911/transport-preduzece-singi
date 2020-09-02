

    <?php 
        array_push($bread, $modul);
        $modul_name = array('pocetna' => 'Početna', 'red_voznje' => 'Red vožnje', 'o_nama' => 'O nama','kontakt' => 'Kontakt', 'login'=> 'Prijava / Odjava',
                            'moje_rezervacije' => 'Moje Rezervacije', 'prodaja_karata' => 'Prodaja karata', 'rezervacije' => 'Pregled rezervacija',
                            'pregled_linija' => 'Pregled linija', 'dodavanje_linija' => 'Dodavanje linija', 'poslovi' => 'Zaposleni' );
        if($modul!='pocetna'&& $modul!='') { echo "<div id='bread'>";
            for ($i=0; $i<count($bread);$i++) {
                if($i != 0) echo "<span class='breadcrumbs'> >> </span>";
                echo '<span class="breadcrumbs"><a href="./index.php?modul='.$bread[$i].'">'.$modul_name[$bread[$i]].'</a></span>';
            }
            echo "</div>";
        }
    ?>

<div class="cleaner"></div>


<?php
//korisnik

if($modul=='pocetna'||$modul=='')if (file_exists(DIR_INCLUDES.'modul_homepage.php'))include_once(DIR_INCLUDES.'modul_homepage.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='red_voznje')if (file_exists(DIR_INCLUDES.'modul_timetable.php'))include_once(DIR_INCLUDES.'modul_timetable.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='moje_rezervacije')if (file_exists(DIR_INCLUDES.'modul_my_reservations.php'))include_once(DIR_INCLUDES.'modul_my_reservations.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}


if($modul=='najam')if (file_exists(DIR_INCLUDES.'modul_rent_bus.php'))include_once(DIR_INCLUDES.'modul_rent_bus.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='o_nama')if (file_exists(DIR_INCLUDES.'modul_about_us.php'))include_once(DIR_INCLUDES.'modul_about_us.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='kontakt')if (file_exists(DIR_INCLUDES.'modul_contact.php'))include_once(DIR_INCLUDES.'modul_contact.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
//kondukter
if($modul=='prodaja_karata')if (file_exists(DIR_INCLUDES.'modul_ticket_sale.php'))include_once(DIR_INCLUDES.'modul_ticket_sale.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='rezervacije')if (file_exists(DIR_INCLUDES.'modul_reservations.php'))include_once(DIR_INCLUDES.'modul_reservations.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
//admin
if($modul=='pregled_linija')if (file_exists(DIR_INCLUDES.'modul_lines_statistics.php'))include_once(DIR_INCLUDES.'modul_lines_statistics.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='dodavanje_linija')if (file_exists(DIR_INCLUDES.'modul_add_lines.php'))include_once(DIR_INCLUDES.'modul_add_lines.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='poslovi')if (file_exists(DIR_INCLUDES.'modul_jobs.php'))include_once(DIR_INCLUDES.'modul_jobs.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
//all
if($modul=='login')if (file_exists(DIR_INCLUDES.'modul_login.php'))include_once(DIR_INCLUDES.'modul_login.php');
else {
    header('Location:'.DIR_TEMPLATE.'error404.php');
    exit();
}
if($modul=='logout')
    if (file_exists(DIR_INCLUDES.'modul_login.php'))include_once(DIR_INCLUDES.'modul_login.php');
    else {
        header('Location:'.DIR_TEMPLATE.'error404.php');
        exit();
    }
if($modul=='register')
    if (file_exists(DIR_INCLUDES.'modul_login.php'))include_once(DIR_INCLUDES.'modul_login.php');
    else {
        header('Location:'.DIR_TEMPLATE.'error404.php');
        exit();
    }
?>
<div class="cleaner"></div>
