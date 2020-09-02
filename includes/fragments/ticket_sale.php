<?php 
    $lista = array ("Trenutna stanica","Stanica obradjena?");
    check_session();

    if($_SESSION['search']) {
      $datum = $_SESSION['search'][0];
      $linija = $_SESSION['search'][1];
    }
    echo '<br><br>';
    

    //provera koja je trenutna stanica
    $sql = "SELECT `current_station`, `max_number_passengers` FROM `warrants`  WHERE `warrant_date` = '$datum' AND `timetable_id` = '$linija' LIMIT 1";
    $result = $connection->query($sql);
    foreach($result->fetch_all() as $value) {
        $last = $value[0];
        $max_number = $value[1];
    }
    //
    //trenutno u autobusu (karte + rezervacije)
    $counter = 0;
    $sql = "SELECT `number_of_seats`,`enter_station`,`exit_station` FROM `reservations`  WHERE `reserve_date` = '$datum' AND `timetable_id` = '$linija' AND `completed`= '1'";
    $connection->query($sql);
    $result = $connection->query($sql);
    foreach($result->fetch_all() as $value) {
        if($last>=$value[1] && $last<$value[2])
            $counter += $value[0];
    }
    $sql = "SELECT `number_of_seats`,`enter_station`,`exit_station` FROM `tickets`  WHERE `ticket_date` = '$datum' AND `timetable_id` = '$linija'";
    $connection->query($sql);
    $result = $connection->query($sql);
    foreach($result->fetch_all() as $value) {
        if($last>=$value[1] && $last<$value[2])
            $counter += $value[0];
    }
    //
    
    //pronalazak linije radi odredjivanja imena stanica i redosleda
    $sql = "SELECT station_order FROM timetables WHERE timetable_id = '$linija' LIMIT 1";
    $result = $connection->query($sql);
    foreach($result->fetch_all() as $value) {
        $json = $value[0];
    }
    $timetable=json_decode($json);
    $stations = array();
    if($timetable)$station_count = count($timetable);
    //
    
    //button reactions
    if (isset($_POST['station-done'])) {
    
        $station_number = $_POST['station-done'];
        $station_complete =$station_number+1;//broj poslednje obradjene stanice
        
        if($counter>$max_number)
            $sql = "UPDATE warrants SET current_station = '$station_complete', max_number_passengers = '$counter' 
                    WHERE timetable_id = '$linija' AND warrant_date='$datum'";
        else 
            $sql = "UPDATE warrants SET current_station = '$station_complete' 
                    WHERE timetable_id = '$linija' AND warrant_date='$datum'";
        $connection->query($sql);

        //ukoliko je trenutna stanica i poslednja stanica
        if($station_number == $station_count) {
            $sql = "UPDATE warrants SET current_station = 0, finished = 1 
                    WHERE timetable_id = '$linija' AND warrant_date='$datum'";
            $connection->query($sql);
            ajax_poruka('Voznja gotova');
        }
        //
        echo "<script>
                window.location.href='".$_SERVER['PHP-SELF']."';
            </script>";          
    }
    //

    //button reactions PRODAJA KARATA
    if (isset($_POST['prodaj'])) {
    
        $seatNumber = $_POST['br-mesta'];
        $conducter = $_SESSION['rola'];
    
        for ($i=0;$i<$station_count;$i++) {
            if ($_POST['startStation1'] == $timetable[$i][1]) {
                $station_enter=$timetable[$i][0];
                $ulaz_ime = $timetable[$i][1];
                $distanca1 = $timetable[$i][4];
            }
            if ($_POST['endStation2'] == $timetable[$i][1]) { 
                $station_exit=$timetable[$i][0];
                $izlaz_ime = $timetable[$i][1];
                $distanca2 = $timetable[$i][4];
            }
        }
        $razlika = $distanca2-$distanca1;

        $sql = "INSERT INTO tickets (ticket_date, timetable_id, enter_station, exit_station, number_of_seats, conducter_id)
                VALUES ('$datum', '$linija', '$station_enter', '$station_exit', '$seatNumber','$conducter')";
        $connection->query($sql);

        //$counter += $seatNumber;
        //$sql = "UPDATE warrants SET max_number_passengers = '$counter' 
        //WHERE timetable_id = '$linija' AND warrant_date='$datum'";
        //$connection->query($sql);

    ajax_poruka2("Karta uspešno zabeležena Od: ".$ulaz_ime."Do: ".$izlaz_ime."Ukupno mesta: ".$seatNumber."Cena po mestu: ".$razlika."Cena: ".$seatNumber*$razlika);
    echo "<script>
            window.location.href='".$_SERVER['PHP-SELF']."';
        </script>";          
}
//
    $sql = "SELECT warrants.max_number_passengers, warrants.current_station, vehicles.max_capacity FROM warrants INNER JOIN vehicles ON warrants.vehicle_id=vehicles.vehicle_id WHERE timetable_id = '$linija' AND warrant_date= '$datum' LIMIT 1";
    $result = $connection->query($sql);

    foreach($result->fetch_all() as $value) {
        $current = $value[0];
        $last_updated = $value[1];
        $max_capacity = $value[2];
        $left_space = $value[2]-$counter;
    }
