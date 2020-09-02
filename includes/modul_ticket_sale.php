<?php
check_session();
if ($_SESSION['rola']<3) {
    echo "<script>
    alert('Nije vam dozvoljen pristup ovom delu');
    window.location.href='./index.php';
    </script>";
}
else {
 
    echo '<div class="my-res-h2"><h2>Današnji datum: '.date('d. ').vratiMesec(date('m')).date(' Y').'</h2><h2>Linija: '.$linija.'</h2><h2>Ime konduktera: '.$_SESSION['ime'].'</h2></div>';

$sql = "SELECT `finished` FROM `warrants`  WHERE `warrant_date` = '$datum' AND `timetable_id` = '$linija' LIMIT 1";
    $result = $connection->query($sql);
    foreach($result->fetch_all() as $value) {
        $finished = $value[0];
    }
    if ($finished == 1) {
        ajax_poruka2('Željena linija je vec odradjena i kompletirana za traženi datum');
        echo '<p align=center>Željena linija je vec odradjena i kompletirana za traženi datum</p>
            <p align=center>Izaberite drugu liniju i/ili drugi datum</p>';
    }
    else
include(DIR_INCLUDES.DIR_FRAGS."ticket_sale.php");
 
}

?>