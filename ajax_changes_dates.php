<?php 
    session_start();
    $booking_no=$_SESSION['booking_no_del'];
    $lname=$_SESSION['lname_del'];
    $fname=$_SESSION['fname_del'];
    $car_id=$_SESSION['car_id_del'];
    $date_start=$_SESSION['date_start_del'];
    $date_arr = explode("-", $date_start);
    $d_start = $date_arr[0];
	$m_start = $date_arr[1];
	$y_start = $date_arr[2];
	
    $date_stop=$_SESSION['date_stop_del'];
    $date_arr = explode("-", $date_stop);
    $d_stop = $date_arr[0];
	$m_stop = $date_arr[1];
	$y_stop = $date_arr[2];

    $start_d = "cars".$m_start.$y_start;
    $stop_d = "cars".$m_stop.$y_stop;
    
    $car = "car".$car_id;
?>
<form name="search_form" method="post" onsubmit="return date_validation2();">
          <table class="">

            <tr><td colspan="4"><strong>Επιλέξτε νέες ημερομηνίες</strong>:</td><tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            
            <tr class="table_mobile">    
            <td class="forma_field_1">Ημερομηνία παραλαβής</td>
            <td><input class="forma_field_2" style="width:fit-content;" type="date" value="<?php echo $y_start.'-'.$m_start.'-'.$d_start;?>" name="datestart" id="datestart" min="<?php echo date('Y-m-d', strtotime('+1 day'));?>"/></td>
            <td class="forma_field_1">Ημερομηνία παράδοσης</td>
            <td><input class="forma_field_2" style="width:fit-content;" type="date" value="<?php echo $y_stop.'-'.$m_stop.'-'.$d_stop;?>" min="<?php echo date('Y-m-d', strtotime('+2 day'));?>" name="datestop" id="datestop"/></td>
            </tr>

            <tr><td colspan="4" id="not_available">&nbsp;</td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
              
            <tr><td colspan="4"><input class="forma_field_2" name="submit" type="submit" value="Αναζήτηση"></td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
              
          </table>
      </form>