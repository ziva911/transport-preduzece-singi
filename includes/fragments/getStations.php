<?php
function myphpfunction( ) {
      
      if(isset($_POST['pieceA']) && !isset($_POST['pieceB'])) {
         $pieceA = $_POST['pieceA'];
            
         $conn = new mysqli('localhost', 'root', '', 'autoprevoznik');
         if ($conn->connect_error) die("Greška: " . $conn->connect_error);
      
         $matr = array();
         $matr_station = array();
      
         $sql = "SELECT station_order FROM timetables";
         $result = $conn->query($sql);
         
         foreach($result->fetch_all() as $values) {

            $matr = json_decode($values[0]);
            for($i=0;$i<count($matr);$i++){
               $check = strtolower($matr[$i][1]);
               $pieceA = strtolower($pieceA);

               $len = strlen($pieceA); 
              
               if(substr($check, 0, $len) === $pieceA){
                  if (!in_array($matr[$i][1], $matr_station)) {
                     array_push($matr_station,$matr[$i][1]);
                  }
               }
            }
         }

         sort($matr_station);
      foreach($matr_station as $values) {
         echo '<option>'.$values.'</option>';
      }

      $conn->close();
      }
      else if(isset($_POST['pieceB'])) {
         $pieceA = $_POST['pieceA'];
         $pieceB = $_POST['pieceB'];
            
         $conn = new mysqli('localhost', 'root', '', 'autoprevoznik');
         if ($conn->connect_error) die("Greška: " . $conn->connect_error);
      
         $matr = array();
         $matr_station = array();
      
         $sql = "SELECT station_order FROM timetables";
         $result = $conn->query($sql);
         
         foreach($result->fetch_all() as $values) {

            $matr = json_decode($values[0]);
            $count = count($matr);
            for($i=0;$i<($count-1);$i++) {

               $check = strtolower($matr[$i][1]);
               $pieceA = strtolower($pieceA);

               $len = strlen($pieceA); 
              
               if(substr($check, 0, $len) === $pieceA){
                  
                  for($j=($i+1);$j<$count;$j++) {  
                     $checkB = strtolower($matr[$j][1]);       
                     $pieceB = strtolower($pieceB);

                     $lenB = strlen($pieceB); 
              
                     if(substr($checkB, 0, $lenB) === $pieceB) {
                        if (!in_array($matr[$j][1], $matr_station)) {
                           array_push($matr_station,$matr[$j][1]);
                        }
                     }
                  }   
               }
               else continue;
            }
         }

         sort($matr_station);
         foreach($matr_station as $values) {
         echo '<option>'.$values.'</option>';
      }
      $conn->close();
   }
}
myphpfunction();
    
?>