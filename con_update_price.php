<?php
    session_start();
    require('con_authorized.php');
    $id=trim($_GET['id']);
    $price=trim($_GET['price']);
    require('db_params.php');
    try{ 
        $sql = 'UPDATE price SET amount='.$price.' WHERE id_category='.$id.';';
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        $statement = $pdoObject->prepare($sql);
        $statement->execute();

        // κλείσιμο αποτελεσμάτων ερωτήματος
        $statement->closeCursor();
        // κλείσιμο σύνδεσης με database
        $pdoObject = null;
        } catch (PDOException $e) {
          // σε περίπτωση που δεν εκτελεστει το query
          header('Location: page_add.php?msg=Προέκυψε σφάλμα(er0131)');
          exit();
        }
    echo "Done";
?>