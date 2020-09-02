<?php
    $sql = "SELECT 	timetable_id, station_order, date_added FROM timetables WHERE timetable_id='$linija' LIMIT 1";
    $result = $connection->query($sql);
    foreach($result as $values)
    {
        $red_voznje = json_decode($values['station_order']);
    }
    if($linija) {
    echo '<div id="line-main-info"><h2>Sve stanice na liniji:</h2> <br>';
    for($i=0;$i<count($red_voznje);$i++) {
        if ($i>0)echo '<span class="spanStanice"> >> </span>';
        echo '<span class="spanStanice">'.$red_voznje[$i][1].'</span>';
    }
    $j = count($red_voznje)-1;
    echo '<table> <tr> <td> <br><h3>Vreme polaska sa<br> početne stanice: </h3><br></td>';
    echo '<td style="width: 100px;text-align:right;"><span class="spanStanice">'.$red_voznje[0][2].':'.$red_voznje[0][3].'</span></td></tr>';
    echo '<tr> <td> <br><h3>Vreme dolaska na <br>poslednju stanicu: </h3><br></td>';
    echo '<td style="width: 100px;text-align:right;"><span class="spanStanice">'.$red_voznje[$j][2].':'.$red_voznje[$j][3].'</span></td></tr></table>';
    
    $polazak = $red_voznje[0][2]*60+$red_voznje[0][3];
    
    $dolazak = $red_voznje[$j][2]*60+$red_voznje[$j][3];
    if ($dolazak<=$polazak)$dolazak+=1440; 
    $ukupnoVreme = $dolazak-$polazak;
    echo '<h2>Predvidjeno vreme putovanja:</h2> <br>';
    echo '<span class="spanStanice">'.(int)($ukupnoVreme/60).'h '.(int)($ukupnoVreme%60).'m</span></div>';

    $report1 = $red_voznje;
}
?>