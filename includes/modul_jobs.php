<form method="post" action="./includes/fragments/add_employee.php">
        <div id="registerForm">
            <br>
          <h2>Upisivanje novog zaposlenog</h2>
          <br>
          <p>Molimo vas popunite sledeća polja kako biste dodali novog zaposlenog</p>
          <hr><hr>
          <br>
          <label for="username"><b>Korisničko ime</b></label>
          <input type="text" placeholder="korisničko ime" name="username" required>
          <br><br>
          <hr><hr>
          <br>
          <label for="email"><b>Email adresa</b></label>
          <input type="text" placeholder="something@wbus.com" name="email" required>
          <br><br>
          <hr><hr>
          <br>
          <label for="jobs"><b>Radno mesto</b></label>
          <select name="jobs" required>
                <option value="0">Označite radno mesto novog radnika</option>
                <option value="1">Vozač</option>
                <option value="2">Kondukter</option>
          </select>
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
          
            </div>
          <br><br>
        </div>
      
        
      </form>