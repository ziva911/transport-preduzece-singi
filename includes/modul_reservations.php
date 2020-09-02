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

include(DIR_INCLUDES.DIR_FRAGS."show_reservations.php");
include(DIR_INCLUDES.DIR_FRAGS."show_reservations_confirmed.php");

}
?>