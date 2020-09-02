<?php
$dataPoints = array();
$dataPoints2 = array();
$dataPoints3 = array();
$week_array = array();
$month_array = array();
$year_array = array();
$matrica = array();

if($_SESSION['search'][1]!='' || $_SESSION['search'][1]!= null) {
    check_session();
    if(isset($_POST['week'])) {
        $time = $_POST['week'];
        $option = 1;
    }
    else if(isset($_POST['month'])) {
        $time = $_POST['month']; 
        $option = 2;
    }
    else if(isset($_POST['3months'])) {
        $time = $_POST['3months'];
        $option = 3;
    }
    else if(isset($_POST['year'])) {
        $time = $_POST['year'];
        $option = 4;
    }
    $date = date('Y-m-d',strtotime(" - $time"));
    if($date!='1970-01-01') {
        $matrica = array();
        $today = date('Y-m-d');
        $sql = "SELECT warrants.warrant_date, vehicles.max_capacity, warrants.driver_id, warrants.conducter_id, warrants.max_number_passengers 
                FROM warrants INNER JOIN vehicles ON warrants.vehicle_id=vehicles.vehicle_id WHERE timetable_id='$linija' AND finished = '1' AND warrant_date>='$date' AND warrant_date<'$today' ORDER BY warrant_date ASC";
        $result = $connection->query($sql);
    //po danima
        foreach($result->fetch_all() as $value) {
            
            array_push($matrica,$value);
            $dan = date('l',strtotime($value[0]));
            $dan = pronadjiDan($dan);
            $num = number_format('100'*$value[4]/$value[1],2);
            
            $order = $dan - 1;
            if($dan) {
                $week_array[$order][0] += $num;
                $week_array[$order][1] += 1;
            }
        }
        
        for($i=0;$i<7; $i++) {  
            if($week_array[$i][1]>0)
                $prosek = $week_array[$i][0]/$week_array[$i][1];
            else $prosek =0;
            $prosek = number_format($prosek.'%',2);
            $j = $i+1;
            array_push($dataPoints , array("y" => $prosek, "label" => vratiDan($j)));
        }
        for($i=0;$i<7; $i++){
            if($week_array[$i][1] == 0) continue;
            else $report2[$i] = (double)$week_array[$i][0]/$week_array[$i][1];

        }
        echo '<div style="text-align:center; display:block;"><div style="height:600px !important;width: 40%; display:inline-block;"><div> Dani u nedelji</div><div id="chartContainer" style=""></div></div>';
     //za godinu po mesecima
        if ($option == 4) {

            foreach($matrica as $values) {
                $mesec = explode('-',$values[0]);
                
                $mesec[0] = (int)$mesec[0];
                $mesec[1] = (int)$mesec[1];
                $orderY = $mesec[1] - 1;
                $start_date = strtotime($values[0]);
                $end_date = strtotime($today); 
                $days = ($end_date - $start_date)/60/60/24; 
                 
                $numY = number_format('100'*$values[4]/$values[1],10);
                $date = date('Y-m-d', strtotime('-'.$days.' days'));
                

                if($mesec[0]<date('Y') && $mesec[1] == (int)date('m')) {
                    $year_array[0][0] += $numY;
                    $year_array[0][1] += 1;
                }
                else {
                    $year_array[$mesec[1]][0] += $numY;
                    $year_array[$mesec[1]][1] += 1;
                }
                
            }
            $dataPoints2=array();
            if ($year_array[0][0]!=0) {
                $prosek = $year_array[0][0]/$year_array[0][1];
                $prosek = number_format($prosek.'%',2);
                array_push($dataPoints2 , array("y" => $prosek, "label" => vratiMesec(date('m')).' `'.(int)date('Y', strtotime('-1 year'))%100));
            }
            for($i=(int)date('m');$i<12; $i++) {  
                $j = $i+1;
                if($year_array[$j][0]>0)
                    $prosek = $year_array[$j][0]/$year_array[$j][1];
                else $prosek =0;             
                $prosek = number_format($prosek.'%',2);  
                $k= 12 - $j;
                array_push($dataPoints2 , array("y" => $prosek, "label" => vratiMesec($j).' `'.(int)date('Y',strtotime('-'.$j.'months'))%100));
            }
            for($i=1;$i<=(int)date('m'); $i++) { 
                if($year_array[$i][0]>0)
                    $prosek = $year_array[$i][0]/$year_array[$i][1];
                else $prosek =0;
                $j = (int)date('m')-$i;      
                $prosek = number_format($prosek.'%',2);
                array_push($dataPoints2 , array("y" => $prosek, "label" => vratiMesec($i).' `'.(int)date('Y',strtotime('-'.$j.'months'))%100));
            }   
            
            for($i=0;$i<12; $i++) {
                $j=12 - $i + (int)date('m'); 
                if($year_array[$j][0]>0)
                  $prosek = $year_array[$j][0]/$year_array[$j][1];
                else $prosek = "0";  
                           
            array_push($report3,$prosek);
            }         
            
           $prosek = $year_array[0][0]/$year_array[0][1];           
            array_push($report3,$prosek);
            echo '<div style="height:600px !important;width: 50%; display:inline-block;"><div> Godina</div><div id="chartContainer2" style=""></div></div></div>';
        }
    //za 1 ili 3 meseca po danima
        else if ($option == 2 || $option == 3) {
            $max= count($matrica);
            for($i=$max-1;$i>=0; $i--) {  
                $numM = number_format('100'*$matrica[$i][4]/$matrica[$i][1],2);
                $month_array[$i][0] += $numM;
                $month_array[$i][1] += 1;
                if($month_array[$i][0]>0)
                    $prosek = $month_array[$i][0]/$month_array[$i][1];
                else $prosek = 0;
                $prosek = number_format($prosek.'%',2);
                $j = $i+1;
                array_push($dataPoints2 , array("y" => $prosek, "label" => date('d.m.',strtotime('-'.$j.'days'))));
            }
            for($i=0;$i<$max; $i++){
                if($month_array[$i][1] == 0) continue;
                else $report3[$i] = (double)$month_array[$i][0]/$month_array[$i][1];
    
            }
            echo '<div style="height:600px !important;width: 50%; display:inline-block;">';if($max>40)echo'Period od 3 Meseca';else echo'Period od Mesec dana';echo'<div id="chartContainer2" style=""></div></div></div>';
        }
    }
}
?>
<script>

window.onload = function () {
 
 var chart = new CanvasJS.Chart("chartContainer", {
     title: {
         text: ""
     },
     exportFileName: "Po danima u nedelji",

     axisY: {
         title: "Procenat popunjenosti kapaciteta"
     },
     data: [{
         type: "line",
         dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
     }]
 });
 chart.render();

 var chart2 = new CanvasJS.Chart("chartContainer2", {
     title: {
         text: ""
     },
     exportFileName: "Mesecni, 3 mesecni ili Godisnji",
     axisY: {
         title: "Procenat popunjenosti kapaciteta"
     },
     data: [{
         type: "line",
         dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
     }]
 });
 chart2.render();
 //chart.exportChart({format: "jpg"});
 //chart2.exportChart({format: "jpg"});
}
</script>


