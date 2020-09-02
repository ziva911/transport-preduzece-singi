<?php 
   if (isset($_POST['timetable'])  && isset($_POST['startStation']) && isset($_POST['endStation'])) {
   $conn = new mysqli('localhost', 'root', '', 'autoprevoznik');
   if ($conn->connect_error) die("Greška: " . $conn->connect_error);
   else echo 'Konekcija uspostavljena';
   
   $sql = "SELECT timetable_id, station_order FROM timetables";
   
   $result = $conn->query($sql);
   
   if ($result->num_rows == 0) echo "Tabela je prazna";
     else{
      include("../../config/functions.php");
      include("../../config/classes.php");
     error_reporting(E_ALL & ~E_NOTICE);
     
           
             $date = $_POST['inquiryDate'];
             $start = $_POST['startStation'];
             $start = ucwords(strtolower($start));
             $end = $_POST['endStation'];
             $end = ucwords(strtolower($end));
             $moguci = array();

             foreach($result->fetch_all() as $value){
                $order = $value[0];
                 $matr = json_decode($value[1]);
                    $count = count($matr);
                 for($i=0;$i<$count; $i++) 

                    if($matr[$i][1] == $start)
                
                     for($j=$i+1;$j<$count; $j++)
                
                         if($matr[$j][1] == $end) {
                             $s=$j-$i;
                             $s++;
                             $output = array_slice($matr, $i, $s);
                             
                             $txt = json_encode($output);
                             $temp = array();
                             array_push($temp, $order);
                             array_push($temp, $txt);
                             array_push($moguci, $temp);
                        } 
                
            }
            check_session();
           $json = json_encode($moguci);
           session_start();
           $_SESSION['post_data'] = $json;
           $conn->close(); 
            header("Location: ../../index.php?modul=red_voznje");
            exit();
         }
        
     
	
     
          
      }
      else {
         $conn->close();
         header("Location: ../../index.php?modul=red_voznje");
         
         exit();
      }
      
    ?>