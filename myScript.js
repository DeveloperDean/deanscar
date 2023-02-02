//------------ function for slide show  ------------

var slideIndex = 0;
function showSlides() {
              var i;
              var slides = document.getElementsByClassName("mySlides");
              var dots = document.getElementsByClassName("dot");
              for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
              }
              slideIndex++;
              if (slideIndex > slides.length) {slideIndex = 1}    
              for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
              }
              slides[slideIndex-1].style.display = "block";  
              dots[slideIndex-1].className += " active";
              setTimeout(showSlides, 3000); // Change image every 3 seconds
}

//------------ finish of function for slide show  ------------




//------------ function for cookie message  ------------



function site_msgFunction() {
	document.cookie = "site_message=OK";
	document.getElementById("site_msg").style.display = "none";
}






//------------ function for date validation  ------------

function date_validation(){
    var result=true;
    var x=document.getElementById("datestart").value;
    document.getElementById("datestart").innerHTML=x;
    var datestart = new Date(x);
    
    var x=document.getElementById("datestop").value;
    document.getElementById("datestop").innerHTML=x;
    var datestop = new Date(x);
    
    var datenow = new Date( Date.now() );  //ημερομηνία (σήμερα)
    
    if ( (datestart=="Invalid Date")||(datestop=="Invalid Date") ){
        alert("Παρακαλώ επιλέξτε ημερομηνία");
        result=false;
    }
    
    
    if ( (datestart<datenow) || (datestop<=datestart) ) {
        var d=datenow.getDate();       
        var m=datenow.getMonth();               
        m++;                                    
        var y=datenow.getFullYear();           

        datenow = (d + "-" + m + "-" + y);
        
        alert("Μη αποεκτές ημερομηνίες");
        result=false;
    }
    
        d=datestart.getDate();               
        m=datestart.getMonth();             //
        m++;
        y=datestart.getFullYear();          //
        
        datestart = (d + "-" + m + "-" + y);//  μετατροπη των μεταβλητων date σε string 
        
        d=datestop.getDate();               //
        m=datestop.getMonth();              //
        m++;                                //  ωστε να περαστουν στη php και να ειναι πιο ευχρηστες
        y=datestop.getFullYear();           //
        
        datestop = (d + "-" + m + "-" + y); // την "/" την αναγνωριζει η PHP και το μεταφραζει ως αμερικανικου τυπου ημ/νια
                                            // την "-" την μεταφραζει εώς ευρωπαικού τυπου
    if (result==true){
      const xhttp = new XMLHttpRequest();
      document.getElementById("forma").innerHTML = "<img src='images/load2.gif'/>";
      
      setTimeout(timeFunction, 1000);   // delay 1 sec
      function timeFunction() {         // delay 1 sec
      xhttp.onload = function() {
        
        document.getElementById("forma").innerHTML = this.responseText;
        }
      xhttp.open("GET", "ajax_dates.php?datestart=" + datestart + "&datestop=" + datestop);
      xhttp.send();
    }                                   // delay 1 sec
    }
    
    
    return false;
    
}


//------------ finish for function for date validation  ------------



//------------ function for date validation (changes) ------------

function date_validation2(){
    var result=true;
    var x=document.getElementById("datestart").value;
    document.getElementById("datestart").innerHTML=x;
    var datestart = new Date(x);
    
    var x=document.getElementById("datestop").value;
    document.getElementById("datestop").innerHTML=x;
    var datestop = new Date(x);
    
    var datenow = new Date( Date.now() );  //ημερομηνία (σήμερα)
    
    if ( (datestart=="Invalid Date")||(datestop=="Invalid Date") ){
        alert("Παρακαλώ επιλέξτε ημερομηνία");
        result=false;
    }
    
    
    if ( (datestart<datenow) || (datestop<=datestart) ) {
        var d=datenow.getDate();       
        var m=datenow.getMonth();               
        m++;                                    
        var y=datenow.getFullYear();           

        datenow = (d + "-" + m + "-" + y);
        
        alert("Μη αποεκτές ημερομηνίες");
        result=false;
    }
    
        d=datestart.getDate();               
        m=datestart.getMonth();             //
        m++;
        y=datestart.getFullYear();          //
        
        datestart = (d + "-" + m + "-" + y);//  μετατροπη των μεταβλητων date σε string 
        
        d=datestop.getDate();               //
        m=datestop.getMonth();              //
        m++;                                //  ωστε να περαστουν στη php και να ειναι πιο ευχρηστες
        y=datestop.getFullYear();           //
        
        datestop = (d + "-" + m + "-" + y); // την "/" την αναγνωριζει η PHP και το μεταφραζει ως αμερικανικου τυπου ημ/νια
                                            // την "-" την μεταφραζει εώς ευρωπαικού τυπου
    if (result==true){
      const xhttp = new XMLHttpRequest();
      document.getElementById("forma").innerHTML = "<img src='images/load2.gif'/>";
      
      setTimeout(timeFunction, 1000);   // delay 1 sec
      function timeFunction() {         // delay 1 sec
      xhttp.onload = function() {
        
        document.getElementById("forma").innerHTML = this.responseText;
        }
      xhttp.open("GET", "ajax_search_dates.php?datestart=" + datestart + "&datestop=" + datestop);
      xhttp.send();
    }                                   // delay 1 sec
    }
    
    
    return false;
    
}


