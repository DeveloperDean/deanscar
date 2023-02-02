<?php
    $title = "Απόδειξη κράτησης";
    require('part_header.php');
    require('con_authorized.php');
    require('db_params.php');
    
    $lname=$_GET['lname'];
    $booking_no=$_GET['code'];
    $datetrart=$_GET['datestart'];
    $datetop=$_GET['datestop'];
    $car='car'.$_GET['car_id'];

    $date_arr = explode("-", $datetrart);
    if ($date_arr[0]<10)
            $d_start = '0'.$date_arr[0];
        else
            $d_start = $date_arr[0];

        if ($date_arr[1]<10)
            $m_start = $date_arr[1];
        else
            $m_start = $date_arr[1];

    $y_start = $date_arr[2];

    $d_now=date("d");
    $m_now=date("m");
    $y_now=date("Y");

    $date_arr = explode("-", $datetop);
    if ($date_arr[0]<10)
            $d_stop = '0'.$date_arr[0];
        else
            $d_stop = $date_arr[0];

        if ($date_arr[1]<10)
            $m_stop = $date_arr[1];
        else
            $m_stop = $date_arr[1];

    $y_stop = $date_arr[2];
    
    if(($d_now<$d_start)||($m_now<$m_start)||($y_now<$y_start)){
        header('Location: index.php?msg=Προέκυψε σφάλμα! Ελέξτε τις ημερομηνίες');
        exit();
    }
    else{
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');

        $sql = 'UPDATE bookings
                SET status="DONE"
                WHERE booking_no=:booking_no AND lname=:lname;';
        $statement = $pdoObject->prepare($sql);
        $myResult= $statement->execute( array(  ':booking_no'=>$booking_no,
                                                ':lname'=>$lname)  );
        $start_d='cars'.$m_start.$y_start;
        $stop_d='cars'.$m_stop.$y_stop;
        
        if ($m_start!=$m_stop){

            $sqlA = 'UPDATE '.$start_d.'
                        SET '.$car.'=1
                        WHERE '.$car.'=:booking_no;';
            
            $statement = $pdoObject->prepare($sqlA);
            $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
            
            $sqlB = 'UPDATE '.$stop_d.'
                        SET '.$car.'=1
                        WHERE '.$car.'=:booking_no;';
            
            $statement = $pdoObject->prepare($sqlB);
            $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
        }        
        else {
            $sql = 'UPDATE '.$start_d.'
                        SET '.$car.'=1
                        WHERE '.$car.'=:booking_no;';
            
            $statement = $pdoObject->prepare($sql);
            $myResult= $statement->execute( array( ':booking_no'=>$booking_no	)  );
        }
        
        $sql='SELECT * FROM bookings WHERE booking_no='.$booking_no.';';
		$statement = $pdoObject->prepare($sql);
		$statement->execute();
		$record = $statement -> fetch();
        $car_id=$record['car_id'];
		$date_start = $record['date_start'];
        $date_stop = $record['date_stop'];
        $lname=$record['lname'];
        $fname=$record['fname'];
        $email=$record['email'];
        $tel=$record['tel'];
        $amount=$record['amount'];
        
        $sql = 'SELECT * FROM cars WHERE car_id='.$car_id.';';
		$statement = $pdoObject->prepare($sql);
		$myResult= $statement->execute( array( 	)  );
		$record = $statement -> fetch();
        $type_of=$record['type_of'];
        $brand=$record['brand'];
        $model=$record['model'];
        
        // κλείσιμο αποτελεσμάτων ερωτήματος
        $statement->closeCursor();
        // κλείσιμο σύνδεσης με database
        $pdoObject = null;
        
        echo '<main>
        <div class="centeritem">
            <table style="width:100%; border:1px solid black;">
                <tr>
                    <td colspan="3" style="text-align: center;"><h1>CONTRACT</h1></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td>'.date("l, d-m-Y").'</td>
                </tr>
                <tr>
                    <td>BOOKING NO :</td>
                    <td>'.$booking_no.'</td>
                    <td style="border-left:1px dashed black; border-top:1px dashed  black;"><h2>Dins Rent</h2></td>
                </tr>
                <tr>
                    <td><u>DETAILS</u>:</td>
                    <td>&nbsp;</td>
                    <td style="border-left:1px dashed black;">Pigadia Karpathos</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td style="border-left:1px dashed black;">Dodecanisa, 85700</td>
                </tr>
                <tr>
                    <td>CHECK IN</td>
                    <td>'.$date_start.'</td>
                    <td style="border-left:1px dashed black;">Greece</td>
                </tr>
                <tr>
                    <td>CHECK OUT</td>
                    <td>'.$date_stop.'</td>
                    <td style="border-left:1px dashed black;"></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="border-left:1px dashed black;">bookings@ntinos.site</td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td>'.$lname.'</td>
                    <td style="border-left:1px dashed black; border-bottom:1px dashed black;">www.ntinos.site</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>'.$fname.'</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>E-MAIL</td>
                    <td colspan="2">'.$email.'</td>
                </tr>
                <tr>
                    <td>PHONE</td>
                    <td colspan="2">'.$tel.'</td>
                </tr>
                <tr>
                    <td>CAR TYPE</td>
                    <td colspan="2">'.$brand.' '.$model.'</td>
                </tr>
                <tr>
                    <td>TOTAL AMOUNT : </td>
                    <td colspan="2">'.$amount.' &euro;</td>
                </tr>
                <tr><td colspan="3"><img src="images/cardraw.jpg" alt="car draw" width="50%"></td></tr>                
            </table>
        </div>
		<div class="centeritem">
				<button onclick="window.print();" class="noprint" style="margin-left: 40%;"><img src="images/print.png" alt="Εκτύπωση"/></button>
				<button onclick="goto();" class="noprint"><img src="images/home.png" alt="Αρχική σελίδα"/></button>
		</div>	
	</main>';
    }
    require('part_footer.php');
?>