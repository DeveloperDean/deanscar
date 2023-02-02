<?php
    $title = "Απόδειξη κράτησης";
    require('part_header.php');
    require('db_params.php');
    if (!isset($_SESSION['$booking_no'])){
      header('Location: index.php?msg=Προέκυψε σφάλμα(err050)');
	  session_destroy();
      exit();
	}
    else
        $booking_no=$_SESSION['$booking_no'];
    
    try{
		$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
		$pdoObject -> exec('set names utf8');
		
		$sql = 'SELECT * FROM bookings WHERE booking_no='.$booking_no.';';

		$statement = $pdoObject->prepare($sql);
		$myResult= $statement->execute( array( 	)  );
		while ( $record = $statement -> fetch() ) {
            $car_id=$record['car_id'];
            $lname=$record['lname'];
            $fname=$record['fname'];
            $email=$record['email'];
            $tel=$record['tel'];
            $date_start=$record['date_start'];
            $date_stop=$record['date_stop'];
            $time_start=$record['time_start'];
            $time_stop=$record['time_stop'];
            $spot=$record['spot'];
            $amount=$record['amount'];
			$days_count=$record['days_count'];
		}
		// κλείσιμο αποτελεσμάτων ερωτήματος
		$statement->closeCursor();
		// κλείσιμο σύνδεσης με database
		$pdoObject = null;

	   } catch (PDOException $e) {
		 //σε φάση ανάπτυξης, τυπώνουμε το πρόβλημα
		 echo 'PDO Exception: '.$e->getMessage();
		 //σε φάση λειτουργίας καλύτερα να τυπώσουμε κάτι λιγότερο τεχνικό
	   }


    try{
		$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
		$pdoObject -> exec('set names utf8');
        $sql = 'SELECT * FROM cars WHERE car_id='.$car_id.';';

		$statement = $pdoObject->prepare($sql);
		$myResult= $statement->execute( array( 	)  );
		while ( $record = $statement -> fetch() ) {
            $type_of=$record['type_of'];
            $brand=$record['brand'];
            $model=$record['model'];
		}
        // κλείσιμο αποτελεσμάτων ερωτήματος
		$statement->closeCursor();
		// κλείσιμο σύνδεσης με database
		$pdoObject = null;

	   } catch (PDOException $e) {
		 //σε φάση ανάπτυξης, τυπώνουμε το πρόβλημα
		 echo 'PDO Exception: '.$e->getMessage();
		 //σε φάση λειτουργίας καλύτερα να τυπώσουμε κάτι λιγότερο τεχνικό
	   }

    if($spot=="air")
		$spot="AIRPORT";
	elseif($spot=="pigadia")
		$spot="PIGADIA";
		
	echo_msg_cookies();
    echo '<main>
        <div class="centeritem">
            <table style="width:100%; border:1px solid black;">
                <tr><td colspan="3" style="text-align: center;"><h1>BOOKING CONFIRMATION</h1></td></tr>
                <tr><td colspan="2">&nbsp;</td>                 <td>'.date("l, d-m-Y").'</td></tr>
                <tr><td>BOOKING </td><td>'.$booking_no.'</td>  <td style="border-left:1px dashed black; border-top:1px dashed  black;"><h2>Dins Rent</h2></td></tr>
                <tr><td colspan="2"></td>                       <td style="border-left:1px dashed black;">Pigadia Karpathos</td></tr>
                <tr><td colspan="2">&nbsp;</td>                 <td style="border-left:1px dashed black;">Dodecanisa, 85700</td></tr>
                <tr><td>BOOKING DATES</td><td>&nbsp;</td>     	<td style="border-left:1px dashed black;">Greece</td></tr>
                <tr><td>CHECK IN</td><td>'.$date_start.'</td>   <td style="border-left:1px dashed black;"></td></tr>
                <tr><td>CHECK OUT</td><td>'.$date_stop.'</td>   <td style="border-left:1px dashed black;">bookings@ntinos.site</td></tr>
                <tr><td colspan="2">&nbsp;</td>                 <td style="border-left:1px dashed black; border-bottom:1px dashed black;">www.ntinos.site</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>            <td>&nbsp;</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>            <td>&nbsp;</td></tr>
                <tr><td>BOOKED BY</td><td>&nbsp;</td>           <td>&nbsp;</td></tr>
                <tr><td>NAME</td><td colspan="2">'.$lname.' '.$fname.'</td> </tr>
                <tr><td>E-MAIL</td><td colspan="2">'.$email.'</td>          </tr>
                <tr><td>PHONE</td><td>'.$tel.'</td>             <td></td></tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td style="text-decoration: underline;">Details</td><td colspan="2">&nbsp;</td></tr>
                <tr><td>CAR TYPE</td><td>'.$brand.' '.$model.'</td><td></td></tr>
                <tr><td>CLASS</td><td>'.$type_of.'</td></tr>
                <tr><td>TAKE</td><td>'.$time_start.':00 FROM '.$spot.'</td><td> '.$days_count.' DAYS </td></tr>
                <tr><td>RETURN</td><td>'.$time_stop.':00 TO '.$spot.'</td><td> '.$amount/$days_count.' &euro; PER DAY </td></tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td colspan="2"></td><td style="text-decoration: overline;">TOTAL : '.$amount.'&euro;</td></tr>
                <tr><td></td></tr>                
            </table>
        </div>
		<div class="centeritem">
				<button onclick="window.print();" class="noprint" style="margin-left: 40%;"><img src="images/print.png" alt="Εκτύπωση"/></button>
				<button onclick="goto();" class="noprint"><img src="images/home.png" alt="Αρχική σελίδα"/></button>
		</div>	
	</main>';
    // αποστολή email
    $msg = '<html>
            <head>
            <title>This is a test HTML email</title>
            </head>
            <body>
            <h1>Dins Rent</h1>
            <p>Dear '.$lname.' '.$fname.',</p>
            <p>Your booking is : '.$booking_no.'</p>
            <p>From '.$date_start.' to '.$date_stop.'</p>
            <p>* This is a student project! It is not about a real business! Thank you.</p>
            </body>
            </html>';
    $from = "booking@ntinos.site";
    $subject = "Dins rent booking";
    $headers = "MIME-Version: 1.0"."\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
    $headers .= 'From: <booking@ntinos.site>' . "\r\n";
    mail($email,$subject,$msg,$headers);
    
    unset($_SESSION['$booking_no']);
	require('part_footer.php');
?>