<?php
		$title = "Προσφορές";
		require('part_header.php');
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(window).on("load",function(){
            $("#offers1").slideDown("slow");
            $("#offers2").slideDown("slow");
            $("#offers3").slideDown("slow");
        });
    </script>
	<main id="offersbg">
        <div id="offers0">
            <div id="offers1" class="sqr">
                <p>Το Dins Rent προσφαίρει δωρεάν ασφάλεια ατυχήματος</p>
            </div>
            <div id="offers2" class="sqr">
                <p>Για κρατήσεις πέρα των 3 ημρεών έχετε έκπτωση -5%<br>πέρα των 5 ημρεών  έκπτωση -10%<br>πέρα των 7 ημρεών έκπτωση -15%<br>πέρα των 10 ημερών έκπτωση -20%</p>
            </div>
            <div id="offers3" class="sqr">
                <p>Το Dins Rent προσφαίρει δωρεάν ακύρωση καθώς και δωρεάν αλλαγή κράτησης. </p>
            </div>
        </div>
	</main>
<?php
	require('part_footer.php');
?>