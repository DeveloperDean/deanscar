<?php
	require('part_header.php');
	require('con_authorized.php');
	if($_SESSION['privilege']!='admin'){
        session_destroy();
        header("Location: index.php?msg=Έχετε αποσυνδεθεί!");
        exit();
    }
    echo '<div class="centeritemsg" id="error">';
    echo_msg();
    echo '</div>';

    require('db_params.php');

?>
	<main>
        <h2 class="headingmsg">Διαγραφή ή "κλονοποπίηση" οχημάτων</h2>
        <div class="top">
          <ul class="topmenu" id="topmenu">
            <li class="liopacity" style="opacity: 1;"><a href="page_edit.php">Επεξεργασία οχημάτων</a></li>
            <li class="liopacity" ><a href="page_addcar.php">Προσθήκη οχήματος</a></li>
          </ul>   
        </div>
		<div class="bookpage" id="forma">
            <div>
                <p>Πρίν προβείται στη διαγραφή ενός οχήματος βεβαιωθείται ότι έχετε ελέγξει κρατήσεις που αντιστοιχουν σε αυτό</p>
            </div>
            <div id="book_result" class="results">
			<table id="books_table" style="border:1px solid black; height: fit-content;">
			<tr><th>ID</th>
            <th>Μάρκα</th>
			<th>Μοντέλο</th>
			<th></th>
			<th></th></tr>
			<?php
				$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
				$pdoObject -> exec('set names utf8');
				$sql = 'SELECT * 
						FROM cars
						ORDER BY brand;';
				
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
			?>
			</table>
            </div>
		</div>
	</main>
<?php
	require('part_footer.php');
?>