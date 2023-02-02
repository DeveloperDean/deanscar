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
    <h2 class="headingmsg">Καταχώρηση νέου οχήματος</h2>
    <div class="top">
      <ul class="topmenu" id="topmenu">
            <li class="liopacity"><a href="page_edit.php">Επεξεργασία οχημάτων</a></li>
            <li class="liopacity" style="opacity: 1;"><a href="page_addcar.php">Προσθήκη οχήματος</a></li>
      </ul>   
    </div>
    <div class="bookpage" id="forma">
    <div>
      <form name="addcar_form" method="POST" onsubmit="return add_car();" action="con_add_car.php" enctype="multipart/form-data">
          <table>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>    
                <td class="forma_field_2" style="width:fit-content;">Κατηγορία</td>
                <td><select id="carclass" name="carclass" class="forma_field_2">
                    <option value="1">1η</option>
                    <option value="2">2η</option>
                </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="forma_field_2" style="width:fit-content;">Επιβάτες</td>
                <td><select id="pers" name="pers" class="forma_field_2">
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="5" selected="selected">5</option>
                </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>    
                <td class="forma_field_2" style="width:fit-content;">Πόρτες</td>
                <td><select id="doors" name="doors" class="forma_field_2">
                    <option value="3">3</option>
                    <option value="5">5</option>
                </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>    
                <td class="forma_field_2" style="width:fit-content;">Ταχύτητες</td>
                <td><select id="trans" name="trans" class="forma_field_2">
                    <option value="manual">Χειροκίνητο</option>
                    <option value="auto">Αυτόματο</option>
                </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="forma_field_2" style="width:fit-content;">Μάρκα</td>
                <td><input type="text" id="car_brand" name="car_brand" class="forma_field_2"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td id="w_brand" class="wrongmsg">&nbsp;</td>
            </tr>
            <tr>
                <td class="forma_field_2" style="width:fit-content;">Μοντέλο</td>
                <td><input type="text" id="car_type" name="car_type" class="forma_field_2"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td id="w_type" class="wrongmsg">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><input type="file" name="upload"/></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="forma_field_2" style="width: -webkit-fill-available; display:table;">Περιγραφή</td>
                <td><textarea type="text" id="car_descr" name="car_descr" class="forma_field_2" style="height:4em;"></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td id="w_descr" class="wrongmsg">&nbsp;</td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr><td id="loading" colspan="2">&nbsp;</td></tr>
              <tr><td colspan="2"><button class="forma_field_2" name="submit" type="submit" value="Προσθήκη">Προσθήκη</button></td></tr>
          </table>
        </form>
        </div>
    </div>
    
	</main>
<?php
	require('part_footer.php');
?>