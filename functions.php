<?php

// echo_msg(): τυπώνει πιθανό μήνυμα που έρχετε μέσω URL
// στην παράμετρο msg (άρα είναι στον πίνακα $_GET )
function echo_msg() {

  // η συνάρτηση προϋποθέτει ότι δεν θα έχουμε στείλει message
  // και με τους δύο τρόπους. 

  if (isset($_SESSION['msg'])) { 
    echo '<p class="error_msg">'.$_SESSION['msg'].'</p>';
    unset($_SESSION['msg']);
  } elseif (isset($_GET['msg'])) { 
    $sanitizedMsg= filter_var($_GET['msg'], FILTER_SANITIZE_STRING);
    echo '<p class="error_msg">'.$sanitizedMsg.'</p>';
  }
    
}

function echo_msg_cookies() { //στην προκειμένη περίπτωση το μήνυμα θα αφορά ειδοποίηση ως προς το σκοπό του site
	
		echo '<div id="site_msg" class="site_msg">
				<p>This website is a student project, it is not about a real business.</p>
				<button onclick="site_msgFunction()">OK</button>
			</div>';
  }
    



// δημιουργεί και επιστρέφει έναν 6ψήφιο τυχαίο δεκαεξαδικό
function hex_rand(){
    $a=array("A","B","C","D","E","F","1","2","3","4","5","6","7","8","9","0");
    $random_keys=array_rand($a,16);
    $str="";
    for ($i=0; $i<6; $i++){
        $j=rand(0,15);
        $str=$str.$a[$random_keys[$j]];
    }
    return $str; 
}

?>