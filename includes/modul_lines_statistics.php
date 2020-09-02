<?php
check_session();
if ($_SESSION['rola']<4) {
    echo "<script>
    alert('Nije vam dozvoljen pristup ovom delu');
    window.location.href='./index.php';
    </script>";
}
else {
    if(isset($_POST['linija'])){
        $linija = $_POST['linija'];
        if($linija??'')
        $_SESSION['search'][1] = $linija;
        echo '<div class="my-res-h2"><h2>Linija: '.$_SESSION['search'][1].'</h2></div>';
    
    }
    $linija = $_SESSION['search'][1];     
    
?>
<div id="timetable-wrapper">
    <form id="timetable" method="post" action= "./index.php?modul=pregled_linija">
        <h2 id="redVoznjeNaslov">Podaci o linijama</h1>
         <label for="linija">Linija:</label> 
         <input type="number" name="linija">
         <br>
        <button type="submit" class="formButtons chooseTime" name="week" value="7 days">7 dana</button>
        <button type="submit" class="formButtons chooseTime" name="month" value="1 month">Mesec dana</button>
        <button type="submit" class="formButtons chooseTime" name="3months" value="3 months">Tri meseca</button>
        <button type="submit" class="formButtons chooseTime" name="year" value="1 year">Godinu dana</button>
</form>
</div>

<?php 
$izvestaj = "";
$report1 = "";
$report2 = array();
$report3 = array();
include(DIR_INCLUDES.DIR_FRAGS."lines_info.php");
include(DIR_INCLUDES.DIR_FRAGS."lines_statistics.php");
$reports = array();
array_push($reports , $report1);
array_push($reports , $report2);
array_push($reports , $report3);

$izvestaj = json_encode($reports);
}
if($reports[0] != "") {
    echo<<<HTML
<form action="./includes/fragments/export_report.php" method="post" id="download-form">
        <button type="submit" id="download-button" name="preuzmi" value='{$izvestaj}'>Preuzmi izveštaj</button>
</form>
HTML;
}
?>