<?php
        require('part_header.php');
        require('con_authorized.php');
        if($_SESSION['privilege']!='admin'){
            session_destroy();
            header("Location: index.php?msg=Έχετε αποσυνδεθεί!");
            exit();}
		$title = "Διαθεσιμότητα αυτοκινήτων";
?>
	<main onpageshow="return available_admin();">
    <h2 class="headingmsg">Εμφάνηση διαθέσιμων αυτοκινήτων ανα μήνα</h2>
    <div class="top">
      <ul class="topmenu" id="topmenu">
        <li class="liopacity" style="opacity: 1;"><a href="page_available.php">Διαθεσιμότητα οχημάτων</a></li>
        <li class="liopacity" ><a href="page_books.php">Διαχείρηση κρατήσεων</a></li>
      </ul>   
    </div>
    <div class="bookpage" id="forma">
    <div>
      <form name="search_books_form" method="post" onchange="return available_admin();">
          <table>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>    
            <td class="forma_field_2" style="width:fit-content;">Μήνας</td>
            <td class="forma_field_2" style="width:fit-content;">Έτος</td>
            </tr>
            <tr>
            <td><select id="month" class="forma_field_2">
                <option value="01" <?php if (date("m")=="01")
                                            echo 'selected="selected"';
                        ?>
                        >Ιανουάριος</option>
                <option value="02" <?php if (date("m")=="02")
                                            echo 'selected="selected"';
                        ?>>Φεβρουάριος</option>
                <option value="03" <?php if (date("m")=="03")
                                            echo 'selected="selected"';
                        ?>>Μάρτιος</option>
                <option value="04" <?php if (date("m")=="04")
                                            echo 'selected="selected"';
                        ?>>Απρίλιος</option>
                <option value="05" <?php if (date("m")=="05")
                                            echo 'selected="selected"';
                        ?>>Μάιος</option>
                <option value="06" <?php if (date("m")=="06")
                                            echo 'selected="selected"';
                        ?>>Ιούνιος</option>
                <option value="07" <?php if (date("m")=="07")
                                            echo 'selected="selected"';
                        ?>>Ιούλιος</option>
                <option value="08" <?php if (date("m")=="08")
                                            echo 'selected="selected"';
                        ?>>Αύγουστος</option>
                <option value="09" <?php if (date("m")=="09")
                                            echo 'selected="selected"';
                        ?>>Σεπτέμβριος</option>
                <option value="10" <?php if (date("m")=="10")
                                            echo 'selected="selected"';
                        ?>>Οκτώβριος</option>
                <option value="11" <?php if (date("m")=="11")
                                            echo 'selected="selected"';
                        ?>>Νοέμβριος</option>
                <option value="12" <?php if (date("m")=="12")
                                            echo 'selected="selected"';
                        ?>>Δεκέμβριος</option>
            </select></td>
            <td><select id="year" class="forma_field_2">
                <option value="2021" <?php if (date("Y")=="2021")
                                            echo 'selected="selected"';
                        ?>>2021</option>
                <option value="2022" <?php if (date("Y")=="2022")
                                            echo 'selected="selected"';
                        ?>>2022</option>
                <option value="2023" <?php if (date("Y")=="2023")
                                            echo 'selected="selected"';
                        ?>>2023</option>
                <option value="2024" <?php if (date("Y")=="2024")
                                            echo 'selected="selected"';
                        ?>>2024</option>
                <option value="2025" <?php if (date("Y")=="2025")
                                            echo 'selected="selected"';
                        ?>>2025</option>
                <option value="2026" <?php if (date("Y")=="2026")
                                            echo 'selected="selected"';
                        ?>>2026</option>
            </select></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>
            <tr><td id="loading" colspan="2">&nbsp;</td></tr>
          </table>
        </form>
        </div>
        <div class="results">
          <table id="avalaible_table">
          </table>
        </div>
    </div>
	</main>
<?php
	require('part_footer.php');
?>