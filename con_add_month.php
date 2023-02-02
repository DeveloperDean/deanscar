<?php 
//έχει δυο λειτουργιες, προσθήκη και διαγραφη μηνα
//Προσθέτουμε μήνα με τον εξής τρόπο
//Αρχικά προσθέτουμε πίνακα με τη μορφή cars012022 όπου το 01 αντιστοιχεί στο μήνα και το 2022 στο έτος
//έπειτα από τον πίνακα cars αντλούμε πληροφορίες σχετικά με τα αυτοκίνητα που διαθέτουμε
//και τέλος τα καταχορούμε και αυτά στον πίνακα του μήνα

    session_start();
    require('con_authorized.php');
    $month=trim($_GET['month_add']);
    $year=trim($_GET['year_add']);
    $answere=trim($_GET['answere']);
    if ( ($month<1)||($month>12)||($year<2021)||($year>2030) ){
      header('Location: page_add.php?msg=Προέκυψε σφάλμα(err090)');
      exit();
    }
    $table='cars'.$month.$year;
    if($answere=='yes'){        // διαγραφη μήνα 
        require('db_params.php');
        try{
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            try{
            $sql = 'SELECT * FROM '.$table.';';
            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            while ($record = $statement -> fetch()) {
                $sqlB = 'SELECT car_id FROM cars;';
                
                $statementB = $pdoObject->prepare($sqlB);
                $statementB->execute();
                while ($recordB = $statementB -> fetch()) {
                    $car_id='car'.$recordB['car_id'];
                    $car=$record[$car_id];
                    if (($car!=NULL)&&($car!=1)){
                        header('Location: page_add.php?msg=Προέκυψε σφάλμα(er090b)');
                        exit();
                    }
                }
            }
            }catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: page_add.php?msg=Προέκυψε σφάλμα(er091)');
              exit();
            }
            
            
            $sql = 'DROP TABLE '.$table.';';
            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            
            // κλείσιμο αποτελεσμάτων ερωτήματος
            $statement->closeCursor();
            // κλείσιμο σύνδεσης με database
            $pdoObject = null;
            } catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: page_add.php?msg=Προέκυψε σφάλμα(er091b)');
              exit();
            }
            try{
                $sql = 'DELETE FROM months WHERE m_id=:mhnas;';
                $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                $pdoObject -> exec('set names utf8');
                $statement = $pdoObject->prepare($sql);
                $myResult= $statement->execute( array(':mhnas'=>$table) );
                // κλείσιμο αποτελεσμάτων ερωτήματος
                $statement->closeCursor();
                } catch (PDOException $e) {
                  // σε περίπτωση που δεν εκτελεστει το query
                  header('Location: page_add.php?msg=Προέκυψε σφάλμα(er092)');
                  exit();
                }
            header('Location: page_add.php?msg=Αφαιρέθηκε με επιτυχία.');
    }
    else{                   // προσθήκη μήνα
        $m_now=date("m");   // δε γίνεται να προστεθεί μήνας προγενέστερος
        $y_now=date("Y");
        if ($year<$y_now){
            header('Location: page_add.php?msg=Προέκυψε σφάλμα(er092c)');
            exit();
        }
        if( ($year==$y_now) && ($month<$m_now) ){
            header('Location: page_add.php?msg=Προέκυψε σφάλμα(er092d)');
            exit(); 
        }
        
        
                            
        if ($month=='02') { // February
            if (($year%4)==0) {
                $days = 29;
            } else {
                $days = 28;
            }
        } else if ( ($month == '04') || ($month == '06') || ($month == '09') || ($month == '11') ){
            $days = 30;
        } else {
            $days = 31;
        }

        require('db_params.php');
        try{                                // δημηουργούμε το πίνακα τοποθετόντας τις ημέρες
            $sql = 'CREATE TABLE '.$table.' (
                    days			INT(4)			NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
                    month_di        VARCHAR(50),
                    FOREIGN KEY (month_di) REFERENCES months(m_id) ON DELETE RESTRICT);';
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            // κλείσιμο αποτελεσμάτων ερωτήματος
            $statement->closeCursor();
            for ($i=1;$i<=$days;$i++){
                $sql = 'INSERT INTO '.$table.' (days) VALUES ('.$i.');';
                $statement = $pdoObject->prepare($sql);
                $statement->execute();
                // κλείσιμο αποτελεσμάτων ερωτήματος
                $statement->closeCursor();
            }
            // κλείσιμο σύνδεσης με database
            $pdoObject = null;
            } catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: page_add.php?msg=Προέκυψε σφάλμα(er093)');
              exit();
            }
        
        try{ 
            $sql = 'SELECT * FROM cars;';       // στη συνέχεια τοποθετούμα τα αυτοκίνητα 
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $statement = $pdoObject->prepare($sql);
                $statement->execute();
                while ( $record = $statement -> fetch() ) {
                    $car = 'car'.$record['car_id'];
                    try {
                        $sqlB = 'ALTER TABLE '.$table.' ADD '.$car.' varchar(12);';
                        $pdoObjectB = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                        $pdoObjectB -> exec('set names utf8');
                        $statementB = $pdoObjectB->prepare($sqlB);
                        $statementB->execute();
                        $statementB->closeCursor();
                        $pdoObjectB = null;
                    }
                    catch (PDOException $e) {
                    // σε περίπτωση που δεν εκτελεστει το query
                    header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er94)');
                    exit();
                    }
                }
            } catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: page_add.php?msg=Προέκυψε σφάλμα(er095)');
              exit();
            }
        
        
         try{   
            $sql = 'INSERT INTO months (m_id, m_month, m_year) VALUES (:month_id, :month, :year);';
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $statement = $pdoObject->prepare($sql);
            $statement->execute( array(	':month_id'=>$table,
										':month'=>$month,
										':year'=>$year) );
            // κλείσιμο αποτελεσμάτων ερωτήματος
            $statement->closeCursor();
            } catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: page_add.php?msg=Προέκυψε σφάλμα(er096)');
              exit();
            }
            header('Location: page_add.php?msg=Επιτυχής καταχώρηση');
        }
?>