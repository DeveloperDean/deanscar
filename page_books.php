<?php
        require('part_header.php');
		$title = "Διαχείρηση ρατήσεων";
		require('con_authorized.php');
        require('db_params.php');
        try{
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $sql = 'SELECT * 
                    FROM bookings;';
        
            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            $i=0;
            while ($record = $statement -> fetch()) {
             $i++;
		    }
            //κλείσιμο PDO
            $statement->closeCursor();
            $pdoObject = null;
            }
            catch (PDOException $e) {
                echo 'false query';

            }
?>
	<main>
        <h2 class="headingmsg">Εμφάνηση κρατήσεων και ακύρωση / τροποποίηση / διευθέτηση αυτών</h2>
        <div class="top">
          <ul class="topmenu" id="topmenu">
            <li class="liopacity"><a href="page_available.php">Διαθεσιμότητα οχημάτων</a></li>
            <li class="liopacity" style="opacity: 1;"><a href="page_books.php">Διαχείρηση κρατήσεων</a></li>
          </ul>   
    </div>
    <div class="bookpage" id="forma">
      <div>
      <form name="search_books_form" method="post">
          <table class="">
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>
                <td class="forma_field_2">Ταξινόμιση </td>
                <td><select id="order" class="forma_field_2" onchange="return books_admin();">
                <option value="days_order">Ημερομηνία</option>
                <option value="lname">Επώνυμο</option>
                <option value="booking_no">Κωδικό</option>
                </select></td>
            </tr>
            <tr>
                <td class="forma_field_2">Αποτελέσματα </td>
                <td><select id="selection" class="forma_field_2" onchange="return books_admin();">
                    <?php
                    if ($i%10==0)
                        $i=$i/10;
                    else
                        $i=$i/10+1;
                    
                    for ($j=0;$j<($i-1);$j++){
                        echo '<option value="'.$j.'">'.($j*10+1).' - '.($j*10+10).'</option>';
                    }
                    ?>
                </select>
                </td>
            </tr>
            <tr>
                <td class="forma_field_2">Ανενεργές </td>
                <td>
                    <label class="switch">
                    <input type="checkbox" id="checkbox" onchange="return books_admin();">
                    <span class="slider round"></span>
                    </label>
                </td>
            </tr>
            <tr>
                <td id="book_id">
                    <input id="input_text" type="text" class="forma_field_2" onclick="return books_admin_id();" value="Κωδικός κράτησης" style="color:gray; text-align:center;"/>
                </td>
                <td onclick="books_admin();" class="forma_field_2">Αναζήτηση</td>
            </tr>
            <tr><td id="loading" colspan="2">&nbsp;</td></tr>
          </table>
          
      </form>
      </div>
      <div id="book_result" class="results">
        
      </div>
    </div>
	</main>
<?php
	require('part_footer.php');
?>