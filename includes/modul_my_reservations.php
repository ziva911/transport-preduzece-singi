<?php
check_session();
$lista = array('Datum','Pocetna Stanica', 'Krajnja stanica', 'Broj mesta', 'Kompletirana?');
if($_SESSION['rola']!=2) {
    echo "<script>
    alert('Nije vam dozvoljen pristup ovom delu');
    window.location.href='./index.php';
    </script>";
}
else {		
 $id = $_SESSION['ulogovan'];

    $sql = "SELECT station_order FROM timetables WHERE timetable_id='$linija' LIMIT 1";
    $result = $connection->query($sql);

    foreach($result->fetch_all() as $value){
      
      $matr = json_decode($value[0]);
      
    }  
    $sql = "SELECT 	total_reservations, total_not_showing  FROM users WHERE user_id = '$id' LIMIT 1";
   
    $result = $connection->query($sql);
    $matrica2 = array();
    foreach($result->fetch_all() as $value) {
        array_push($matrica2, $value);
    }
    if($matrica2[0][0]==0) echo '<div  class="my-res-h2"><h2>Do sada nikada niste rezervisali kartu!</h2></div> ';
    else {
        echo '<div  class="my-res-h2"><h2>Ukupno vaših rezervacija: '.$matrica2[0][0].'</h2>
        <h2>Ukupno vaših nepojavljivanja: ';
        if($matrica2[0][1] != '0')echo '<span style="color:red">'.$matrica2[0][1].'</span><span style="font-size: 0.5em"> Ukoliko se ne pojavite 3 puta necete moci vise da rezervisete</span><br></h2>';
        else echo $matrica2[0][1].'</h2></div>';
    }
    
    $sql = "SELECT timetable_id, reserve_date, enter_station, exit_station, number_of_seats, completed  FROM reservations WHERE user_id = '$id' ORDER BY reserve_date DESC";
   
    $result = $connection->query($sql);

    $matrica = array();

    foreach($result->fetch_all() as $value) {
        array_push($matrica, $value);
    }
    if($matrica2[0][0]>0) 
    echo '<br><fieldset class="fieldset">
        <br><table id="redVoznjeDodaj">
            <thead class="dummy">
            <tr class="officers-table">
              <th>'.implode("</th><th>", $lista).'</th>
            </tr>
            </thead>
            <tbody class="dummy">';
    foreach($matrica as $value) {
        
        $linija = $value[0];
        
        $sql = "SELECT station_order FROM timetables WHERE timetable_id='$linija' LIMIT 1";
        $result = $connection->query($sql);

        foreach($result->fetch_all() as $val){
      
        $matr = json_decode($val[0]);
           
        $start_station = $value[2];
        $end_station = $value[3];
       
        switch ($value[5]) {
            case '1':
                $show = '<img src="./images/check.png" alt="Potvrdjena!"  height="48" width="48">
                <p style="font-size: 0.4em;">Putnik se pojavio</p>';
            break;
            case '2':
                {
                $show = '<img src="./images/ex-mark.png" alt="Odbijena!"  height="40" width="40">
                <p style="font-size: 0.4em;">Putnik se nije pojavio</p>';
                }
            break;
            default:
            $show = '<p style="font-size: 0.6em;">Rezervacija još nije potvrdjena</p>'; 
            break;
        }

        echo'<tr class="officers-table">
                <td>'.$value[1].'</td>
                <td>'.$matr[--$start_station][1].'</td>
                <td>'.$matr[--$end_station][1].'</td>
                <td>'.$value[4].'</td>
                <td>'.$show.'</td>';

       
    }
}

}
 
          
            

echo '
  </tbody>
  </table>
  <br><br>
</fieldset>';


?>