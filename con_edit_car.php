<?php 

	// εχει δύο λειτουργιες
	//	διαγραφή 
	//	αντιγραφη (κλονοποίηση)


    session_start();
    require('con_authorized.php');
	if($_SESSION['privilege']!='admin'){
        session_destroy();
        header("Location: index.php?msg=Έχετε αποσυνδεθεί!");
        exit();
    }
    $car_id=trim($_GET['car_id']);
    $purpose=trim($_GET['purpose']);
	
	// Περίπτωση διαγραφής αυτοκινήτου
	
    if (is_numeric($car_id)&&($car_id<9999)&&($car_id>0)&&($purpose=='delete')){
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        
        // πρώτα πρέπει να ελέγξουμε εάν στο αυτοκίνητο υπάρχει κράτηση
        $car='car'.$car_id;
        try{
            $sql = 'SELECT * FROM months;';
            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            while ($record = $statement -> fetch()) {
                $month=$record['m_id'];
                $sqlB = 'SELECT '.$car.' FROM '.$month.';';
                
                $statementB = $pdoObject->prepare($sqlB);
                $statementB->execute();
                while ($recordB = $statementB -> fetch()) {
                    $isbook=$recordB[$car];
                    if (($isbook!=NULL)&&($isbook!=1)){       // υπάρχει ενεργή κράτηση στο αυτοκίνητο
                        echo '<td colspan = "5">ελέξτε τις κρατήσεις</td>';
                        exit();
                    }
                }
            }
            }catch (PDOException $e) {
              // σε περίπτωση που δεν εκτελεστει το query
              header('Location: page_add.php?msg=Προέκυψε σφάλμα(er091)');
              exit();
            }
        
        $sql = 'DELETE FROM cars WHERE car_id='.$car_id.';';
        $statement = $pdoObject->prepare($sql);
        $statement->execute();
        
        $column='car'.$car_id;
        $sql = 'SELECT m_id FROM months;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute();
        while ( $record = $statement -> fetch() ) {
            $table = $record['m_id'];
            //εισαγωγή στους πίνακες απο του μήνες το νέο αυτοκίνητο
                try {
                    $sqlB = 'ALTER TABLE '.$table.' DROP COLUMN '.$column.';';
                    $pdoObjectB = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObjectB -> exec('set names utf8');
                    $statementB = $pdoObjectB->prepare($sqlB);
                    $statementB->execute();
                    $statementB->closeCursor();
                    $pdoObjectB = null;
                }
                catch (PDOException $e) {
                // σε περίπτωση που δεν εκτελεστει το query
                echo 'Προέκυψε σφάλμα(er120)';
                exit();
                }
            }
        echo '';
        $statement->closeCursor();
        $pdoObject = null;
    }										// Περίπτωση αντιγραφης αυτοκινήτου
    elseif(is_numeric($car_id)&&($car_id<9999)&&($car_id>0)&&($purpose=='duplicate')){
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        $sql = 'INSERT INTO cars (type_of, brand, model, pers, doors, trans, img_path, descr)
                SELECT type_of, brand, model, pers, doors, trans,img_path, descr  
                FROM cars
                WHERE car_id = '.$car_id.';';
        $statement = $pdoObject->prepare($sql);
        $statement->execute();
        
        try {
                $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                $pdoObject -> exec('set names utf8');
                $sql='SELECT MAX(car_id) from cars;';
                $statement = $pdoObject->prepare($sql);
                $statement->execute();
                while ( $record = $statement -> fetch() ) {
                    $column = 'car'.$record['MAX(car_id)'];
                }
            }
            catch (PDOException $e) {
            // σε περίπτωση που δεν εκτελεστει το query
            header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er110)');
            exit();
            }
            
         
            
            $statement->closeCursor();
            $pdoObject = null;
            
            $sql = 'SELECT * FROM months;';
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            while ( $record = $statement -> fetch() ) {
                $table = $record['m_id'];
                //εισαγωγή στους πίνακες απο του μήνες το νέο αυτοκίνητο
                    try {
                        $sqlB = 'ALTER TABLE '.$table.' ADD '.$column.' varchar(12);';
                        $pdoObjectB = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                        $pdoObjectB -> exec('set names utf8');
                        $statementB = $pdoObjectB->prepare($sqlB);
                        $statementB->execute();
                        $statementB->closeCursor();
                        $pdoObjectB = null;
                    }
                    catch (PDOException $e) {
                    // σε περίπτωση που δεν εκτελεστει το query
                    header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er111)');
                    exit();
                    }
                }
				
         echo ' <tr><th>ID</th>
                <th>Μάρκα</th>
                <th>Μοντέλο</th>
                <th></th>
                <th></th></tr>';
        
        $sql = 'SELECT * FROM cars ORDER BY brand;';

        $statement = $pdoObject->prepare($sql);
        $statement->execute();

        while ($record = $statement -> fetch()) {
            echo '<tr id="'.$record['car_id'].'"><td>'.$record['car_id'];
            echo '</td><td>'.$record['brand'];
            echo '</td><td>'.$record['model'];
            echo '</td><td><a title="Προσθήκη" onclick="edit_add_car('.$record['car_id'].')"><img src="images/plus.png"/></a>';
			echo '</td><td><a title="Διαγραφή" onclick="edit_delete_car('.$record['car_id'].')"><img src="images/delete.png"/></a></td></tr>';
        }
        $statement->closeCursor();
        $pdoObject = null;
    }
    else{
        session_destroy();
        header("Location: index.php?msg=Προέκυψε σφάλμα(er120)");
        exit();
    }
?>