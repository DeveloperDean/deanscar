    <footer class="bottom">
    <div id="footerdiv">
        <div id="footerdiv1" class="footer_li">
            <ul id="ul1">
                <li><h2>Επικοινωνία</h2></li>
                <li id="footer_line"></li>
                <li>Βωλάδα, Καρπάθος</li>
                <li>85700</li>
                <li><a href="tel:1234567890">Τηλ: 1234567890</a></li>
                <li><a href="mailto:booking@ntinos.site">Email: booking@ntinos.site</a></li>
            </ul>
        </div>
        <div id="footerdiv2" class="footer_li">
            <ul id="ul2">
                <li><h2>Περιεχόμενα</h2></li>
                <li id="footer_line"></li>
                <li><a href="index.php">Αρχική σελίδα</a></li>
                <li><a href="page_cars.php">Στόλος</a></li>
                <li><a href="page_offers.php">Προσφορές</a></li>
                <li><a href="page_contact.php">Εποκοινωνία</a></li>
            </ul>
        </div>
        <?php
        if(isset($_SESSION['username'])){
        echo '
        <div id="footerdiv3" class="footer_li">
            <ul id="ul3">
            <li><h2>Επιπλέων επιλογές</h2></li>
            <li id="footer_line"></li>
            <li><a href="page_user.php">Προφίλ χρήστη</a></li>
            <li><a href="page_available.php">Κρατήσεις</a></li>
            <li><a href="page_edit.php">Οχήματα</a></li>
            <li><a href="page_add.php">Μήνες</a></li>
            <li><a href="page_settings.php">Προτιμήσεις</a></li>
            </ul>
        </div>';}?>
	</div>
    <div style="padding-top:3em;">
        <p class="footer_p">Design and development by ntinos</p>
    </div>
    </footer>
	<script src="//code.tidio.co/y5furoxvnjjat7zlnhd4vgnuawjc2mfl.js" async></script>
</body>
</html>