<?php
  if (!isset($_SESSION['username'])) {
     header("Location: index.php?msg=Έχετε%20αποσυνδεθεί!");
     exit();
  }   
  require('db_params.php');
  try{
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        
        $sql = 'SELECT privilege 
                FROM users WHERE username=:username;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute( array(':username'=>$_SESSION['username']) );
        if ($record = $statement -> fetch()) {
			$_SESSION['privilege']=$record['privilege'];
		}
		//κλείσιμο PDO
		$statement->closeCursor();
		$pdoObject = null;
        }
        catch (PDOException $e) {
            echo 'Έχετε αποσυνδεθεί!E';
        
        }
 ?>