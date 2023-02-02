<?php 
    session_start();
    $username=trim($_POST['login_un']);
    $password=trim($_POST["login_pw"]);
    if( (strlen($username)<7)||(strlen($password)<7)||(strlen($username)>50)||(strlen($password)>50) )
      {
        header('Location: index.php?msg=Προέκυψε σφάλμα(er080)');
	    session_destroy();
        exit();
    }
    require('db_params.php');

    try{
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        $sql = 'SELECT * 
                FROM users 
                WHERE username=:username;';
        
        $statement = $pdoObject->prepare($sql);
        $statement->execute( array(':username'=>$username) );
        
        if ($record = $statement -> fetch()) { //εφόσον βρέθηκε η εγγραφή
			$passwordDB=$record['password'];
            $lname=$record['lname'];
            $fname=$record['fname'];
            $privilege=$record['privilege'];
            if ($passwordDB==$password)
                $record_exists=true;
		} else $record_exists=false;  //σημειώνουμε ότι δεν βρέθηκε
	  
		//κλείσιμο PDO
		$statement->closeCursor();
		$pdoObject = null;
        }
        catch (PDOException $e) {
            $record_exists=false;
        
        }


    if ($record_exists=='true'){
        $_SESSION['username']=$username;
        $_SESSION['lname']=$lname;
        $_SESSION['fname']=$fname;
        $_SESSION['privilege']=$privilege;
        header('Location: page_user.php');
        exit();
    }
    else {
        header('Location: page_login.php?msg=Αποτυχιμένη σύνδεση!');
        session_destroy();
        exit();
    }








?>