<?php 
    $lname=trim($_GET['lname']);
    $fname=trim($_GET['fname']);
    $email=trim($_GET['email']);
    $text=trim($_GET['text']);

    if( (strlen($lname)<3)||(strlen($fname)<3)||(strlen($lname)>50)||(strlen($fname)>50)||(strlen($text)<5)||(strlen($text)>200)) {
        header('Location: index.php?msg=Προέκυψε σφάλμα(er100)');
	    session_destroy();
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?msg=Προέκυψε σφάλμα(er101)');
		session_destroy();
        exit();
    }

    $to = "ntinos_31@hotmail.com";
    $subject = "Dinos rent contact";

    $message = "
    <html>
    <head>
    <title>HTML email</title>
    </head>
    <body>
    <p>This email contains HTML Tags!</p>
    <table>
    <tr>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Lastname</th>
    </tr>
    <tr>
    <td>".$fname."</td>
    <td>".$lname."</td>
    <td>".$email."</td>
    </tr>
    </table>
    <p>".$text."</p>
    </body>
    </html>
    ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <contact@ntinos.site>' . "\r\n";
    mail($to,$subject,$message,$headers);

    header('Location: page_contact.php?response=Το μήνυμα εστάλη');
    exit();
?>