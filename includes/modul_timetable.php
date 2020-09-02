<?php
 check_session();
 
?>
<div id="timetable-wrapper">
    <form id="timetable" method="post" action= "./includes/fragments/timetable_action.php" autocomplete="off">
        <h2 id="redVoznjeNaslov">Red Vožnje</h1>
<hr><hr>
        <div id="timetableTable">
            <label for="startStation">Od:</label> 
            <input list="stationsA" name="startStation" id="startStation" oninput="pronadji('startStation'), callphpfunction('startStation','endStation')" value=""  >
            <datalist id="stationsA">
                <option> Unesite početna slova stanice</option>
            </datalist>
            <br><br><label for="endStation">Do:</label> 
            <input list="stationsB" name="endStation" id="endStation" oninput="pronadji('endStation'), callphpfunction('startStation','endStation')" value=""  >
            
            <datalist id="stationsB">
                <option> Unesite početna slova stanice</option>
            </datalist> 
            <p>Unesite par početnih slova stanice, a zatim u padajućem meniju odaberite željenu stanicu</p>
        </div>      
<hr><hr>
        <button type="submit" class="formButtons" name="timetable" value="Potvrdi">Potvrdi</button>
</form>
</div>

<?php 

include(DIR_INCLUDES.DIR_FRAGS.'show_line.php');

?>

<script>
function pronadji(x) {
        let a = document.querySelector('#'+ x);
        let vrA = String(a.value.trim());
        if (vrA.length >= 1) {
	a.setAttribute('value', vrA);
    }
     
}
window.addEventListener('change keydown paste input',pronadji);

function callphpfunction(x , y) {
        let a = document.querySelector('#'+ x);
        let b = document.querySelector('#'+ y);
        let vrA = String(a.value.trim());
        let vrB = String(b.value.trim());
        
        if (vrA.length >= 1) {
               
                if ($('#stationsA').contents().length == 0) {
                        
                        $('#stationsA').each(function() {
                                $('#startStation').val('');
                                $('#stationsA').html('<option> Unesite početna slova stanice</option>');
                                $('input[name=startStation').val('');
                                $("input[name=startStation").focus();
                                alert('Nema te stanice');
                        }); 
                }
                else {  $.ajax({
                        method: "POST",
                        url: './includes/fragments/getStations.php',
                        data: { pieceA: vrA}
                        })
                        .done(function( data ) {
                                $('#stationsA').html(data);
                        
                        });
                       
                }
        }     
        if (vrB.length >= 1) { 
                        
                if ($('#startStation').val() == "") {

                                $('#stationsB').each(function() {
                                $('input[name=endStation').val('');
                                $("input[name=startStation").focus();
                                alert('Unesite prvo polaznu stanicu');
                                });                
                }
                else {  
                        if ($('#stationsB').contents().length == 0) {
                
                                $('#stationsB').each(function() {
                                $('#endStation').val('');
                                $('#stationsB').html('<option> Unesite početna slova stanice</option>');
                                $('input[name=endStation').val('');
                                $("input[name=endStation").focus();
                                alert('Nema te stanice');
                                }); 
                        }
                        else {  $.ajax({
                        method: "POST",
                        url: './includes/fragments/getStations.php',
                        data: { pieceA: vrA, pieceB: vrB}
                        })
                        .done(function( data ) {
                                $('#stationsB').html(data);
                        });
                        
                        }              
                        
                        
                }       
        }        
        
}
window.addEventListener('change keydown paste input',callphpfunction);
</script>