<?php
//Η πιο σημαντική σελίδα!!!
//Κάνει 5 λειτουγρίες:
//Σε περίπτωση νέας κράτησης :  1. Καταχωρεί την κράτηση στον πινακα bookings 
//                              2. Δεσμεύει το αυτοκίνητο στον (στους) αντιστιχο πίνακα
//Σε περπιπτωση αλλαγής :       3. Αποδεσμέυει τον (τους) πίνακες τη παλιάς κράτησης
//                              4. Δεσμεύει το αυτοκίνητο στον (στους) αντιστιχο πίνακα
//                              5. Ενημερώνει την κράτηση στον πινακα bookings

    session_start();
    $amount=$_SESSION['amount']['0'];
    $car=$_SESSION['car']['0'];
    // με αυτη τη συνθήκη δε μπορει να εχει προσβαση κάποιος στη σελίδα απευθείας παρα μόνο απο την ajax_select.php
    if((!isset($_SESSION['amount']['0']))||(!isset($_SESSION['car']['0']))){
        header('Location: index.php?msg=Προέκυψε σφάλμα(er041)');
		session_destroy();
		exit();
        }

    $temp=trim($_POST['lname']);
	$lname=strtoupper($temp);
    $temp=trim($_POST['fname']);
	$fname=strtoupper($temp);
    $email=trim($_POST['email']);
    $tel=trim($_POST['tel']);

    // έλεγχος των μεταβλητων που έρχονται απο POST
    if( (strlen($lname)<3)||(strlen($fname)<3)||(strlen($lname)>50)||(strlen($fname)>50)||(strlen($tel)<7)||(strlen($tel)>15) ){
        header('Location: index.php?msg=Προέκυψε σφάλμα(er042)');
	    session_destroy();
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?msg=Προέκυψε σφάλμα(er043)');
		session_destroy();
        exit();
    }
    
    $d_start=$_COOKIE["d_start"];
	$m_start=$_COOKIE["m_start"];
	$y_start=$_COOKIE["y_start"];
    $date_start=$d_start.'-'.$m_start.'-'.$y_start;
        
	$d_stop=$_COOKIE["d_stop"];
	$m_stop=$_COOKIE["m_stop"];
	$y_stop=$_COOKIE["y_stop"];
    $date_stop=$d_stop.'-'.$m_stop.'-'.$y_stop;

    $days_count = $_COOKIE["days_count"];

    //υπολογισμός των ημερών και δημιουργία μετβλητης για ταξινομηση βάση ημερομηνίας
    $days_order = date ('z', mktime(0,0,0,$m_start,$d_start,$y_start))+1;
    // και της δίνουμε τη μορφό πχ 202296 για την ημερομηνία 06/04/2022
    $days_order = $y_start.$days_order;


    $start_d = "cars".$m_start.$y_start;
    $stop_d = "cars".$m_stop.$y_stop;

    $time_start=$_COOKIE["time_start"];
    $time_stop=$_COOKIE["time_stop"];
    $spot=$_COOKIE["spot"];
	$totalcars=$_COOKIE["totalcars"];

    $booking_no=random_int(100000, 999999);

    require('db_params.php');

    if($time_stop==9){  //εφόσων η επιστροφή γίνεται 9 η ωρα, δεν πρεπει να δεσμευτεί
        if($d_stop==1){ //η τελευτεαία μέρα στη ΒΔ
            $d_stop=31;
            $m_stop=$m_start;
        }
        else{
            $d_stop--;
        }
		$days_count--;
    }

    
    if (!isset($_SESSION['booking_no_del'])) {  // --------    Αρχική κράτηση     ----------
    
        try{                                    // 2. Δεσμεύει το αυτοκίνητο στον (στους) αντιστιχο πίνακα
            if ($m_start!=$m_stop){

                $sqlA[0] = 'SELECT car'.$car.' FROM '.$start_d.' WHERE days>='.$d_start.';';		//πρεπει να τσεκαρουμε οτί όντως δεν ειναι δεσμευμένο το αυτοκίνητο
                $sqlA[1] = 'SELECT car'.$car.' FROM '.$stop_d.' WHERE days<='.$d_stop.';';			//για να αποφύγουμε την περίπτωση να γίνουν δύο κρατησεις ταυτοχρονα
				for ($i=0;$i<2;$i++){
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject -> exec('set names utf8');
                    $sql = $sqlA[$i];

                    $statement = $pdoObject->prepare($sql);
                    $statement->execute();
					while ( $record = $statement -> fetch() ) {
						$booked = $record['car'.$car];
						if ($booked!=0){
							for ($x=1;$x<=$totalcars;$x++){
								$car="car".$x;
								setcookie($car, "", time() - 3600, '/');
							}
							setcookie("totalcars", "", time() - 3600, '/');
							header('Location: index.php?msg=Προέκυψε σφάλμα(er047a)');				// διαγράφουμε και τα cookies!!
							session_destroy();
							exit();
						}
					}
                }


                $sqlA[0] = 'UPDATE '.$start_d.' SET car'.$car.'='.$booking_no.' WHERE days>='.$d_start.';';
                $sqlA[1] = 'UPDATE '.$stop_d.' SET car'.$car.'='.$booking_no.' WHERE days<='.$d_stop.';';
                for ($i=0;$i<2;$i++){
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject -> exec('set names utf8');
                    $sql = $sqlA[$i];

                    $statement = $pdoObject->prepare($sql);
                    $statement->execute();
                    // κλείσιμο αποτελεσμάτων ερωτήματος
                    $statement->closeCursor();
                    // κλείσιμο σύνδεσης με database
                    $pdoObject = null;
                }
            }
            else {
				
				$sql= 'SELECT car'.$car.' FROM '.$start_d.' WHERE days>='.$d_start.' AND days<='.$d_stop.';';	//πρεπει να τσεκαρουμε οτί όντως δεν ειναι δεσμευμένο το αυτοκίνητο
				$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);					//για να αποφύγουμε την περίπτωση να γίνουν δύο κρατησεις ταυτοχρονα	
				$pdoObject -> exec('set names utf8');
				$statement = $pdoObject->prepare($sql);
				$statement->execute();
				while ( $record = $statement -> fetch() ) {
					$booked = $record['car'.$car];
					if ($booked!=0){
						for ($x=1;$x<=$totalcars;$x++){
								$car="car".$x;
								setcookie($car, "", time() - 3600, '/');									// διαγράφουμε και τα cookies!!
							}
							setcookie("totalcars", "", time() - 3600, '/');
						header('Location: index.php?msg=Προέκυψε σφάλμα(er047b)');
						session_destroy();
						exit();
					}
				}
                

                $sql= 'UPDATE '.$start_d.' SET car'.$car.'='.$booking_no.' WHERE days>='.$d_start.' AND days<='.$d_stop.';';

                $statement = $pdoObject->prepare($sql);
                $statement->execute();
                // κλείσιμο αποτελεσμάτων ερωτήματος
                $statement->closeCursor();
                // κλείσιμο σύνδεσης με database
                $pdoObject = null;
            }

           } catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: index.php?msg=Προέκυψε σφάλμα(er044a)');
              session_destroy();
              exit();
           }
        try {                                           // 1. Καταχωρεί την κράτηση στον πινακα bookings
            
            $sql='INSERT INTO bookings (car_id, booking_no, lname, fname, email, tel, date_start, date_stop, time_start, time_stop, spot, amount, days_count, days_order)
                                        VALUES (:car, :booking_no, :lname, :fname, :email, :tel, :date_start, :date_stop, :time_start, :time_stop, :spot, :amount, :days_count, :days_order);';
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');

            $statement = $pdoObject->prepare($sql);
            //αποθηκεύουμε το αποτέλεσμα (true ή false) στη μεταβλητή $myResult
            $myResult= $statement->execute( array(':car'=>$car,
                                                ':booking_no'=>$booking_no,
                                                ':lname'=>$lname,
                                                ':fname'=>$fname,
                                                ':email'=>$email,
                                                ':tel'=>$tel,
                                                ':date_start'=>$date_start,
                                                ':date_stop'=>$date_stop,
                                                ':time_start'=>$time_start,
                                                ':time_stop'=>$time_stop,
                                                ':spot'=>$spot,
                                                ':amount'=>$amount,
                                                ':days_count'=>$days_count,
                                                ':days_order'=>$days_order) );
            // κλείσιμο PDO
            $statement->closeCursor();
            $pdoObject = null;
    
        }
        catch (PDOException $e) {
        // σε περίπτωση που δεν εκτελεστει το query
        header('Location: index.php?msg=Προέκυψε σφάλμα(er044a)'.$car);
        session_destroy();
        exit();
        }
    }
    else {      // ------------------   περίπτωση αλλαγής κράτησης   ----------------------
        
        $booking_no=$_SESSION['booking_no_del'];
        $car_id_ch=$_SESSION['car_id_del'];
        $date_start_ch=$_SESSION['date_start_del'];
        $date_arr = explode("-", $date_start_ch);
        $d_start_ch = $date_arr[0];
        $m_start_ch = $date_arr[1];
        $y_start_ch = $date_arr[2];
        $date_stop_ch=$_SESSION['date_stop_del'];
        $date_arr = explode("-", $date_stop_ch);
        $d_stop_ch = $date_arr[0];
        $m_stop_ch = $date_arr[1];
        $y_stop_ch = $date_arr[2];
        $start_d_ch = "cars".$m_start_ch.$y_start_ch;
        $stop_d_ch = "cars".$m_stop_ch.$y_stop_ch;
        $car_ch = "car".$car_id_ch;
        
        
        try{                                     // 3. Αποδεσμέυει τον (τους) πίνακες τη παλιάς κράτησης
          
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            if ($m_start_ch!=$m_stop_ch){

                $sqlA = 'UPDATE '.$start_d_ch.'
                            SET '.$car_ch.'=NULL
                            WHERE '.$car_ch.'=:booking_no;';

                $statement = $pdoObject->prepare($sqlA);
                $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );

                $sqlB = 'UPDATE '.$stop_d_ch.'
                            SET '.$car_ch.'=NULL
                            WHERE '.$car_ch.'=:booking_no;';

                $statement = $pdoObject->prepare($sqlB);
                $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
            }        
            else {
                $sql = 'UPDATE '.$start_d_ch.'
                            SET '.$car_ch.'=NULL
                            WHERE '.$car_ch.'=:booking_no;';

                $statement = $pdoObject->prepare($sql);
                $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
            }

            // κλείσιμο αποτελεσμάτων ερωτήματος
            $statement->closeCursor();
            // κλείσιμο σύνδεσης με database
            $pdoObject = null;

           } catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: index.php?msg=Προέκυψε σφάλμα(er045a)');
              session_destroy();
              exit();   
           }
        
        
          try{                                    // 4. Δεσμεύει το αυτοκίνητο στον (στους) αντιστιχο πίνακα
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
			if ($m_start==$m_stop){
                $sql= 'UPDATE '.$start_d.' SET car'.$car.'='.$booking_no.' WHERE days>='.$d_start.' AND days<='.$d_stop.';';

                $statement = $pdoObject->prepare($sql);
                $statement->execute();
                
            }
            else {

                $sqlA = 'UPDATE '.$start_d.' SET car'.$car.'=:booking_no WHERE days>=:d_start ;';
                $statement = $pdoObject->prepare($sqlA);
				$statement->execute( array( ':booking_no'=>$booking_no,	':d_start'=>$d_start) );
				
				$sqlB = 'UPDATE '.$stop_d.' SET car'.$car.'=:booking_no WHERE days<=:d_stop ;';
                $statement = $pdoObject->prepare($sqlB);
				$statement->execute( array( ':booking_no'=>$booking_no, ':d_stop'=>$d_stop	) );
            }
			// κλείσιμο αποτελεσμάτων ερωτήματος
                $statement->closeCursor();
                // κλείσιμο σύνδεσης με database
                $pdoObject = null;
           } catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: index.php?msg=Προέκυψε σφάλμα(er045b)');
              session_destroy();
              exit();
           }
        
        
        
        
        
            try {                                       //  5. Ενημερώνει την κράτηση στον πινακα bookings
                $sql='  UPDATE bookings 
                        SET car_id=:car, lname=:lname, fname=:fname, email=:email, tel=:tel, date_start=:date_start, date_stop=:date_stop, time_start=:time_start, time_stop=:time_stop, spot=:spot, amount=:amount, days_count=:days_count, days_order=:days_order 
                        WHERE booking_no=:booking_no;';
                $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                $pdoObject -> exec('set names utf8');

                $statement = $pdoObject->prepare($sql);
                //αποθηκεύουμε το αποτέλεσμα (true ή false) στη μεταβλητή $myResult
                $myResult= $statement->execute( array(':car'=>$car,
                                                ':lname'=>$lname,
                                                ':fname'=>$fname,
                                                ':email'=>$email,
                                                ':tel'=>$tel,
                                                ':date_start'=>$date_start,
                                                ':date_stop'=>$date_stop,
                                                ':time_start'=>$time_start,
                                                ':time_stop'=>$time_stop,
                                                ':spot'=>$spot,
                                                ':amount'=>$amount,
                                                ':days_count'=>$days_count,
                                                ':days_order'=>$days_order,
                                                ':booking_no'=>$booking_no) );
                // κλείσιμο PDO
                $statement->closeCursor();
                $pdoObject = null;
                }
                catch (PDOException $e) {
                // σε περίπτωση που δεν εκτελεστει το query
                header('Location: index.php?msg=Προέκυψε σφάλμα(er045c)');
                session_destroy();
                exit();
                }

    }
	
  if ( !$myResult ) {  //αν  $myResult ήταν false....
    header('Location: index.php?msg=Προέκυψε σφάλμα(er046)');
    exit();
  } else {   //αν  $myResult ήταν true....
  
		for ($x=1;$x<=$totalcars;$x++){
			$car="car".$x;
			setcookie($car, "", time() - 3600, '/');
		}		
        setcookie("d_start", "", time() - 3600, '/');
        setcookie("m_start", "", time() - 3600, '/');
        setcookie("y_start", "", time() - 3600, '/');	    // αφου ολοκληρωθει η διαδικασια επιτυχως
        setcookie("d_stop", "", time() - 3600, '/');       	// διαγραφονται τα cookies 
        setcookie("m_stop", "", time() - 3600, '/');
        setcookie("y_stop", "", time() - 3600, '/');
        setcookie("days_count", "", time() - 3600, '/');
		setcookie("time_start", "", time() - 3600, '/');
		setcookie("time_stop", "", time() - 3600, '/');
		setcookie("spot", "", time() - 3600, '/');
		setcookie("totalcars", "", time() - 3600, '/');
		
		if (isset($_SESSION['username']))
			$username=$_SESSION['username'];				// εαν η αλλαγή έγινε απο τον admin
															// πρεπει να κρατησουμε το username 
		session_destroy();									// διοτι αλλιώς θα γίνει logout
		session_start();
		$_SESSION['username']=$username;
		$_SESSION['$booking_no']=$booking_no;
        header('Location: receip.php?msg=Επιτυχής καταχώρηση!');
        exit();
  }
?>