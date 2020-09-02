<?php 
  $lista = array ("Potvrdjene","rezervacije","","","");
  //button react
  check_session();
  if (isset($_POST['errorApproved'])) {
          
    $reservation_number = $_POST['errorApproved'];
    $get = $json;
    echo $reservation_number;
    for ($i=0; $i<count($matrica);$i++){
      if($matrica[$i][0]==$reservation_number)$matrica[$i][5]=1;
    }
    $sql = "UPDATE reservations SET completed = 0 WHERE reservation_id = '$reservation_number'";
    $connection->query($sql);
    echo '<script>
            window.location.href="./includes/fragments/conducter_action.php?datum='.$datum.'&linija='.$linija.'&getCurrent=Rezervacije"
    </script>';
      
  }
 //
  check_session();
  $provera = $json;
    
  if($provera!="" && $provera!=NULL && $provera!="[]") {
    $sve_rez = json_decode($provera,$assoc = true);
    
    if($sve_rez["1"]!="" && $sve_rez["1"]!=NULL && $sve_rez["1"]!="[]") {
     
?>

<fieldset class="fieldset">
  <form method="post" action="">
    <table id="redVoznjeDodaj">
      <thead class="dummy">
        <tr class="officers-table">
          <th><?php echo implode('</th><th>', $lista); ?></th>
        </tr>
      </thead>
      <tbody class="dummy">  
<?php   
      $matrica=$sve_rez["1"];

      $sql = "SELECT station_order FROM timetables WHERE timetable_id='$linija' LIMIT 1";
      $result = $connection->query($sql);

      foreach($result->fetch_all() as $value) {
        $matr = json_decode($value[0]);
      }   
      $lista[3]=0;
      
      for ($i=0; $i<count($matrica);$i++) { 
        $start_station = $matrica[$i][2];
        $end_station = $matrica[$i][3];
        $lista[3]+=$matrica[$i][4];
               
?>
        <tr class="officers-table">
          <td><?php echo $matrica[$i][1]; ?></td>
          <td><?php echo $matr[--$start_station][1]; ?></td>
          <td><?php echo $matr[--$end_station][1]; ?></td>
          <td><?php echo $matrica[$i][4]; ?></td>
          <td> <img src="./images/check.png" alt="Potvrdjena!"  height="48" width="48"> </td>
          <td><button type="submit" class="reservation" name="errorApproved" value="<?php echo $matrica[$i][0]; ?>">Greškom potvrdjeno</button></td>
        </tr>
<?php 
      }
      $lista[0]="";
      $lista[1]="";
      $lista[2]="Ukupno";
?>

      </tbody>
      <thead class="dummy">
        <tr class="officers-table">
          <th><?php echo implode('</th><th>', $lista); ?></th>
        </tr>
      </thead>
    </table>
  </fieldset>
</form>
<?php 
    } 
    if ($lista[3]=="") $lista[3]=0;
    echo  '<br><br>';
    $_SESSION['post_data'] = "";
  }
   
?>