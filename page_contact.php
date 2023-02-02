<?php
		$title = "Επικοινωνία";
		require('part_header.php');
?>
<main class="login_page">
<div id="contact0">
    <div id="contact1">
        <p style="text-align:center">Στείλτε μας τη γνώμη σας</p>
        <form id="contactform" class="contactform" method="GET" onsubmit="return contact_validation();" action="con_contact.php">
        <input id="lname" name="lname" type="text" class="feedback-input" placeholder="Επώνυμο" />
        <input id="fname" name="fname" type="text" class="feedback-input" placeholder="Όνομα" />   
        <input  id="email"name="email" type="text" class="feedback-input" placeholder="Email" />
        <textarea  id="text" name="text" class="feedback-input" placeholder="Comment"></textarea>
        <input id="contact_sub" type="submit" value="SUBMIT"/>
        </form>
    </div>
    <div id="contact2">
        <h3>Επικοινωνία</h3>
        <p>  
            Βωλάδα, Καρπάθος <br>
            85700 Τηλ: 1234567890 <br>
            Email: booking@ntinos.site
        </p>
    </div>
    <div id="contact3">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6492.252509735079!2d27.15494137344174!3d35.5505839499305!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1496a9cfad6b5cf7%3A0xb047b94350b6b9fd!2zzpLPic67zqzOtM6xIDg1NyAwMA!5e0!3m2!1sel!2sgr!4v1643026416397!5m2!1sel!2sgr" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>

</main>
<?php
    require('part_footer.php');
?>