//ajax_poruka($last);
if($last!=$station_count)  
{  echo '<fieldset id="make-reservation"><form method="post" autocomplete="off">
    <h2 align=center>Prodaja karata</h2>
  <div id="timetableTable">
  <label for="startStation1">Od:</label> 
  <input list="stations1" name="startStation1" id="startStation1" oninput="';echo "pronadji('startStation1')"; echo'"value=""  >
  <datalist id="stations1">';
  echo '<option>'.$timetable[$last-1][1].'</option>';
  echo '</datalist>
  <label for="endStation2">Do:</label> 
  <input list="stations2" name="endStation2" id="endStation2" oninput="';echo "pronadji('endStation2')"; echo'"value=""  >
  <datalist id="stations2">';
  for ($i=$last;$i<$station_count;$i++)echo '<option>'.$timetable[$i][1].'</option>';
  echo '</datalist> 
  <label for="br-mesta">Broj mesta</label>
  <input type="number" name="br-mesta" min="0" max="'.$left_space.'"> 
  <button type="submit" class="formButtons" name="prodaj" id="dugme" value="" >Prodaj kartu</button>
  
  </div>
</form></fieldset>'; 

}
    if($counter!=0){
    echo '<br><h3>Trenutno u autobusu: '.$counter.'</h3>';
    echo '<h3>Ostalo mesta: '.$left_space.'</h3>';
    }
    if ($left_space<=0){
        $sql = "SELECT `vehicle_id` FROM `vehicles`  WHERE `max_capacity` > '$max_capacity' LIMIT 1";
        $result = $connection->query($sql);
        if($result->num_rows==0)ajax_poruka2('Nema vise većih vozila');
        else {
        foreach($result->fetch_all() as $value) {
            $vehicle_id = $value[0];
            
        }   
        $sql ="UPDATE warrants SET vehicle_id = '$vehicle_id' 
                    WHERE timetable_id = '$linija' AND warrant_date='$datum'";
                    $result = $connection->query($sql);
    }
    }
    
    $sql = "SELECT station_order FROM timetables WHERE timetable_id = '$linija' ";

    $result = $connection->query($sql);

    foreach($result->fetch_all() as $value) {
        $json = $value[0];
    }
    $timetable=json_decode($json);

    if($timetable!=""||$timetable!=NULL) {
        $station_all = count($timetable);
        //ajax_poruka($last);
?>

<fieldset class="fieldset">
    <table id="redVoznjeDodaj">
        <thead class="dummy">
            <tr class="officers-table">
                <th><?php echo implode('</th><th>', $lista); ?></th>
            </tr>
        </thead>
        <tbody class="dummy">  
<?php
    for($i=0;$i<$station_all;$i++) {
?>      <form method="post" >
            <tr class="officers-table stanica">
                <td><?php $redni = $timetable[$i][0]; echo $timetable[$i][1]; ?></td>
                <td><input type="hidden" name=difference id="ukupno<?php echo $redni; ?>" value=0>
                    <button type="submit" <?php if($redni < $last || $last == 0)echo 'hidden';?> class="station-done" name="station-done" value="<?php echo $redni; ?>"><?php if($redni!=$station_all)echo 'Zavrsi stanicu'; else echo 'Gotova voznja!';?></button>
                    <?php if($redni < $last || $last == 0)echo '<img src="./images/check.png" alt="Potvrdjena!"  height="48" width="48">';?>
                    </td>
            </tr>
        </form>
<?php  
    }
}
 
?>
        </tbody>
    </table>
</fieldset>

<script>
function pronadji(x) {
        let a = document.querySelector('#'+ x);
        let vrA = String(a.value);
        if (vrA.length >= 1) {
	a.setAttribute('value', vrA);
    }
     
}
window.addEventListener('change keydown paste input',pronadji);
</script>

