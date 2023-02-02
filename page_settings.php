<?php
        require('part_header.php');
        require('con_authorized.php');
        if($_SESSION['privilege']!='admin'){
            session_destroy();
            header("Location: index.php?msg=Έχετε αποσυνδεθεί!");
            exit();}
		$title = "Προτιμήσεις";
		echo '<div class="centeritemsg" id="error">';
        echo_msg();
        echo '</div>';
        require('db_params.php');
        try {
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $sql='SELECT * FROM price;';
            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            while ($record = $statement -> fetch()) {
                $i = $record['id_category'];        // αναζητούμε την τιμή ανά ημερα
                $preday[$i] = $record['amount'];  	// και την θέτουμς στη μεταβλητη preday
            }
            $statement->closeCursor();
            $pdoObject = null;
        }
        catch (PDOException $e) {
            // σε περίπτωση που δεν εκτελεστει το query
            header('Location: page_addcar.php?msg=Προέκυψε σφάλμα(er130)');
            exit();
        }

?>
	<main>
    <div class="top">
      <ul class="topmenu" id="topmenu">
        <li class="liopacity" style="opacity: 1;"><a href="page_settings.php">Προτιμήσεις</a></li>
      </ul>   
    </div>
    <div class="bookpage" id="forma">
      <div>
          <table>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>
                <td class="forma_field_2" style="width:fit-content;">1η κατηγορία</td>
                <td><select id="class1" name="class1" class="forma_field_2">
                    <?php
                        for($i=30;$i<=70;$i++){
                            if($preday[1]==$i)
                                echo '<option selected="selected" value="'.$i.'">'.$i.' &#128;</option>';
                            else
                                echo '<option value="'.$i.'">'.$i.' &#128;</option>';
                        }
                    ?>
                    </select>
                </td>
                <td class="forma_field_2" id="update1" onclick="update_price(1)">Update</td>
            </tr>
            <tr>    
                <td class="forma_field_2" style="width:fit-content;">2η κατηγορία</td>
                <td><select id="class2" name="class2" class="forma_field_2" selected="30">
                    <?php
                        for($i=20;$i<=60;$i++){
                            if($preday[2]==$i)
                                echo '<option selected="selected" value="'.$i.'">'.$i.' &#128;</option>';
                            else
                                echo '<option value="'.$i.'">'.$i.' &#128;</option>';
                        }
                    ?>
                    </select>
                </td>
                <td class="forma_field_2" id="update2" onclick="update_price(2)">Update</td>
            </tr>
          </table>
        </div>
    </div>
    
	</main>
<?php
	require('part_footer.php');
?>