<?php
        require('part_header.php');
        require('con_authorized.php');
        if($_SESSION['privilege']!='admin'){
            session_destroy();
            header("Location: index.php?msg=Έχετε αποσυνδεθεί!");
            exit();}
		$title = "Προσθήκη";
		echo '<div class="centeritemsg" id="error">';
        echo_msg();
        echo '</div>';
?>
	<main>
    <h2 class="headingmsg">Μήνες τους οποίους διατείθενται προς ενοικίαση τα αυτοκίνητα (προσθήκη ή αφαίρεση)</h2>
    <div class="top">
      <ul class="topmenu" id="topmenu">
        <li class="liopacity" style="opacity: 1;"><a href="page_add.php">Προσθήκη μήνα</a></li>
      </ul>   
    </div>
    <div class="bookpage" id="forma">
    <div>
      <form name="search_books_form" method="GET" action="con_add_month.php">
          <table>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>    
                <td class="forma_field_2" style="width:fit-content;">Μήνας</td>
                <td><select id="month_add" name="month_add" class="forma_field_2">
                    <option value="01">Ιανουάριος</option>
                    <option value="02">Φεβρουάριος</option>
                    <option value="03">Μάρτιος</option>
                    <option value="04">Απρίλιος</option>
                    <option value="05">Μάιος</option>
                    <option value="06">Ιούνιος</option>
                    <option value="07">Ιούλιος</option>
                    <option value="08">Αύγουστος</option>
                    <option value="09">Σεπτέμβριος</option>
                    <option value="10">Οκτώβριος</option>
                    <option value="11">Νοέμβριος</option>
                    <option value="12">Δεκέμβριος</option>
                </select></td>
            </tr>
            <tr>
                <td class="forma_field_2" style="width:fit-content;">Έτος</td>
                <td><select id="year_add" name="year_add" class="forma_field_2">
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>
            <tr><td id="loading" colspan="2">&nbsp;</td></tr>
            <tr><td><button class="forma_field_2" style="color:red;"type="button" onclick="deleteMonthFunction()">Αφαίρεση</button></td><td><input class="forma_field_2" name="submit" type="submit" value="Προσθήκη"></td></tr>
          </table>
        </form>
        </div>
        <div id="book_result" class="results_months">
		<table id="books_table" style="border:1px solid black; height: fit-content;">
		    <tr><th>Έτος</th><th colspan="12">Μήνες</th>
			<?php
			
			try {
				$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
				$pdoObject -> exec('set names utf8');
				$sql='SELECT * FROM months ORDER BY m_year, m_month;';
				$statement = $pdoObject->prepare($sql);
				$statement->execute();
				while ($record = $statement -> fetch()){
					$month = $record['m_year'];
					if ($year_temp!=$record['m_year']){
						echo '</tr><tr><td>'.$month.'</td><td>'.$record['m_month'].'</td>';
						$year_temp=$record['m_year'];
					}
					else
						echo '<td>'.$record['m_month'].'</td>';
				}
			}
				catch (PDOException $e) {
				// σε περίπτωση που δεν εκτελεστει το query
				header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er110)');
				exit();
				}
			
			?>
            </tr>
		  </table>
        </div>
    </div>
    
	</main>
<?php
	require('part_footer.php');
?>