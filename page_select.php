<?php

    // Επίσης σημαντική σελίδα!
    // Κάποια από τα δεδομένα που δέχεται είναι ποία αυτοκίνητα ειναι διαθέσιμα
    // Υπάρχει ένα προβλημα όμως... δεν θέλουμε να εμφανιστεί ο ίδιος τύπος αυτοκινήτου παραπάνω από μία φορες

	$title = "Επιλογή αυτοκινήτου";
	require('part_header.php');
	require('db_params.php');
	
    if ( !isset($_COOKIE['time_start'])&&!isset($_POST["time_start"]) ){
	  header('Location: index.php?msg=Προέκυψε σφάλμα!(err020)');
	  session_destroy();
      exit();
	}
    if (isset($_POST["time_start"])){
		$time_start=trim($_POST["time_start"]);
		setcookie("time_start", $time_start, time() + 3600, '/');}
    if (!isset($_POST["time_start"]))
        $time_start=$_COOKIE["time_start"];
	
	
    if (isset($_POST["time_stop"])){
		$time_stop=trim($_POST["time_stop"]);
		setcookie("time_stop", $time_stop, time() + 3600, '/');}
    if (!isset($_POST["time_stop"]))
        $time_stop=$_COOKIE["time_stop"];

    
	if (isset($_POST["spot"])){
		$spot=$_POST["spot"];
		setcookie("spot", $spot, time() + 3600, '/');}
    if (!isset($_POST["spot"]))
        $spot=$_COOKIE["spot"];
	
	if ((is_numeric($time_start)!=1)||(is_numeric($time_stop)!=1)){
	  header('Location: index.php?msg=Προέκυψε σφάλμα(err021)');
	  session_destroy();
      exit();
	}
	
	$d_start=$_COOKIE["d_start"];
	$m_start=$_COOKIE["m_start"];
	$y_start=$_COOKIE["y_start"];
	$d_stop=$_COOKIE["d_stop"];
	$m_stop=$_COOKIE["m_stop"];
	$y_stop=$_COOKIE["y_stop"];
    $totalcars=$_COOKIE["totalcars"];   // η τιμή ειναι "ψεύτικη", διότι κάποια αυτοκίνητα 
                                        // στο ενδιάμεσω να έχουν αφαιρεθει
	$car = array();
	for ($i=1;$i<=$totalcars;$i++){    //
		$car0="car".$i;
		if (isset($_COOKIE[$car0]))
			$car[$i]=$_COOKIE[$car0];
		else
			$car[$i]="false";
	}


    $days_count=$_COOKIE["days_count"];
	if ($time_stop=="09")		//εάν η ώρα επιστρφής είναι 09:00 δεν χρεώνεται η τελευταία ημέρα
		$days_count--;
    // Θέτουμε την ημερήσια χρέωση


    // λήψη τιμων απο βδ
    $preday = array();
    $amount = array();
    try {
		$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
		$pdoObject -> exec('set names utf8');
		$sql='SELECT * FROM price;';
		$statement = $pdoObject->prepare($sql);
		$statement->execute();
        while ($record = $statement -> fetch()) {
            $i = $record['id_category'];        // αναζητούμε την τιμή ανά ημερα
            $preday[$i] = $record['amount'];  	// και την θέτουμς στη μεταβλητη preday
        }
        $statement->closeCursor();
        $pdoObject = null;
    }
	catch (PDOException $e) {
	// σε περίπτωση που δεν εκτελεστει το query
	header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er023)');
	exit();
	}

    // εφαρμόζουμε τις εκπτώσεις
    if ($days_count<=3){
        $discount=1;
    }
    elseif($days_count<=5){
        $discount=0.95;
    }
    elseif($days_count<=7){
        $discount=0.9;
    }
    elseif($days_count<=10){
        $discount=0.85;
    }
    else{
        $discount=0.8;
    }
    for ($i=1;$i<=2;$i++){
        $amount[$i]=$preday[$i]*$days_count*$discount;
        $perday[$i]=$amount[$i]/$days_count;
    }
    

	if($spot=="air")
		$x="αεροδρόμιο";
	elseif($spot=="pigadia")
		$x="Πηγάδια";
	else{
	  header('Location: index.php?msg=Προέκυψε σφάλμα(err022)');
	  session_destroy();
      exit();
	}
		
	echo '<main id="container"><div class="dates_select"><p style="text-align: center; font-weight: bold;">Παραλαβή την '.$d_start.'-'.$m_start.'-'.$y_start.' και ώρα  '.$time_start.':00 από '.$x.' και παραδοση την '.$d_stop.'-'.$m_stop.'-'.$y_stop.' και ώρα '.$time_stop.':00</p></div>';
    $i=1;
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject -> exec('set names utf8');
    $sql = 'SELECT * FROM cars ORDER BY brand, type_of;';

    $statement = $pdoObject->prepare($sql);
    $statement->execute();

    while ($record = $statement -> fetch()) {
        $i = $record['car_id'];
        if ($car[$i]=='true'){	
            $img_path = $record['img_path'];
            $brand = $record['brand'];
            $model = $record['model'];
			$pers = $record['pers'];
            $doors = $record['doors'];
            $trans = $record['trans'];
            if($trans=='auto')
                $trans='Αυτόματο';
            else
                $trans='Χειροκίνητο';
			$type = $record['type_of'];
            if(($brand!=$temp_brand)&&($model!=$temp_model)){			// ελέγχουμε εαν το μοντέλο του αυτοκίνητου εχει εμφανιστεί ήδη
                echo '
                        <div class="select">
                            <div class="selectL">
                              <img src="'.$img_path.'" width="100%" height="100%"/>
                            </div>
                            <div class="selectR">
                              <p>'.$brand.' '.$model.'</p><p>Λεπτομέρειες οχήματος : <br>&#128101; x '.$pers.'<br>'.$type.'ης κατηγορίας<br>Θύρες '.$doors.'<br>'.$trans.'</p><p> '.$perday[$type].'&euro; / ημέρα, συνολικό ποσό '.$amount[$type].'&euro;</p>
                              <button class="forma_field_2" onclick="select('.$i.')">Επιλογή</button>
                            </div>
                        </div>';
				$temp_brand = $brand;
                $temp_model = $model;	// αποθηκευουμε ποια αυτοκινητα εχουν εμφανιστεί
                                        // για να μην αμφανιστεί το ίδιο αυτοκίνητο παραπάνω
				                        // απο μία φορες
				// τοποθετω στο session τα χαρακτηριστικα της κάθε επιλογης
                $_SESSION['amount'][$i]=$amount[$type];
                $_SESSION['car'][$i]=$i;
                $_SESSION['img_path'][$i]=$img_path;
            }
        }
    }
	
	echo '</main>';
	require('part_footer.php');
?>