<?php
check_session();
if($_SESSION['rola']>2){
	
    $today_date=date('Y-m-d');
    $sql2 = "SELECT timetable_id FROM timetables";
    $result2 = $connection->query($sql2);
    $lines=array();
    foreach($result2->fetch_all() as $line_row){
        $line_number = $line_row[0];
        array_push($lines, $line_number);
    }
    
	for($i=0;$i<=3 ;$i++){
        $check_date = date('Y-m-d', strtotime(" $i days"));
        foreach($lines as $values) {
        
        $sql = "SELECT warrant_date, timetable_id FROM warrants WHERE warrant_date='$check_date' AND timetable_id='$values'";
        $result = $connection->query($sql);
        $sql = "";
        if ($result->num_rows > 0) continue;
        else {
            $sql_vehicle = "SELECT vehicle_id FROM vehicles LIMIT 1";
            $result2 = $connection->query($sql_vehicle);
            $row = $result2->fetch_assoc();
            $vehicle = $row['vehicle_id'];
            

            $sql_driver = "SELECT employee_id FROM employees WHERE working_place=1 LIMIT 1";
            $result2 = $connection->query($sql_driver);
            $row = $result2->fetch_assoc();
            $driver = $row['employee_id'];
            

            $sql_conducter = "SELECT employee_id FROM employees WHERE working_place=2 LIMIT 1";
            $result2 = $connection->query($sql_conducter);
            $row = $result2->fetch_assoc();
            $conducter = $row['employee_id'];
            
            $sql_conducter= "";

            $sql3 = "INSERT INTO warrants (warrant_date, vehicle_id, timetable_id, driver_id, conducter_id)
            VALUES ('$check_date', '$vehicle', '$values', '$driver', '$conducter')";
            $connection->query($sql3);
            
            }
            
          
            }
        }
		
	}
    




?>