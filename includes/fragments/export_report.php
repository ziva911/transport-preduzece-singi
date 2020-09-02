<?php
if (isset($_POST['preuzmi'])) {
//error_reporting(E_ALL & ~E_NOTICE);
include("../../config/functions.php");
include("../../config/classes.php");
session_start();
ignore_user_abort(true);
    $user = $_SESSION['ime'];
    $file = $user." - WBUS izvestaj.doc";
    fopen($file , "w");
    $niz = $_POST['preuzmi'];
    file_put_contents($file , "$niz");
    
    $type = filetype($file);
    // Send file headers
    header("Content-type: $type");
    header('Content-type: text/plain; charset=utf-8');
    header("Content-Disposition: attachment;filename={$file}");
    header("Content-Transfer-Encoding: binary"); 
    header('Pragma: no-cache'); 
    header('Expires: 0');
    // Send the file contents.
    set_time_limit(0); 
    readfile($file);
   unlink($file);
}
?>



