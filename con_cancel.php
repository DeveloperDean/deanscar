<?php 
  session_start();
  require('db_params.php');
  $answere=trim($_GET['answere']);

  if ( (!isset($_SESSION['booking_no_del'])) || ( !isset($_SESSION['booking_no_del']) ) || ( !isset($_SESSION['booking_no_del']) ) ){
      $myResult=false;
  }
  else{
      
      //  ---------------- bookings ----------------
      
      $booking_no=$_SESSION['booking_no_del'];
      $lname=$_SESSION['lname_del'];
      $fname=$_SESSION['fname_del'];
      $car_id=$_SESSION['car_id_del'];
      $date_start=$_SESSION['date_start_del'];
      $date_arr = explode("-", $date_start);
      $d_start = $date_arr[0];
      $m_start = $date_arr[1];
      $y_start = $date_arr[2];
      $date_stop=$_SESSION['date_stop_del'];
      $date_arr = explode("-", $date_stop);
	  $d_stop = $date_arr[0];
	  $m_stop = $date_arr[1];
	  $y_stop = $date_arr[2];
      $start_d = "cars".$m_start.$y_start;
      $stop_d = "cars".$m_stop.$y_stop;
      $car = "car".$car_id;
      
      try{  //----------------- ακύρωση κρατησης bookings ------------------------
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');

            $sql = 'UPDATE bookings
                    SET status="CANCELED"
                    WHERE booking_no=:booking_no AND lname=:lname AND fname=:fname;';
            $statement = $pdoObject->prepare($sql);
            $myResult= $statement->execute( array(  ':booking_no'=>$booking_no,
                                                    ':lname'=>$lname,
                                                    ':fname'=>$fname)  );

            // κλείσιμο αποτελεσμάτων ερωτήματος
            $statement->closeCursor();
            // κλείσιμο σύνδεσης με database
            $pdoObject = null;

           } catch (PDOException $e) {
             //σε φάση ανάπτυξης, τυπώνουμε το πρόβλημα
             echo 'PDO Exception: '.$e->getMessage();
             //σε φάση λειτουργίας καλύτερα να τυπώσουμε κάτι λιγότερο τεχνικό
           }
      
      
      
      //   ----------------- αποδεσμευση αυτοκινητου cars##**** ------------------------
      
      try{
          
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        if ($m_start!=$m_stop){

            $sqlA = 'UPDATE '.$start_d.'
                        SET '.$car.'=NULL
                        WHERE '.$car.'=:booking_no;';
            
            $statement = $pdoObject->prepare($sqlA);
            $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
            
            $sqlB = 'UPDATE '.$stop_d.'
                        SET '.$car.'=NULL
                        WHERE '.$car.'=:booking_no;';
            
            $statement = $pdoObject->prepare($sqlB);
            $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
        }        
        else {
            $sql = 'UPDATE '.$start_d.'
                        SET '.$car.'=NULL
                        WHERE '.$car.'=:booking_no;';
            
            $statement = $pdoObject->prepare($sql);
            $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
        }
        
        // κλείσιμο αποτελεσμάτων ερωτήματος
        $statement->closeCursor();
        // κλείσιμο σύνδεσης με database
        $pdoObject = null;

       } catch (PDOException $e) {
        
        $myResult="false";
       }
}






if (($answere=='yes')&&($myResult=='true')){
    unset($_SESSION['booking_no_del']);
    unset($_SESSION['lname_del']);
    unset($_SESSION['fname_del']);
    unset($_SESSION['car_id_del']);
    unset($_SESSION['date_start_del']);
    header('Location: index.php?msg=Η κράτηση σας ακυρώθηκε');
    exit();
  }
  else{
    session_destroy();
    header('Location: index.php?msg=Προέκυψε σφάλμα(err070)');
    exit();
  }
?>