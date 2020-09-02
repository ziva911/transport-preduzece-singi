 <html>
    	<head>
        
		    <script src="./scripts/jquery-3.4.1.min.js"></script>
            <script src="./scripts/main.js"></script>
            <script src="./scripts/glider.js"></script>
            <script src="./scripts/canvasjs.js"></script>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="./css/glider.css"rel="stylesheet" type="text/css" />
            <link href="./css/style.css" rel="stylesheet" type="text/css" />
            <title>WBus Express</title>
        </head>
        <div id="big-wrapper">
<?php 
//za radnike se ne prikazuje logo
if($_SESSION['rola']<=2){
	echo '<div id="header_wrapper"';
        if($modul!='pocetna'&& $modul!='') { echo ' style="background-image: url(\'./images/homepage.jpg\');
                                                           background-position: top -500px left -750px;"';
        }
    
    echo '><div id="header"';
        
    if($modul!='pocetna'&& $modul!='') { echo ' style="background-image: radial-gradient(circle,, #fff, #7e7e7e00);"';
    }    
            
     echo '> 
		        <a href="./index.php?modul=pocetna" id="logoContainer">
		    		<img src="./images/logo-home.png" id="logoImg"/>
                </a>
             	
            </div> 
        </div>';
}
?>
        <div class="cleaner"></div>

