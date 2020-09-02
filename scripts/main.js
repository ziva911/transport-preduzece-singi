function validateForm() {
	var x = document.forms["addingStation"]["stationName"].value;
    if (x == "") {
	  alert("Morate uneti ime stanice!");
	  return false;
    }
    else{
        if (!/^[a-zA-Z ]+$/.test(x)) {
            alert("Uneli ste nedozvoljene karaktere! Dozvoljena su samo slova i razmaci.");
            return false;
        }
    }
}

function getSiblings(n) {
    var a = n.parentElement.parentNode.childNodes[1].textContent;
    alert(a);
    return false;
}

function getIndex(n) {
    var a = n.parentElement.parentNode.childNodes[1].textContent;
    var myJSON = JSON.stringify(a);
    fh = fopen("temp.php", 3);
    const fs = require('fs') 
    fwrite(fh, myJSON);
    fclose(fh); 
   return a;
}

function submitTimetable() {
    document.getElementById("timetable-form").action = "./includes/modul_timetable_action.php";
    form.submit();
  }

  function submitTimetable2()
{
    var form = document.getElementById('timetable-form') || null;
    if(form) {
       form.action = './includes/modul_timetable_action.php'; 
       form.submit();
    }



}

function refreshPage() {
    document.location.reload(true);
    
}


function dodaj(x,y) {
    document.getElementById(y).value+=document.getElementById(x).value; 
    return;
} 

function pronadji(x) {
    let a = document.querySelector('#'+ x);
       
    let vrA = String(a.value);
    
    inputF = document.querySelector('#' + x);
    if (vrA.length >= 1) {
	inputF.setAttribute('value', vrA);
    }
     

}
// Initialize and add the map
function initMap() {
    // The location of Uluru
    var uluru = {lat: 44.787, lng: 20.457};
    // The map, centered at Uluru
    var map = new google.maps.Map(
        document.getElementById('map'), {zoom: 8, center: uluru});
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({position: uluru, map: map});
  }









  



 