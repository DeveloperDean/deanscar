<?php 
    session_start();
    require('con_authorized.php');
    $month=$_GET['month'];
    $year=$_GET['year'];
    require('db_params.php');
    $cars="cars".$month.$year;
    try{
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        
        $sql = 'SELECT * FROM cars;';
        echo '<tr><th class="tablehead">Day</th>';
        $statement = $pdoObject->prepare($sql);
        $statement->execute();
        while ($record = $statement -> fetch()) {
            echo '<th class="tablehead">'.$record['car_id'].'.'.$record['model'].'</th>';
		} 
        echo '</tr>';
        $sql = 'SELECT * FROM '.$cars.';';
        $statement = $pdoObject->prepare($sql);
        $statement->execute();
        
        while ($record = $statement -> fetch()) {
            echo '<tr><td style="background-color:#FFFFFF;">'.$record['days'];
            $sqlB = 'SELECT * FROM cars;';
			$statementB = $pdoObject->prepare($sqlB);
			$statementB->execute();
			while ($recordB = $statementB -> fetch()) {
				$j=$recordB['car_id'];
				if (($record['car'.$j]==NULL)||($record['car'.$j]==0))  // το αυτοκίνητο ειναι διαθέσιμο
					echo '</td><td style="background-color:#39603D; width: 5em;">';
				elseif ($record['car'.$j]==1)                           // η κράτηση έχει εκτελσεστεί
                    echo '</td><td style="background-color:blue; width: 5em;">';
                else                                                    // το αυτοκίνητο ειναι δεσμευμένο
					echo '</td><td style="background-color:red;">'.$record['car'.$j];
			}
            echo '</td></tr>';
			$statementB->closeCursor();
			$pdoObjectB = null;
		} 
		//κλείσιμο PDO
		$statement->closeCursor();
		$pdoObject = null;

        }
        catch (PDOException $e) {
            echo '<tr><td style="color:red;" colspan="'.($i+1).'">Δεν υπάρχει διαθεσιμότητα</td></tr>';
        
        }
    
?>