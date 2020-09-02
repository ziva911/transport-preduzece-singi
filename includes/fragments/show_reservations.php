<?php 
  $lista = array ("Ime","Polazna Stanica","Silazi na","Broj mesta");
  check_session();
  if($_SESSION['search']??'') {
    $datum = $_SESSION['search'][0];
    $linija = $_SESSION['search'][1];
  
    $sql = "SELECT reservation_id, users_name, enter_station,   exit_station,  number_of_seats, completed 
            FROM reservations WHERE timetable_id='$linija' AND reserve_date='$datum' ORDER BY enter_station ASC";
    $result = $connection->query($sql);

    if ($result->num_rows != 0) {
      $spisak = array("0","1","2");
      $spisak[0] = array();
      $spisak[1] = array();
      $spisak[2] = array();
      foreach($result->fetch_all() as $value) {
         if($value[5]==0) array_push($spisak[0], $value);
         elseif($value[5]==1) array_push($spisak[1], $value);
         else array_push($spisak[2], $value);
      }
      check_session();
      $json = json_encode($spisak);
    }
  }
  if (isset($_POST['approve'])) {
    
      $reservation_number = $_POST['approve'];
      echo $reservation_number;
      $sql = "UPDATE reservations SET completed = 1 WHERE reservation_id = '$reservation_number'";
      $connection->query($sql);

    
    header('Location: ./includes/fragments/conducter_action.php?datum='.$datum.'&linija='.$linija.'&getCurrent=Rezervacije') ;
    exit();           
           
  }
  elseif (isset($_POST['reject'])) {
          
    $reservation_number = $_POST['reject'];
    //$get = $_SESSION['post_data'];
    //ajax_poruka($get);
    echo $reservation_number;
    for ($i=0; $i<count($matrica);$i++){
      if($matrica[$i][0]==$reservation_number)$matrica[$i][5]=2;
    }
    $sql = "UPDATE reservations SET completed = 2 WHERE reservation_id = '$reservation_number'";
    if ($connection->query($sql) === TRUE) {
      echo "Uspesno";
  } else {
      echo "Greska: " . $connection->error;
  }
  $sql = "SELECT user_id FROM reservations WHERE reservation_id = '$reservation_number'";
  $result2 = $connection->query($sql)  or die($connection->error);
  $sql= "";
  $row = $result2->fetch_assoc();
  $id = $row['user_id'];
  
    $sql = "UPDATE users SET total_not_showing = total_not_showing + 1  WHERE user_id = '$id'";
    $connection->query($sql);
 

         
     
    header('Location: ./includes/fragments/conducter_action.php?datum='.$datum.'&linija='.$linija.'&getCurrent=Rezervacije') ;
    exit();  
            
            //$_SESSION['post_data']="";   
}
    $provera = $json;
    //echo $json;
    if($provera!="" && $provera!=NULL && $provera!="[]") {
          $sve_rez = json_decode($provera,$assoc = true);
          //print_r($sve_rez);
          if($sve_rez["0"]!="" && $sve_rez["0"]!=NULL && $sve_rez["0"]!="[]") {
     
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
    $matrica=$sve_rez["0"];
    $sql = "SELECT station_order FROM timetables WHERE timetable_id='$linija' LIMIT 1";
    $result = $connection->query($sql);

    foreach($result->fetch_all() as $value){
      
      $matr = json_decode($value[0]);
      
    }   
    
    for ($i=0; $i<count($matrica);$i++) { 
      $start_station = $matrica[$i][2];
      $end_station = $matrica[$i][3];
      
?>
      <tr class="officers-table">
        <td><?php echo $matrica[$i][1]; ?></td>
        <td><?php echo $matr[--$start_station][1]; ?></td>
        <td><?php echo $matr[--$end_station][1]; ?></td>
        <td><?php echo $matrica[$i][4]; ?></td>
        <td><button type="submit" class="reservation" name="approve" value="<?php echo $matrica[$i][0]; ?>">Rezervacija potvrdjena</button></td>
        <td><button type="submit" class="reservation" name="reject" value="<?php echo $matrica[$i][0]; ?>">Rezervacija istekla</button></td>
      
      </tr>
<?php  
    }
?>
    </tbody>
  </table>
</fieldset>
</form>
<?php 
  }
}

?>