<?php 
   session_start();
   
   $username = "";
   $email    = "";
   $errors = array(); 
   
   $conn = new mysqli('localhost', 'root', '', 'autoprevoznik');
   
   if (isset($_POST['registerbtn'])) {
     
     $username = mysqli_real_escape_string($conn, $_POST['username']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $jobs = mysqli_real_escape_string($conn, $_POST['jobs']);
     $password = mysqli_real_escape_string($conn, $_POST['loz']);
     $password_r = mysqli_real_escape_string($conn, $_POST['loz-repeat']);
   
     if (empty($username)) { array_push($errors, "Niste uneli korisnicko ime!"); }
     if (empty($email)) { array_push($errors, "Niste uneli email adresu!"); }
     if ($jobs == 0) { array_push($errors, "Niste označili radno mesto novog radnika!"); }
     if (empty($password)) { array_push($errors, "Niste uneli lozinku!"); }
     if ($password != $password_r) {
       array_push($errors, "Ponovljena lozinka se ne poklapa!");
     }
   
     $user_check = "SELECT * FROM users WHERE users_name='$username' OR users_email='$email' LIMIT 1";
     $result = mysqli_query($conn, $user_check);
     $user = mysqli_fetch_assoc($result);
     
     if ($user) { 
       if ($user['users_name'] === $username) {
         array_push($errors, "Odabrano korisnicko ime je vec zauzeto");
       }
   
       if ($user['users_email'] === $email) {
         array_push($errors, "Vec postoji nalog sa odabranom email adresom");
       }
     }

     if (count($errors) == 0) {
         $hash_password = md5($password);
   
         $sql = "INSERT INTO users (users_name, users_email, role_id, password_hash) 
                   VALUES('$username', '$email', '2', '$hash_password')";
         mysqli_query($conn, $sql);
         
         $sql = "SELECT user_id FROM users WHERE users_name='$username' LIMIT 1";
         $result = mysqli_query($conn, $sql);
         $user = mysqli_fetch_assoc($result);
         $user_id = $user['user_id'];
         $sql = "INSERT INTO employees (user_id, working_place) 
                   VALUES('$user_id', '$jobs')";
         mysqli_query($conn, $sql);
        $conn->close();  
         header('location: ../../index.php?modul=pocetna');
         exit();
     }
     else {
        $_SESSION['post_data'] = $errors;
        $conn->close();
        header('location: ../../index.php?modul=register');
        exit();
     }
   }
   
?>