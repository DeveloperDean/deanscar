<?php
    session_start();
    $result=$_GET['result'];
	$lname=trim($_GET['surname']);
	$booking_no=trim($_GET['codebooking']);
	$regexp = "/[^A-Z]/i";	// κανονική εκφραση μόνο χαρακτήρες
    $regexp2 = "/[^0-9]/i";	// κανονική εκφραση μόνο αριθμούς
	$regnum = "/[^0-9]/i";	// η συνάρτηση preg_match_all επιστρέφει έναν αριθμο, το ποσες φορές μη επιτρεπτος χαρακτήρας
    //  server side έλεγχοι
	if (( (strlen($booking_no))!=6 )||( (strlen($lname))<3 )||( (strlen($lname))>50 )||( preg_match_all($regexp, $lname)!=0 )||( preg_match_all($regnum, $booking_no)!=0 )||( preg_match_all($regexp2, $booking_no)!=0 ))	
		$result='false';


	
	
	
	
    if ($result=="true"){
		require('db_params.php');
		
		try{
                $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                $pdoObject -> exec('set names utf8');

                $sql = 'SELECT * FROM bookings WHERE lname=:lname AND booking_no=:booking_no;';
                $statement = $pdoObject->prepare($sql);
                $myResult= $statement->execute( array( 	':lname'=>$lname,
														':booking_no'=>$booking_no)  );
                
				if ( $record = $statement -> fetch() ) {	
					$car_id=$record['car_id'];
					$booking_no=$record['booking_no'];
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
                    $status=$record['status'];
                    
                    if ($status=="CANCELED"){
                        echo '
        
                            <table class="forma_field_1">

                                <tr><td style="padding: 1em; color:red;">Λανθασμένο επώνυμο ή αριθμός κράτησης
                                </td></tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr><td><a class="forma_field_2" style= "padding: 0 1em; color:black;" href="page_changes.php">Επιστροφή</a>
                                </td></tr>
                                <tr><td>&nbsp;</td></tr>

                            </table>';
                        exit();
                    }
                    // τοποθετω σε session μεταβλητες που θα χρειαστουν στο επομενο βήμα
                    $_SESSION['booking_no_del']=$booking_no;
                    $_SESSION['lname_del']=$lname;
                    $_SESSION['fname_del']=$fname;
                    $_SESSION['email_ch']=$email;
                    $_SESSION['tel_ch']=$tel;
                    $_SESSION['date_start_del']=$date_start;
                    $_SESSION['date_stop_del']=$date_stop;
                    $_SESSION['car_id_del']=$car_id;
                    

                    echo '<div class="forma_field_3">
                        <p>Το Dins Rent σας καλώς ορίζει '.$fname.' '.$lname.'. Η κράτηση με κωδικό '.$_SESSION['booking_no_del'].' έχει ημερομηνία παραλαβής την '.$date_start.' και ημερομηνία παράδοσης '.$date_stop.' με ώρες '.$time_start.':00 και '.$time_stop.':00 αντίστοιχα από ';
                    if ($spot=='air')
                        echo 'το Αεροδρόμιο της Καρπάθου.</p>';
                    else
                        echo ' τα Πηγάδια Καρπάθου</p>';
                    echo '<p style="text-align:center;">Πως θα θέλατε να συνεχίσετε;</p><button type="button" class="forma_field_2" onclick="booking_change()">Αλλαγή κράτησης</button>       <button class="forma_field_2" style="color:red;"type="button" onclick="deleteFunction()">Ακύρωση         κράτησης</button></div>'; 
				}
				else{
					$result='false';
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
    }
	if ($result=="false"){
        echo '
        
        <table class="forma_field_1">
        
            <tr><td style="padding: 1em; color:red;">Λανθασμένο επώνυμο ή αριθμός κράτησης
            </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><a class="forma_field_2" style= "padding: 0 1em; color:black;" href="page_changes.php">Επιστροφή</a>
            </td></tr>
            <tr><td>&nbsp;</td></tr>
    
        </table>';}
?>