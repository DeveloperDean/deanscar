<?php
    session_start();
	require('functions.php'); 
	error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title;?></title>
  <link rel="icon" type="image/png" href="/images/favicon.png">
  <meta charset="UTF-8">
  <meta name="keywords" content="CAR, CARS, RENT, RENTAL, KARPATHOS, SUMMER, GREECE, GREEK, TURIST, ΕΝΟΙΚΙΑΣΗ, ΑΥΤΟΚΙΝΗΤΟ, ΑΥΤΟΚΙΝΗΤΩΝ, ΚΑΡΠΑΘΟΣ">
  <meta name="description" content="Car rental web site">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <script src="myScript.js" type="text/javascript"></script>
</head>
<body class="container" onload="disappear()">
    <header class="navig">
        <div id="logo_header">
			<a href="index.php"><img src="images/logo_header.jpg" alt="Dins car rental"/></a>
		</div>
        <div class="dropdown">
          <button class="dropbtn">Menu  &or;</button>
          <div class="dropdown-content">
              <a href="index.php">Αρχική</a>
            <?php
                if(!isset($_SESSION['username']))
                  echo '<a href="page_login.php">Σύνδεση</a>';
                else{
                echo   '<a href="page_user.php">Προφίλ χρήστη</a>
                        <a href="page_available.php">Κρατήσεις</a>
                        <a href="page_edit.php">Οχήματα</a>
                        <a href="page_add.php">Μήνες</a>
                        <a href="page_settings.php">Προτιμήσεις</a>';
                }
              ?>
            <a href="page_cars.php">Στόλος</a>
            <a href="page_offers.php">Προσφορές</a>
            <a href="page_contact.php">Επικοινωνία</a>
            <?php if(isset($_SESSION['username']))
                  echo '<a href="con_logout.php">Αποσύνδεση</a>';?>
          </div>
        </div>
    </header>