<?php
// ΠΡΟΣΘΗΚΗ ΟΧΗΜΑΤΟΣ
//σε αυτή τη λειτουργεία εκταλούνται τα παρακάτω:
//έλεγχος των δεδομέων που έρχονται απο τη φόρμα
//έπειτα καταχωρούνται στον πίνακα των αυτοκινήτων
//και τελος ενημερλωνονται οι πίνακες που είναι διαθέσιμα προς ενοικίαση τα αυτοκινητα
//προστιθοντας το και έκει σαν διαθέσιμη επιλογή


    session_start();
    require('con_authorized.php');
    $type_of=trim($_POST['carclass']);
    $pers=trim($_POST['pers']);
    $doors=trim($_POST['doors']);
    $trans=trim($_POST['trans']);
    $brand=trim($_POST['car_brand']);
    $model=trim($_POST['car_type']);
    $descr=trim($_POST['car_descr']);
    $filename = "images/".$_FILES['upload']['name'];

    // Allow certain file formats
    $filetype = strtolower(pathinfo($_FILES['upload']['name'],PATHINFO_EXTENSION));
    if($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg" && $filetype != "gif" ) 
    {
        header('Location: page_addcar.php?msg=Sorry, only JPG, JPEG, PNG & GIF files are allowed');
        exit();
    }

    // Check file size 500K
    if ($_FILES["upload"]["size"] > 500000) {
        header('Location: page_addcar.php?msg=Sorry, your file is too large');
        exit();
    }

    // Check if file already exists
    if (file_exists($filename)) {
        header('Location: page_addcar.php?msg=Sorry, file already exists');
        exit();
    }

    if (copy($_FILES['upload']['tmp_name'], $filename)) {
        require('db_params.php');
        try {
            $sql='  INSERT INTO cars (type_of, brand, model, pers, doors, trans, img_path, descr)
                    VALUES (:type_of, :brand, :model, :pers, :doors, :trans, :img_path, :descr);';
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');

            $statement = $pdoObject->prepare($sql);
            //αποθηκεύουμε το αποτέλεσμα (true ή false) στη μεταβλητή $myResult
            $myResult= $statement->execute( array(':type_of'=>$type_of,
                                                ':brand'=>$brand,
                                                ':model'=>$model,
                                                ':pers'=>$pers,
                                                ':doors'=>$doors,
                                                ':trans'=>$trans,
                                                ':img_path'=>$filename,
                                                ':descr'=>$descr) );
            // κλείσιμο PDO
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
            try {
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
            $statement->closeCursor();
            $pdoObject = null;
            }
            catch (PDOException $e) {
            // σε περίπτωση που δεν εκτελεστει το query
            header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er112)');
            exit();
            }
        }
        catch (PDOException $e) {
        // σε περίπτωση που δεν εκτελεστει το query
        header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er113)');
        exit();
        }
        header('Location: page_addcar.php?msg=Επιτυχής καταχώρηση');
        exit();
    } else {
        header('Location: page_addcar.php?msg=Could not save file!');
        exit();
    }
    
?>