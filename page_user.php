<?php
		require('part_header.php');
        require('con_authorized.php');
        $username=$_SESSION['username'];
        $privilege=$_SESSION['privilege'];
        $title = "Προσωπική σελίδα ".$username;
?>
	<main class="login_page">
          <?php 
            echo '<p class="login_table">Καλώς ορίσατε '.$username.'.</p>';
          ?>
          <div class="user_conteiner">
              <div class="user_button" onclick="window.location.href='page_available.php';" title="Κρατήσεις"><img alt="Κρατήσεις" class="user_img" src="images/icon_booking.png"/><p>Κρατήσεις</p></div>
            <div class="user_button" onclick="window.location.href='page_edit.php';" title="Διαθεσιμότητα"><img alt="Διαθεσιμότητα" class="user_img" src="images/icon_car.png"/><p>Οχήματα</p></div>
          </div>
          <div class="user_conteiner">
            <div class="user_button" onclick="window.location.href='page_add.php';" title="Προσθήκη"><img alt="Προσθήκη" class="user_img" src="images/icon_add.png"/><p>Προσθήκη μήνα</p></div>
            <div class="user_button" onclick="window.location.href='page_settings.php';" title="Επεξεργασία"><img alt="Επεξεργασία" class="user_img" src="images/icon_settings.png"/><p>Προτιμήσεις</p></div>
          </div>
	</main>
<?php
	require('part_footer.php');
?>