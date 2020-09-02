<?php

check_session();	

$akcija = $_GET['modul'] ?? '';
if (!empty($_GET) && !$akcija) idi_na_stranicu('error404.htm');
else if ($akcija) {
	switch ($akcija) {
        case 'login':
            if ($_POST) {
                if (!$_POST) exit;
                extract($_POST);
                if ($korisnicko_ime == '') {
                    ajax_poruka('Unesite korisničko ime');
                }
                else if ($lozinka == '')
                {
                    ajax_poruka('Unesite lozinku');
                }
                else {
                    
                    $sql = "SELECT user_id, users_name password_hash, role_id FROM users WHERE users_name = '$korisnicko_ime' LIMIT 1";
                    $result = mysqli_query($connection, $sql);
                    $user = mysqli_fetch_assoc($result);
                    if($user) {
                        if ($user['password_hash'] == $lozinka) {
                        $_SESSION['ulogovan'] = $user['user_id'];
	                    $_SESSION['ime'] = $korisnicko_ime;
                        $_SESSION['rola'] = $user['role_id'];
                        $_SESSION['post_data'] = "";
                        //$_SESSION['search'] = array();
                             
                        ajax_idi_na_stranicu('index.php');
                        }
                        else ajax_poruka('Uneli ste pogresnu lozinku'); //Dodati da se proverava odredjeni broj puta pre timeout-a
                    }
                    else ajax_poruka('Korisnik nije pronadjen');
                                    
                    ajax_poruka('Niste dobro uneli validno korisničko ime ili lozinku');
                        
                }

            }
            if ($_SESSION['ulogovan'] ?? '') {
                echo'<div class="container"><b>Prijavljeni ste pod imenom <span style="color:rgb(104, 16, 16); font-size:140%;">'.$_SESSION['ime'].'</span></b><br/><br/>';
                echo '<a style="color:rgb(104, 16, 16); text-decoration:none;" href="./index.php?modul=logout">Odjavi se</a></div>';
    		}
            else 
echo<<<HTML
<br>        <div id="registerForm">
    
                <form method="post" target="ajax">
                    <div class="loginForm">
<br>                    <h2>Prijava</h2>
<br>                    <p>Ovde unesite vaše podatke</p>
<hr><hr>
<br>                    <label for="username"><b>Korisničko ime</b></label>
                        <input name="korisnicko_ime" class="inputline">
<br><br>

<br>                    <label for="loz"><b>Lozinka</b></label>
                        <input type="password" name="lozinka" class="inputline">
<br><br>

<br>                    <div id="registerbtnDiv">
                          <button type="submit" name= "registerbtn" value="Pošalji" id="loginbtn">Pošalji</button>
                        </div>
          
                    </div>
                </form>
                
                <iframe name="ajax" style="display: none"></iframe> 
<br><hr><hr>
                <div class="loginForm">
                    <p>Ako nemate nalog, možete se registrovati</p>
                    <button onclick="location.href = './index.php?modul=register'" id="registerbtn">Registracija</button>
<br><br>
            </div>
            </div>
HTML;
       	break;
        case 'logout' :
            $_SESSION['ulogovan'] = 0;
            $_SESSION['ime'] = "Anonymus";
            $_SESSION['rola'] = 1;
            $_SESSION['post_data'] = "";
            $_SESSION['search'] = array();
            idi_na_stranicu('index.php');
        break; 
        case 'register' :
        if ($_SESSION['post_data']) {
            $errors = $_SESSION['post_data'];
            $_SESSION['post_data'] = "";
            $_SESSION['search'] = array();
            echo'<div class="error">';
            if($errors??'')
  	        foreach ($errors as $error) { 
  	        echo '<p>'.$error.'</p>';
            } 
            echo'</div>';
        }
        if ($_SESSION['ulogovan'] ?? '') {
            echo'<div class="container"><b>Prijavljeni ste pod imenom <span style="color:rgb(104, 16, 16); font-size:140%;">'.$_SESSION['ime'].'</span></b><br/><br/>';
            echo '<a style="color:rgb(104, 16, 16); text-decoration:none;" href="./index.php?modul=logout">Odjavi se</a></div>';    
        }
        else 
        echo<<<HTML
            
        <form method="post" action="./includes/fragments/register_action.php">
        <div id="registerForm">
            <br>
          <h2>Registracija</h2>
          <br>
          <p>Molimo vas popunite sledeća polja kako biste kreirali vaš nalog</p>
          <hr><hr>
          <br>
          <label for="username"><b>Korisničko ime</b></label>
          <input type="text" placeholder="korisničko ime" name="username" required>
          <br><br>
          <hr><hr>
          <br>
          <label for="email"><b>Email adresa</b></label>
          <input type="text" placeholder="something@something.com" name="email" required>
          <br><br>
          <hr><hr>
          <br>
          <label for="phone"><b>Telefon (opciono)</b></label>
          <input type="text" placeholder="vaš broj telefona" name="phone">
          <br><br>
          <hr><hr>
          <br>
          <label for="loz"><b>Lozinka</b></label>
          <input type="password" placeholder="unesite lozinku" name="loz" required>
          <br><br>
          <hr><hr>
          <br>
          <label for="loz-repeat"><b>Ponovi Lozinku</b></label>
          <input type="password" placeholder="ponovite lozinku" name="loz-repeat" required>
          <br><br>
          <hr><hr>
          <br>
      
          <div id="registerbtnDiv">
          <button type="submit" name= "registerbtn" id="registerbtn">Potvrdi</button>
          <p>Već imate nalog? <a href="./index.php?modul=login">Prijavite se</a></p>
            </div>
          <br><br>
        </div>
      
        
      </form>
HTML;
        break;                
     
           default :
            idi_na_stranicu('error404.php');
            break;
	}
}
else if ($_SESSION['ulogovan'] ?? '') {
    echo'<div class="container"><b>Prijavljeni ste pod imenom <span style="color:rgb(104, 16, 16); font-size:140%;">'.$_SESSION['ime'].'</span></b><br/><br/>';
    echo '<a style="color:rgb(104, 16, 16); text-decoration:none;" href="./index.php?modul=logout">Odjavi se</a></div>';
}
else
{
    echo'<div class="container"><b>Niste prijavljeni.</b><br/><br/>';
    echo '<a style="color:rgb(104, 16, 16); text-decoration:none;" href="./index.php?modul=login">Prijavi se</a></div>';
}

?>