//------------ finish for function for date validation (changes) ------------





//------------ function for time select  ------------

function time_validation() {
	var result=true;
	var x=document.getElementById("time_start").value;
	var y=document.getElementById("time_stop").value;
	var z=document.getElementById("spot").value;
	//const xhttp = new XMLHttpRequest();
	//document.getElementById("forma").innerHTML = "<img src='images/load2.gif'/>";
    //setTimeout(timeFunction, 1000);   // delay 1 sec
    //function timeFunction() {window.location.replace("page_select.php");}
	//timeFunction();
	
	return result;
}


//------------ finish function time select  ------------






//------------ function for booking changes  ------------

function booking_validation() {
    var result=true;
    var surname = document.getElementById("surname").value;
    var codebooking = document.getElementById("codebooking").value;
	var legalChar = new RegExp("[^A-Za-z]");
	var minima=("");
    
	if (legalChar.test(surname)||(surname.length<3)){
		result=false;
		minima += "- Μη αποδεκτό επώνυμο!\n";

	}
    
    var legalNum = new RegExp("[^0-9]");
    
	if ((codebooking.length!=6)||legalNum.test(codebooking)) {
		result=false;
		minima += "- Μη αποδεκτός αριθμός κράτησης!\n";
	}
    
    
    
      const xhttp = new XMLHttpRequest();
      document.getElementById("forma").innerHTML = "<img src='images/load2.gif'/>";
      
      setTimeout(timeFunction, 1000);   // delay 1 sec
      function timeFunction() {         // delay 1 sec
        xhttp.onload = function() {
        
        document.getElementById("forma").innerHTML = this.responseText;
        }
      xhttp.open("GET", "ajax_changes.php?result=" + result + "&surname=" + surname + "&codebooking=" + codebooking );
      xhttp.send();
    }                                   // delay 1 sec
}

//------------ finish for function for booking changes  ------------



//------------  function for making changes  ------------
function booking_change() {
      const xhttp = new XMLHttpRequest();
      document.getElementById("forma").innerHTML = "<img src='images/load2.gif'/>";
      
      setTimeout(timeFunction, 1000);   // delay 1 sec
      function timeFunction() {         // delay 1 sec
        xhttp.onload = function() {
        
        document.getElementById("forma").innerHTML = this.responseText;
        }
      xhttp.open("GET", "ajax_changes_dates.php");
      xhttp.send();
    }                                   // delay 1 sec
}



//------------ finish for function for making changes  ------------



//------------ function for login  ------------

function login_validation() {
    var result=true;
    var username = document.getElementById("login_un").value;
    var legalChar = new RegExp("[^A-Za-z0-9!@#$%^&*-_]");
    
    if (legalChar.test(username)||(username.length<7)){
        result=false;
        }

	
    var password = document.getElementById("login_pw").value;
    if (legalChar.test(password)||(password.length<9)){
        result=false;
        }
    if(result==false){
        document.getElementById("msg").innerHTML = "Αποτυχιμένη σύνδεση!";
        document.getElementById("login_un").value = "";
        document.getElementById("login_pw").value = "";
    }
    return result;
}

//------------ finish for function for login  ------------



//------------  function for contact  ------------

function contact_validation(){
    var result=true;
    var lname = document.getElementById("lname").value;
    var legalChar = new RegExp("[^A-Za-zΑΒΓΔΕΖΗΘΙΚΛΜΝΗΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωάέίήύόώϊϋΆΈΊΉΎΌΏΪΫ]");
    if (legalChar.test(lname)||(lname.length<3)){
		result=false;
		document.getElementById("lname").value = "";
        document.getElementById("lname").placeholder = "Μη αποδεκτό επώνυμο!";
	}
    
    var fname = document.getElementById("fname").value;
    if (legalChar.test(fname)||(fname.length<3)){
		result=false;
        document.getElementById("fname").value = "";
		document.getElementById("fname").placeholder = "Μη αποδεκτό όνομα!";
	}
    
    var email = document.getElementById("email").value;
    var apotelesma = looks_like_email(email);
    if ( apotelesma==false ) {
        result=false;
        document.getElementById("email").value = ""; 
        document.getElementById("email").placeholder = "Μη αποδεκτό email!";
    }
    
    var text = document.getElementById("text").value;
    if (text.length<6){
		result=false;
        document.getElementById("text").value = "";
		document.getElementById("text").placeholder = "Πολύ μικρό μήνυμα...";
	}
     if (text.length>200){
		result=false;
        document.getElementById("text").value = "";
		document.getElementById("text").placeholder = "Πολύ μεγάλο μήνυμα...";
	}
    if (result==true)
        document.getElementById("contactform").value = "Το μήνυμα ετσαλη.";
        
    return result;
    
}


