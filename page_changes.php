<?php
		$title = "Διαχείρηση κράτησης";
		require('part_header.php');
?>
    <div>
        <h1 style="font-size: 1.5em; text-align: center; color: #3C403D;">Din&rsquo;s rent</h1>
        <h2 class="headingmsg">A deal with Din it's a dream!</h2>
        <h3 class="headingmsg">Διαχειρηστείτε την κράτηση σας</h3>
    </div>
    <div class="top">
          <ul class="topmenu" id="topmenu">
            <li class="liopacity"><a href="index.php">Κάντε κράτηση</a></li>
            <li class="liopacity" style="opacity: 1;"><a href="page_changes.php">Διαχείρηση κράτησης</a></li>
          </ul>   
    </div>
    <div class="forma" id="forma">
      <form name="search_booking" method="post" onsubmit="booking_validation();" action="ajax_changes.php">
          <table>
            <tr><td colspan="4"></td><tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            
            <tr class="table_mobile">    
            <td class="forma_field_1">Επώνυμο</td>
            <td><input class="forma_field_2" type="text" id="surname" name="surname" <?php if (isset($_GET['lname']))
    echo 'value="'.$_GET['lname'].'"'?>/></td>
            <td class="forma_field_1">Αριθμός κράτησης</td>
            <td><input class="forma_field_2" type="text" id="codebooking" name="codebooking"<?php if (isset($_GET['code']))
    echo 'value="'.$_GET['code'].'"'?>/></td>
            </tr>

            <tr><td colspan="4">&nbsp;</td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
              
              <tr><td colspan="4"><button class="forma_field_2" name="submit" type="submit" value="Αλλαγή">Αλλαγή</button></td></tr>
            <tr><td colspan="4"><?php  echo_msg(); ?></td></tr>
              
          </table>
      </form>
    </div>
    <main>
        <div class="slideshow-container">
			<?php 
				require('db_params.php');
				$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
				$pdoObject -> exec('set names utf8');
				$sql='SELECT COUNT(car_id) FROM cars;';
				$statement = $pdoObject->prepare($sql);
				$statement->execute();
				$record = $statement -> fetch();
				$totalcars = $record['COUNT(car_id)'];		// ο αριθμός των συνολικών αυτοκινήτων
                $j=0;
				for ($i=1;$i<=$totalcars;$i++){
					$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
					$pdoObject -> exec('set names utf8');
					$sql='SELECT * FROM cars ORDER BY brand, model LIMIT 1 OFFSET '.($i-1).';';
					$statement = $pdoObject->prepare($sql);
					$statement->execute();
					$record = $statement -> fetch();
					$img = $record['img_path'];
					$model = $record['model'];
				    $brand = $record['brand'];
                    if(($temp_model!=$model)&&($temp_brand!=$brand)){
                        echo '<div class="mySlides fade">
                          <div class="numbertext">'.$i.' / '.$totalcars.'</div>
                          <img src="'.$img.'" style="width:100%">
                          <div class="text">'.$model.'</div>
                        </div>';
                        $temp_model=$model;
                        $temp_brand=$brand;
                        $j++;
                    }
                }
				$statement->closeCursor();
				$pdoObject = null;
				echo '</div><br><div style="text-align:center">';
				for ($i=1;$i<=$j;$i++){
					echo '<span class="dot"></span> ';
				}				
			?>	 
        </div>
        
        <script>
            showSlides();
        </script>
	</main>
<?php
	require('part_footer.php');
?>