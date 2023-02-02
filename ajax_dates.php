<?php 

	// Πολύ σημαντική σελίδα!! Κάνει όλη τη δουλεια
	// δεχεται τις ημερομηνιες και τις διαχωριζει σε μεταβλητες ημερας - μηνα -  ετους για να γινεται πιο ευκολα η συγκριση
	// αναζητα να βρει ποια αυτοκίνητα ειναι διαθεσιμα 
	// και επιστρέφει ως αποτελεσμα μόνο ένα αυτοκίνητο ανα είδος, το πρωτο που θα βρει βάση του id

	$datestart = trim($_GET["datestart"]);
    $datestop = trim($_GET["datestop"]);
	$date = date($_GET["datestart"]);   //διαχωρισμός σε ξεχωριστες μεταβλητες για ημερα μηνα χρονο
	$date_arr = explode("-", $date);

	if ($date_arr[0]<10)
        $d_start = '0'.$date_arr[0];
    else
        $d_start = $date_arr[0];

    if ($date_arr[1]<10)
        $m_start = '0'.$date_arr[1];
    else
        $m_start = $date_arr[1];
	
	$y_start = $date_arr[2];

	$date = date($_GET["datestop"]);    //διαχωρισμός σε ξεχωριστες μεταβλητες για ημερα μηνα χρονο
	$date_arr = explode("-", $date);

	if ($date_arr[0]<10)
        $d_stop = '0'.$date_arr[0];
    else
        $d_stop = $date_arr[0];

    if ($date_arr[1]<10)
        $m_stop = '0'.$date_arr[1];
    else
        $m_stop = $date_arr[1];
	
	$y_stop = $date_arr[2];
	
	//εαν για καποιο λόγο μία απο αυτές τις μεταβλητές δεν ειναι αριθμός
	if ((is_numeric($d_start)!=1)||(is_numeric($m_start)!=1)||(is_numeric($y_start)!=1)||(is_numeric($d_stop)!=1)||(is_numeric($m_stop)!=1)||(is_numeric($y_stop)!=1)){	
	  header('Location: index.php?msg=Προέκυψε σφάλμα(err010)');
	  session_destroy();
      exit();
	}
    $start_d = "cars".$m_start.$y_start;
    $stop_d = "cars".$m_stop.$y_stop;
	
	$days_count=0;			// μετρητής για τις συνολικες μερες ενοικίασης

	$result="true";
    $result0="true";		// Θα γίνει false εαν δωθουν εσφαλμένες ημερομηνίες

	$resaultCar = array();	// αυτή η μεταβλητη επιστρέφει αν το αντιστοιχο αυτικίνητο είναι διαθέσιμο τις ημερομηνίες

    require('db_params.php');
	try {
		$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
		$pdoObject -> exec('set names utf8');
		
		$sql='SELECT car_id FROM cars ORDER BY car_id DESC LIMIT 1;';
		$statement = $pdoObject->prepare($sql);
		$statement->execute();
        if ($record = $statement -> fetch()) {
            $totalcars = $record['car_id'];				// βρησκουμε το τελευται id των αυτοκινητων το οποίο ανγκαστικά ειναι και το μεγαλύτερο
        }
		for ($i=1;$i<=$totalcars;$i++){
			$resaultCar[$i]="false";					// θετουμε όλα τα id ως false
		}
		
		$sql='SELECT car_id FROM cars ORDER BY car_id;';
		$statement = $pdoObject->prepare($sql);
		$statement->execute();
        while ($record = $statement -> fetch()) {
            $i = $record['car_id'];						// ελέγχουμε ποιά id αντιστοιχούν σε αυτοκίνητα και θετουμε την τιμή true (οτι ειναι διαθέσιμα) 
            $resaultCar[$i]="true";						// σε μεταγενέστερο χρόνο θα ελέγξουμε στου πινακες των μηνων εαν οντως ειναι διαθεσιμα
        }
        $statement->closeCursor();
        $pdoObject = null;
    }
	catch (PDOException $e) {
	// σε περίπτωση που δεν εκτελεστει το query
	header('Location: index.php?msg=Προέκυψε σφάλμα(er110)');
	exit();
	}




    // μεγιστος αριθμός ημερών ενοικίασης ειναι οι 30 ή 31 (δηλαδή πέραν του μηνός)


    // περιπτωση που έχει επιλέξει κράτηση με διαφορετικό έτος -------------



    if ($y_start!=$y_stop){
        if (($y_stop-$y_start)>=2)
            $result0="false";
        elseif($m_start<=11||$m_stop>=2)
            $result0="false";
        elseif(((31-$d_start)+$d_stop)>30)
            $result0="false";
        else{
            // echo '<p>'.$start_d.'</p>';
            // echo '<p>'.$stop_d.'</p>';
            
            try{
                $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                $pdoObject -> exec('set names utf8');

                $sqlA[0] = 'SELECT * FROM '.$start_d.' WHERE days>='.$d_start.';';
                $sqlA[1] = 'SELECT * FROM '.$stop_d.' WHERE days<='.$d_stop.';';
                $month[0] = $m_start;
                $month[1] = $m_stop;
                for ($i=0;$i<2;$i++){
                    
                    $sql = $sqlA[$i];
                    
                    $statement = $pdoObject->prepare($sql);
                    $myResult= $statement->execute( array( 	)  );

                    while ( $record = $statement -> fetch() ) {
						$days_count++;
						$days=$record['days'];
						for ($x=1;$x<=$totalcars;$x++){
								if ($resaultCar[$x]!="false"){			// εαν κάποιο id δεν αντιστοιχεί σε αυτοκίνητο ή το αυτοκίνητο που αντιστοιχει δεν ειναι διαθεσιμο
										$cartemp='car'.$x;				// δεν υπάρχεο λόγος να συνεχίσουμε τους ελέγχους
										$car=$record[$cartemp];
										if ($car!=0)
											$resaultCar[$x]="false";
								}
						}
                    }
                }
                
                // κλείσιμο αποτελεσμάτων ερωτήματος
                $statement->closeCursor();
                // κλείσιμο σύνδεσης με database
                $pdoObject = null;

               } catch (PDOException $e) {
                $result="false";
               }
        }
        
    }



    // περίπτωση που έχει επιλέει ίδιο έτος αλλά διφορετικό μήνα  ---------


    elseif ($m_start!=$m_stop){
        if (($m_stop-$m_start)>=2)
            $result0="false";
        elseif(((31-$d_start)+$d_stop)>30)
            $result0="false";
        else{
            // echo '<p>'.$start_d.'</p>';
            // echo '<p>'.$stop_d.'</p>';
            try{
                $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                $pdoObject -> exec('set names utf8');

                $sqlA[0] = 'SELECT * FROM '.$start_d.' WHERE days>='.$d_start.';';
                $sqlA[1] = 'SELECT * FROM '.$stop_d.' WHERE days<='.$d_stop.';';
                $month[0] = $m_start;
                $month[1] = $m_stop;
                for ($i=0;$i<2;$i++){
                    
                    $sql = $sqlA[$i];
                    
                    $statement = $pdoObject->prepare($sql);
                    $myResult= $statement->execute( array( 	)  );

                    while ( $record = $statement -> fetch() ) {
						$days_count++;
						$days=$record['days'];
						for ($x=1;$x<=$totalcars;$x++){
								if ($resaultCar[$x]!="false"){			// εαν κάποιο id δεν αντιστοιχεί σε αυτοκίνητο ή το αυτοκίνητο που αντιστοιχει δεν ειναι διαθεσιμο
										$cartemp='car'.$x;				// δεν υπάρχεο λόγος να συνεχίσουμε τους ελέγχους
										$car=$record[$cartemp];
										if ($car!=0)
											$resaultCar[$x]="false";
								}
						}
					}
                }
                // κλείσιμο αποτελεσμάτων ερωτήματος
                $statement->closeCursor();
                // κλείσιμο σύνδεσης με database
                $pdoObject = null;
				
               } catch (PDOException $e) {
                    $result="false";
               }
        }
    }



    //περίπτωση που είναι στον ίδιο μήνα  -----------







    else {
	  try{
		$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
		$pdoObject -> exec('set names utf8');
		
		$sql = 'SELECT * FROM '.$start_d.' WHERE days>='.$d_start.' AND days<='.$d_stop.';';

		$statement = $pdoObject->prepare($sql);
		$myResult= $statement->execute( array( 	)  );
		while ( $record = $statement -> fetch() ) {
			
			$days_count++;
            $days=$record['days'];
            for ($x=1;$x<=$totalcars;$x++){
					if ($resaultCar[$x]!="false"){			// εαν κάποιο id δεν αντιστοιχεί σε αυτοκίνητο ή το αυτοκίνητο που αντιστοιχει δεν ειναι διαθεσιμο
							$cartemp='car'.$x;				// δεν υπάρχεο λόγος να συνεχίσουμε τους ελέγχους
							$car=$record[$cartemp];
							if ($car!=0)
								$resaultCar[$x]="false";
					}
			}   
		}
		// κλείσιμο αποτελεσμάτων ερωτήματος
		$statement->closeCursor();
		// κλείσιμο σύνδεσης με database
		$pdoObject = null;

	   } catch (PDOException $e) {
          $result="false";
	   }
	   
        
        
    }

    // τελος περιπτώσεων αναζητησης ----------
	
			$resaultCar[0]="false"; 			//εστω ότι η αναζητηση δεν βρήκε κανενα διαθεσιμο αυτοκίνητο
			for ($x=1;$x<=$totalcars;$x++){		// ελέγχουμε τη διαθεσιμότητα και αν υπάρχει έστω και ένα κάνουμε αυτή τη συνθήκη true
				if ($resaultCar[$x]=="true")
					$resaultCar[0]="true";
			}

		
        if ($result0=="false"){
            echo '  <div class="forma_field_1"><table>
					<tr><td style="padding: 1em; color:red;">Για κρατήσεις πέραν του ενος μηνά, παρακαλώ επικοινωνηστε.
                    </td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td><a class="forma_field_2" style= "padding: 0 1em; color:black;" href="index.php">Επιστροφή</a>
                    </td></tr>
                    <tr><td>&nbsp;</td></tr></table>';
            }
		elseif(($myResult!=1)||($result=="false")||($resaultCar[0]=="false")){
			echo '  <div class="forma_field_1"><table>
					<tr><td style="padding: 1em; color:red;">Δεν υπάρχει διαθέσιμο αυτοκίνητο.
                    </td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td><a class="forma_field_2" style= "padding: 0 1em; color:black;" href="index.php">Επιστροφή</a>
                    </td></tr>
                    <tr><td>&nbsp;</td></tr></table>';
		}
        else {
            echo '	
					<form name="time_form" method="post" onsubmit="return time_validation();" action="page_select.php">
					  <table class="">
						<tr><td colspan="2"><p>'.$d_start.'/'.$m_start.'/'.$y_start.' μέχρι '.$d_stop.'/'.$m_stop.'/'.$y_stop.'</p></td></tr>
						<tr><td class="forma_field_6">Ώρα παραλαβής</td><td>
												<select class="forma_field_7" name="time_start" id="time_start">
												  <option value="09">9:00</option>
												  <option value="10">10:00</option>
												  <option value="11">11:00</option>
												  <option value="12">12:00</option>
												  <option value="13">13:00</option>
												  <option value="14">14:00</option>
												  <option value="15">15:00</option>
												  <option value="16">16:00</option>
												  <option value="17">17:00</option>
												  <option value="18">18:00</option>
												  <option value="19">19:00</option>
												  <option value="20">20:00</option>
												  <option value="21">21:00</option>
												</select>
											</td></tr>
						<tr><td class="forma_field_6">Ώρα παράδωσης</td><td>
												<select class="forma_field_7" name="time_stop" id="time_stop">
												  <option value="09">9:00</option>
												  <option value="10">10:00</option>
												  <option value="11">11:00</option>
												  <option value="12">12:00</option>
												  <option value="13">13:00</option>
												  <option value="14">14:00</option>
												  <option value="15">15:00</option>
												  <option value="16">16:00</option>
												  <option value="17">17:00</option>
												  <option value="18">18:00</option>
												  <option value="19">19:00</option>
												  <option value="20">20:00</option>
												  <option value="21">21:00</option>
												</select>
											</td></tr>
						<tr><td class="forma_field_6">Σημείο παραλαβής/παράδωσης</td><td>
                                                <select class="forma_field_7" name="spot" id="spot">
												  <option value="air">Αεροδρόμιο</option>
												  <option value="pigadia">Πηγάδια</option>
												</select>
											</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
                        <tr><td colspan="2"><button class="forma_field_2" name="submit" type="submit" value="Συνέχεια">Συνέχεια</button></td></tr>
						<tr><td colspan="2"><?php  echo_msg(); ?></td></tr>
					  </table>';
			
			// αφού έχει γίνει επιτυχής αναζήτηση θέτουμε cookies με τις επιέγμένες ημερομηνίες και ποια ειναι διαθέσιμα αυτοκίνητα
			// 3600 = 60 λεπτά
			
			
			for ($x=1;$x<=$totalcars;$x++){
				$car="car".$x;
				if($resaultCar[$x]=="true")
					setcookie($car, $resaultCar[$x], time() + 3600, '/');
			}
			setcookie("totalcars", $totalcars, time() + 3600, '/');
			setcookie("d_start", $d_start, time() + 3600, '/');
			setcookie("m_start", $m_start, time() + 3600, '/');
			setcookie("y_start", $y_start, time() + 3600, '/');
			setcookie("d_stop", $d_stop, time() + 3600, '/');
			setcookie("m_stop", $m_stop, time() + 3600, '/');
			setcookie("y_stop", $y_stop, time() + 3600, '/');
            setcookie("days_count", $days_count, time() + 3600, '/');
        }
         
?>