//------------ finish  contact  ------------





function select(i){
    const xhttp = new XMLHttpRequest();
    document.getElementById("container").innerHTML = "<div class='loading'><img src='images/load2.gif'/></div>";
    setTimeout(timeFunction, 1000);   // delay 1 sec
      function timeFunction() {         // delay 1 sec
        xhttp.onload = function() {
        
        document.getElementById("container").innerHTML = this.responseText;
        }
      xhttp.open("GET", "ajax_select.php?selection=" + i);
      xhttp.send();
    } 
} 



// - - - - - - - function for booking stoixeia - - - - - -



function booking() {
    var result=true;
    var lname=document.getElementById("lname").value;
    var legalChar = new RegExp("[^A-Za-z]");
    if (legalChar.test(lname)||(lname.length<3)){
		document.getElementById("w_lname").innerHTML = "Μη αποδεκτό επώνυμο!";
		result=false;
	}
    else
        document.getElementById("w_lname").innerHTML = "";
    
	var fname=document.getElementById("fname").value;
    var legalChar = new RegExp("[^A-Za-z]");
    if (legalChar.test(fname)||(fname.length<3)){
		result=false;
		document.getElementById("w_fname").innerHTML = "Μη αποδεκτό όνομα!";
	}
    else
        document.getElementById("w_fname").innerHTML = "";
    
	var email=document.getElementById("email").value;
	apotelesma = looks_like_email(email);
    if ( apotelesma==false ) {
    result=false;
    document.getElementById("w_email").innerHTML = "Μη αποδεκτό email!";
    }
    else
        document.getElementById("w_email").innerHTML = "";
    
    var tel=document.getElementById("tel").value;
    var legalChar = new RegExp("[^0-9]");
    
	if ((tel.length<10)||(tel.length>15)||legalChar.test(tel)) {
		result=false;
		document.getElementById("w_tel").innerHTML = "Μη αποδεκτό τηλέφωνο!";
	}
	else
        document.getElementById("w_tel").innerHTML = "";
	
    if (result==true){
        document.getElementById("book_submit").innerHTML = "<td colspan='5' style='margin:auto;'><img src='images/load.gif'/></td>";
    }
    
    return result;
}



// - - - - - - - function for add car - - - - - -


function add_car(){
    var result=true;
    var brand = document.getElementById("car_brand").value;
    var legalChar = new RegExp("[^A-Za-z0-9 ]");
    if (legalChar.test(brand)||(brand.length>30)||(brand.length<1)){
		result=false;
		document.getElementById("w_brand").innerHTML = "Μόνο λατινικοί χαρακτήρες και αριθμοί";
	} else
        document.getElementById("w_brand").innerHTML = "&nbsp;";
    
    var type = document.getElementById("car_type").value;
    if (legalChar.test(type)||(type.length>30)||(type.length<1)){
		result=false;
		document.getElementById("w_type").innerHTML = "Μόνο λατινικοί χαρακτήρες και αριθμοί";
	} else
        document.getElementById("w_type").innerHTML = "&nbsp;";
        
    return result;
    
}


// - - - - - - - finish add car - - - - - -



// - - - - - - - finish edit / duplicate car - - - - - -



function edit_add_car(car_id){
    const xhttp = new XMLHttpRequest();
    document.getElementById(car_id).innerHTML = "";
    document.getElementById(car_id).innerHTML = "<td colspan='5' style='margin:auto;'><img src='images/load.gif'/></td>";
    setTimeout(timeFunction, 1000);   // delay 1 sec
    function timeFunction() {         // delay 1 sec
    xhttp.onload = function() {
    document.getElementById('books_table').innerHTML = "";
    document.getElementById('books_table').innerHTML = this.responseText;
    }
    xhttp.open("GET", "con_edit_car.php?car_id=" + car_id + "&purpose=duplicate");
    xhttp.send();
    }
}


function edit_delete_car(car_id){
    if (confirm('Θέλετε να διαγραψετε το αυτοκίνητο;')) {
        const xhttp = new XMLHttpRequest();
        document.getElementById(car_id).innerHTML = "";
        document.getElementById(car_id).innerHTML = "<td colspan='5' style='margin:auto;'><img src='images/load.gif'/></td>";
        setTimeout(timeFunction, 1000);   // delay 1 sec
        function timeFunction() {         // delay 1 sec
        xhttp.onload = function() {
        document.getElementById(car_id).innerHTML = "";
        document.getElementById(car_id).innerHTML = this.responseText;
        }
        xhttp.open("GET", "con_edit_car.php?car_id=" + car_id + "&purpose=delete");
        xhttp.send();
        }
    } else {
      // Do nothing!
    }
     
}



