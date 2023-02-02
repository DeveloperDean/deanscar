<?php
		$title = "Συνδεση στο λογαριασμό";
		require('part_header.php');
?>
	<main class="login_page">
        <div class="forma_login" id="forma">
          <form name="login_form" method="post" onsubmit="return login_validation();" action="con_login.php">
              <table class="login_table">

                <tr><td class="forma_field_1" style="font-size:1.4em;"><strong>Σύνδεση</strong></td><tr>
                <tr><td>&nbsp;</td></tr>

                <tr><td>Όνομα χρήστη</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td><input type="text" id="login_un" name="login_un" class="forma_field_2"/></td>
                <tr><td>&nbsp;</td></tr>
                <tr><td>Κωδικός πρόσβασης</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td><input type="password" id="login_pw" name="login_pw" class="forma_field_2"/></td></tr>

                <tr><td>&nbsp;</td></tr>
                <tr><td id="msg"><?php echo_msg(); ?></td></tr>
                <tr><td>&nbsp;</td></tr>

                <tr><td><input class="forma_field_2" name="submit" type="submit" value="Είσοδος"></td></tr>
                <tr><td>&nbsp;</td></tr>

              </table>
          </form>
        </div>
	</main>
<?php
	require('part_footer.php');
?>