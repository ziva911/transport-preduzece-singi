<?php

check_session();

include_once('./config/functions.php');
include_once("./config/classes.php");
if ($_SESSION['rola']<4) {
    echo "<script>
    alert('Nije vam dozvoljen pristup ovom delu');
    window.location.href='./index.php';
    </script>";
}
else {

$sql = "SELECT station_order FROM timetables";
$result = $connection->query($sql);

if ($result->num_rows == 0)  {
    ajax_poruka2("Tabela je prazna!");
}

if (isset($_POST['send'])) {
    $provera = $_SESSION['post_data'];
    $matrica = json_decode($provera,$assoc = true);
    
    if (count($matrica)>=2) {   
        for ($i=0; $i<count($matrica);$i++){
          $matrica[$i][0]=$i+1;
        }
        $dodaj = json_encode($matrica);
   
        $sql = "INSERT INTO timetables (station_order)
            VALUES ('$dodaj')";
  
        if ($connection->query($sql) === TRUE) {
            ajax_poruka2("Nova linija je uspostavljena!");
        } 
        else echo "Greška: $sql" . $connection->error;
        
        $_SESSION['post_data']= "";

        $sql2 = "SELECT timetable_id from timetables ORDER BY timetable_id DESC LIMIT 1";
        $result2 = $connection->query($sql2);
        foreach($result2->fetch_all() as $value) {
            $timetableId = $value[0];
        }
    }
    else ajax_poruka2("Morate uneti bar 2 stanice!");

    
}

echo<<<HTML
<script src="./scripts/main.js"></script>
<script src="./scripts/jquery-3.4.1.min.js"></script>
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<fieldset >
<div id="timetable">
    <form name="addingStation" onsubmit="return validateForm()" method="post" action="./includes/fragments/add_lines_actions.php">
     
    <table id="redVoznje">
        <tbody id="officers-table" class="dummy">
            <tr >
                <td><label for="stationName">Dodaj stanicu:</label></td>
                <td colspan="2"><label for="stationTime">Vreme polaska (HH:mm):</label></td>
                <td><label for="distanceFromStart" >Razdaljina od početne stanice:</label></td>
                <td id="addOne" rowspan="2"><button value="Dodaj" type="submit" id="addOne">Dodaj stanicu</button></td> 
            </tr>  
            <tr>
                 <td><input type="text"   class="station" id="stationName"  name="stationName" placeholder="ime stanice"></td>
                 <td><input type="number" class="station" id="stationTimeH" name="stationTimeH" placeholder="sati"  min="0" max="23"></td>
                 <td><input type="number" class="station" id="stationTimeM" name="stationTimeM" placeholder="minuti"  min="0" max="59"></td>
                 <td><input type="number" class="station" id="stationTimeM" name="distanceFromStart" placeholder="udaljenost" max="2000"></td>
            </tr>   
        </tbody>
    </table> 

   
    </form></div>
    </fieldset>
HTML;

include_once(DIR_INCLUDES.DIR_FRAGS."add_line.php");

}
?>