// - - - - - - - finish edit / duplicate car - - - - - -


// - - - - - - - function for update price - - - - - -



function update_price(category_id){
    var id='class'+category_id;
    var price = document.getElementById(id).value;
    var id='update'+category_id;
    const xhttp = new XMLHttpRequest();
    document.getElementById(id).innerHTML = "";
    document.getElementById(id).innerHTML = "<td colspan='5' style='margin:auto;'><img src='images/load1.gif'/></td>";
    
    setTimeout(timeFunction, 1000);   // delay 1 sec
    function timeFunction() {         // delay 1 sec
        xhttp.onload = function() {
            document.getElementById(id).innerHTML = "";
            document.getElementById(id).innerHTML = this.responseText;
        }
        xhttp.open("GET", "con_update_price.php?id=" + category_id + "&price=" + price);
        xhttp.send();
    }
}




// - - - - - - - finish eupdate price - - - - - -


function available_admin(){
    var month=document.getElementById("month").value;
    var year=document.getElementById("year").value;
    //var car="cars"+month+year;          //δημιουργούμε το όνομα του μήνα όπως ειναι στη ΒΔ
    const xhttp = new XMLHttpRequest();
    document.getElementById("avalaible_table").innerHTML = "";
    document.getElementById("loading").innerHTML = "<div><img src='images/load2.gif'/></div>";
    setTimeout(timeFunction, 1000);   // delay 1 sec
      function timeFunction() {         // delay 1 sec
        xhttp.onload = function() {
        document.getElementById("loading").innerHTML = "";
        document.getElementById("avalaible_table").innerHTML = this.responseText;
        }
      xhttp.open("GET", "ajax_available.php?month=" + month + "&year=" + year);
      xhttp.send();
    } 
}


function books_admin(){
    var selection=document.getElementById("selection").value;
    var order=document.getElementById("order").value;
    var checkbox = document.getElementById("checkbox");
    if (checkbox.checked == true){
        checkbox = "show";
      } else {
        checkbox = "hide";
      }
    var input_text=document.getElementById("input_text").value;
    document.getElementById("book_id").innerHTML = '<input id="input_text" type="text" class="forma_field_2" onclick="return books_admin_id();" value="Κωδικός κράτησης" style="color:gray; text-align:center;"/>';
    const xhttp = new XMLHttpRequest();
    document.getElementById("book_result").innerHTML = "";
    document.getElementById("loading").innerHTML = "<div><img src='images/load2.gif'/></div>";
    setTimeout(timeFunction, 1000);   // delay 1 sec
      function timeFunction() {         // delay 1 sec
        xhttp.onload = function() {
        document.getElementById("loading").innerHTML = "";
        document.getElementById("book_result").innerHTML = this.responseText;
        }
      xhttp.open("GET", "ajax_books.php?selection=" + selection + "&order=" + order + "&input_text=" + input_text + "&checkbox=" + checkbox);
      xhttp.send();
    }
}

function books_admin_id(){
    document.getElementById("input_text").onclick = '';
    document.getElementById("input_text").style = '';
    document.getElementById("input_text").value = '';
}

function looks_like_email(str) {
  var apotelesma=true;
  var papaki = str.indexOf("@");    //η θεση του @ στο str
  var teleia = str.indexOf(".");         //η θεση της . στο str
  var teleiaMeta = str.indexOf(".", papaki); //θεση της . μετά το @
  
  if (papaki<=0) apotelesma = false; 
  
  if (teleia<0) apotelesma = false; 
  
  if (teleiaMeta-papaki==1) apotelesma = false; 
  
  if ( str.indexOf(".")==0  ||  str.lastIndexOf(".")==str.length-1 ) apotelesma = false; 
  
  return apotelesma;
}




function goto() {
	window.location.href = "index.php";
}





function deleteFunction(){
            
    if (confirm('Θέλετε να ακυρώσετε την κράτηση;')) {
      window.location.href = "con_cancel.php?answere=yes";
    } else {
      // Do nothing!
    }

}


function deleteMonthFunction(){
    if (confirm('Θέλετε να αφαιρέσετε το μήνα; Μαζί θα αφαιρεθούν και τυχών κρατήσεις!')) {
      var month_add=document.getElementById("month_add").value;
      var year_add=document.getElementById("year_add").value;
      window.location.href = "con_add_month.php?answere=yes&month_add=" + month_add + "&year_add=" + year_add;
    } else {
      // Do nothing!
    }
}

