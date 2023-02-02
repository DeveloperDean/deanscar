<?php 
    session_start();
    require('con_authorized.php');
    $selection=$_GET['selection'];
    $order=$_GET['order'];
    $checkbox=$_GET['checkbox']; // για να εμφανιστουν όλες οι κρατησεις ή μονο οι ενεργες
    $input_text=$_GET['input_text'];
    $i=(10*$selection);
    require('db_params.php');
    try{
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        if (is_numeric($input_text))
            $sql = 'SELECT *  FROM bookings WHERE booking_no='.$input_text.';';
        else{
            if ($checkbox=="show")
                $sql = 'SELECT *  FROM bookings ORDER BY '.$order.' LIMIT '.$i.',10;';
            else
                $sql = 'SELECT *  FROM bookings WHERE status="0" ORDER BY '.$order.' LIMIT '.$i.',10;';
        }
            
            
        
        $statement = $pdoObject->prepare($sql);
        $statement->execute();
        echo '  <table id="books_table"style="border:1px solid black;">
                <tr><th>Κωδικός</th>
				<th>Αυτοκίνητο</th>
                <th>Επώνυμο</th>
                <th>Όνομα</th>
                <th>e-mail</th>
                <th>Τηλέφωνο</th>
                <th>Ποσό</th>
                <th>Παραλαβής</th>
                <th>Επιστροφή</th>
                <th></th></tr>';

        
        while ($record = $statement -> fetch()) {
            echo '<tr><td>'.$record['booking_no'];
			
			$car_id=$record['car_id'];
			$sqlB='SELECT * FROM cars WHERE car_id='.$car_id.';';
			$statementB = $pdoObject->prepare($sqlB);
			$statementB->execute();
			if ( $recordB = $statementB -> fetch() ) {
				$model = $recordB['model'];
			}
			
			echo '</td><td>'.$model.'#'.$car_id;
			
            echo '</td><td>'.$record['lname'];
            echo '</td><td>'.$record['fname'];
            echo '</td><td><a title = "Αποστολή e-mail" href = "mailto: '.$record['email'].'">'.$record['email'];
            echo '</a></td><td><a title = "Κλήση" href="tel:'.$record['tel'].'">'.$record['tel'];
            echo '</a></td><td>'.$record['amount'];
            echo '&euro;</td><td>'.$record['date_start'];
            echo '</td><td>'.$record['date_stop'];
                if ($record['status']=='CANCELED')
                    echo '</td><td><img src="images/canceled.png" title="Ακυρώθηκε"/></td></tr>';
                elseif($record['status']=='DONE')
                    echo '</td><td><img src="images/done.png" title="Εκλεισε"/></td></tr>';
                else
                    echo '</td><td>
                    <a title="Επεξεργασία" href="page_changes.php?lname='.$record['lname'].'&code='.$record['booking_no'].'"><img src="images/edit.png"/></a>
                    <a title="Τιμολόγιση" href="page_print_order.php?lname='.$record['lname'].'&code='.$record['booking_no'].'&datestart='.$record['date_start'].'&datestop='.$record['date_stop'].'&car_id='.$car_id.'"><img src="images/print_order.png"/></a>
                    </td></tr>';
		}
        echo '</table>';
		//κλείσιμο PDO
		$statement->closeCursor();
		$pdoObject = null;
        }
        catch (PDOException $e) {
            echo 'false query';
        
        }
    
?>