<?php
  session_start(); 
  //υλοποιεί το logout και ανακατευθύνει στη home με μήνυμα
  require('con_authorized.php');
     //connect to the session...
  session_destroy();  //...and destroy it
  //περνάμε message με GET παραμετρο καθώς δεν υπάρχει 
  //$_SESSION πίνακας γιατί μόλις κλείσαμε το session!
  header("Location: index.php?msg=Έχετε αποσυνδεθεί!");
  exit();
  
?>