<?php
		$title = "Ο στόλος μας";
		require('part_header.php');
?>
	<main>
		<?php 
            $i=0;
			require('db_params.php');
			$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
			$pdoObject -> exec('set names utf8');
            $sql = 'SELECT * FROM cars ORDER BY brand, model;';

            $statement = $pdoObject->prepare($sql);
            $statement->execute();
            
            while ($record = $statement -> fetch()) {
                $img = $record['img_path'];
				$descr = $record['descr'];
                $brand = $record['brand'];
				$model = $record['model'];
                $type_of = $record['type_of'];
                if(($brand!=$temp_brand)&&($model!=$temp_model)){
                    if($i%2==0){
                        echo '<div class="CarL_ParR">
                                <div class="CarL">
                                <img class="CarImg" src="'.$img.'"/>
                                </div>
                                <div class="ParR">
								<h3 style="text-align:center;">'.$brand.' - '.$model.'</h3>
                                <p>&nbsp;&nbsp;&nbsp;'.$descr.'</p>
                                </div>
                            </div>';
                        $temp_model=$model;
                        $temp_brand=$brand;
                        $i++;
                    }else {
                        echo '<div class="ParL_CarR">
                                <div class="ParL">
								<h3 style="text-align:center;">'.$brand.' - '.$model.'</h3>
                                <p>&nbsp;&nbsp;&nbsp;'.$descr.'</p>
                                </div>
                                <div class="CarR">
                                <img class="CarImg" src="'.$img.'" style="float: right;"/>
                                </div>
                            </div>';
                        $temp_model=$model;
                        $temp_brand=$brand;
                        $i++;
                    }
                }
			}
            
            $statement->closeCursor();
            $pdoObject = null;
			?>
	</main>
<?php
	require('part_footer.php');
?>