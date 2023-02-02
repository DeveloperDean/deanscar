<?php 
    session_start();
    $i=trim($_GET['selection']);
    // με αυτη τη συνθήκη δε μπορει να εχει προσβαση κάποιος στη σελίδα απευθείας παρα μόνο απο την page_select.php
    if((!isset($_SESSION['amount'][$i]))||(!isset($_SESSION['car'][$i]))||(!isset($_GET['selection']))){
      header('Location: index.php?msg=Προέκυψε σφάλμα(err030)');
	  session_destroy();
      exit();
        }
    $car=$_SESSION['car'][$i];
    $_SESSION['car']['0']=$car; 		// αυτη η μεταβλητη θα μεταφερθεί στο con_book.php
    $amount=$_SESSION['amount'][$i];
    $_SESSION['amount']['0']=$amount;	// αυτη η μεταβλητη θα μεταφερθεί στο con_book.php
    
    $d_start=$_COOKIE["d_start"];
	$m_start=$_COOKIE["m_start"];
	$y_start=$_COOKIE["y_start"];
	$d_stop=$_COOKIE["d_stop"];
	$m_stop=$_COOKIE["m_stop"];
	$y_stop=$_COOKIE["y_stop"];
    $time_start=$_COOKIE["time_start"];
    $time_stop=$_COOKIE["time_stop"];
    $spot=$_COOKIE["spot"];
	$img_path=$_SESSION['img_path'][$i];
	
	if($spot=="air")
		$x="αεροδρόμιο";
	elseif($spot=="pigadia")
		$x="Πηγάδια";
    
    $fname="";
    $lname="";
    $email="";
    $tel="";
    if (isset($_SESSION['booking_no_del'])){ // σε περίπτωση που αλλαγής υπάρχουσας κράτησης
        $booking_no=$_SESSION['booking_no_del'];
        $lname=$_SESSION['lname_del'];
        $fname=$_SESSION['fname_del'];
        $email=$_SESSION['email_ch'];
        $tel=$_SESSION['tel_ch'];
    }


    echo '
		<div class="dates_select"><p style="text-align: center; font-weight: bold;">Παραλαβή την '.$d_start.'-'.$m_start.'-'.$y_start.' και ώρα  '.$time_start.':00 από '.$x.' και παραδοση την '.$d_stop.'-'.$m_stop.'-'.$y_stop.' και ώρα '.$time_stop.':00</p></div>
		<div class="container2">
			<div class="container3" id="book">
			  <form name="book_form" method="post" onsubmit="return booking();" action="con_book.php">
				  <table class="centeritem">
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr>
						<td colspan="2" class="forma_field_1"><strong>Επώνυμο</strong></td>
						<td colspan="2"><input type="text" id="lname" name="lname" class="forma_field_2" value="'.$lname.'"/></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td colspan="2" id="w_lname" class="wrongmsg"></td>
					</tr>
					<tr>
						<td colspan="2" class="forma_field_1"><strong>Όνομα</strong></td>
						<td colspan="2"><input type="text" id="fname" name="fname" class="forma_field_2" value="'.$fname.'"/></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td colspan="2" id="w_fname" class="wrongmsg"></td>
					</tr>
					<tr>
						<td colspan="2" class="forma_field_1"><strong>E-mail</strong></td>
						<td colspan="2"><input type="email" id="email" name="email"class="forma_field_2" value="'.$email.'"/></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td colspan="2" id="w_email" class="wrongmsg"></td>
					</tr>
					<tr>
						<td colspan="2" class="forma_field_1"><strong>Τηλέφωνο</strong></td>
						<td colspan="2"><input type="tel" id="tel" name="tel"class="forma_field_2" value="'.$tel.'"/></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td colspan="4" id="w_tel" class="wrongmsg">&nbsp;</td>
					</tr>
					<tr><td colspan="4" style="border-bottom: 1px solid black;">&nbsp;</td></tr>
					<tr>
						<td colspan="3"><strong>Ποσό πληρωμης</strong>:</td>
						<td colspan="1">'.$amount.' &euro;</td>
					</tr>
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td colspan="2" id="book_submit"><button class="forma_field_2" name="book" type="submit" value="Κράτηση">Κράτηση</button></td>
					</tr>
					<tr><td colspan="4">&nbsp;</td></tr>
				</table>
				
			  </form>
			</div>
			<div class="">
				<img src="'.$img_path.'" class="centeritem"/>
			</div>
		</div>
		';
		



?>