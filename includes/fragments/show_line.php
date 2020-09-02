<?php 
  $lista = array ("Polazak","Dolazak","Polazna Stanica","Preko...","Rastojanje od polazne stanice");
  check_session();
 
    $provera = $_SESSION['post_data'];
    if($provera!="" && $provera!=NULL && $provera!="[]") 
      {
          $matrica = json_decode($provera,$assoc = true);
        
        
     
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
    for ($i=0; $i<count($matrica);$i++){ 
        $linija = $matrica[$i];
        $time = json_decode($linija[1]);
        $count= count($time);
        $s=$count-1;
        
            
?>
      <tr class="officers-table">
        <td><?php echo $time[0][2].":".$time[0][3]; ?></td>
        <td><?php echo $time[$s][2].":".$time[$s][3]; ?></td>
        <td><?php echo $time[0][1]; ?></td>
        <td><?php if($count>2)
                    for ($j=1; $j < $s ; $j++) echo $time[$j][1]." ";  ?></td>
        <td><?php  $rastojanje = $time[$s][4]-$time[0][4];  echo $rastojanje;?></td>
        <td><button type="submit" class="reservation" name="reserve" value="<?php echo $linija[0]; ?>">Rezervisi</button></td>
      </tr>
             <?php  }?>

  </tbody>
  </table>
  </form>
</fieldset>

        <?php } 
        check_session();
        if (isset($_POST['reserve'])) {
          if ($_SESSION['ulogovan'] == 0)
          {
            ajax_poruka2("Da biste mogli da rezervisete kartu morate da se prijavite");
            ajax_idi_na_stranicu('index.php?modul=login');
          }
          else {
         
            $lineNumber = $_POST['reserve'];
            if($matrica){
              for ($i=0; $i<count($matrica);$i++) { 
                $linija = $matrica[$i][0];
              
                if($lineNumber!=$linija)continue;
                $time = json_decode($matrica[$i][1]);
                $count= count($time);
                $s=$count-1;
                $start = $time[0][0];
                $end = $time[$s][0];
                $vreme_polaska = $time[0][2].":".$time[0][3];
                break;
              }
            }
          } 
              echo'
              <form method="post" action="">
                        <table id="make-reservation">
                            <tr>
                              <td colspan="2" allign="center"><b>Rezervacija</b></td>
                            </tr>
                            <tr>
                              <td>Korisničko ime:</td>
                              <td colspan="2">'.$_SESSION['ime'].'</td>
                            </tr>
                            <tr>
                              <td>Od - Do:</td>
                              <td>'.$time[0][1].'<input type="hidden" id="smthg" name="startStation" value=';echo $start.'></td>
                              <td>'.$time[$s][1].'<input type="hidden" id="smthg" name="endStation" value=';echo $end.'></td>
                            </tr>
                            <tr>
                              <td>Vreme polaska:</td>
                              <td  colspan="2">'.$vreme_polaska.'<input type="hidden" id="smthg" name="departTime" value='.$vreme_polaska.'></td>
                            </tr>
                            <tr>
                              <td><label for="date">Datum:</label></td>
                              <td  colspan="2"><select name="inquiryDate">';for($i=0;$i<=7;$i++) {
                                $day = date('l', strtotime("+ $i days"));
                                switch ($day){
                                  case 'Monday':
                                    $day = 'Ponededljak';
                                  break;
                                  case 'Tuesday':
                                    $day = 'Utorak';
                                  break;
                                  case 'Wednesday':
                                    $day = 'Sreda';
                                  break;
                                  case 'Thursday':
                                    $day = 'Četvrtak';
                                  break;
                                  case 'Friday':
                                    $day = 'Petak';
                                  break;
                                  case 'Saturday':
                                    $day = 'Subota';
                                  break;
                                  default:
                                    $day = 'Nedelja';
                                  break;
                                }
                                        echo '<option value="'.date("Y-m-d", strtotime("+ $i days")).'"';
                              if($i==0) echo 'selected="selected"';echo '>'.$day.'&nbsp'.date("d.m.Y", strtotime("+ $i days")).'</option>';
                            } echo '
                            </select>
                            </tr>
                            <tr>
                              <td>Broj mesta:</td>
                              <td  colspan="2"><input type="number" name="seatnumber" min="1" max="10"></td>
                            </tr>
                            <tr>
                              <td colspan="3" allign="center"><input type="hidden" id="smthg" name="lineNumber" value='.$lineNumber.'>
                                                              <input type="submit" name="confirm" class="reservebtn" value="Rezervisi"></input></td>
                            </tr>
                        </table>
                    </form>';
                    
                    $_SESSION['post_data']="";   
        }
                    if (isset($_POST['inquiryDate']) && isset($_POST['seatnumber']) && isset($_POST['confirm'])) {
                       
                      $date = $_POST['inquiryDate'];
                      $id = $_SESSION['ulogovan'];
                      $ime = $_SESSION['ime'];
                      $start = $_POST['startStation']; 
                      $end = $_POST['endStation']; 
                      $seatNumber = $_POST['seatnumber']; 
                      $lineNumber = $_POST['lineNumber'];
                      
                      
                      $sql = "SELECT 	total_not_showing  FROM users WHERE user_id = '$id' LIMIT 1";
                      $result = $connection->query($sql);
                      $matrica2 = array();
                      foreach($result->fetch_all() as $value) {
                        array_push($matrica2, $value);
                      }
                      if($matrica2[0][0] < '3') {

                      $sql = "INSERT INTO reservations (reserve_date, timetable_id, user_id, users_name, enter_station, exit_station, number_of_seats)
                      VALUES ('$date', '$lineNumber', '$id', '$ime', '$start', '$end', '$seatNumber')";
                      
                      if ($connection->query($sql) === TRUE) {
                        ajax_poruka2("Vaša rezervacija je zabeležena!");
                      } 
                      else echo "Greška: $sql" . $connection->error;
                      
                      $sql = "UPDATE users SET total_reservations = total_reservations + 1  WHERE user_id = '$id'";
                      $connection->query($sql);
                      }
                      else ajax_poruka2("Ne možete više rezervisati jer se 3 puta niste pojavili");

                      
                    }
  
?>

