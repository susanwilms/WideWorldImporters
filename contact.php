<?php

require_once 'connection.php';
require_once 'header.php';

?>

<form>
    <form action="contact.php" method="POST">
        <p>Name</p> <input type="text" name="name">
        <p>Email</p> <input type="text" name="email">
        <p>Message</p><textarea name="message" rows="6" cols="25"></textarea><br />
        <input type="submit" value="Send"><input type="reset" value="Clear">

        <?php $name = $_POST['name'];
        $email = $_POST['email'];
        $message_POST['message'];
        $formcontent="From: $name \n Message: $message";
        $recipient = "1@t45.nl";
        $subject = "Contact Form";
        $mailheader = "From: $email \r\n";
        mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
        echo "Thank You!";
        ?>

    </form>

<?php
require_once 'footer.php';
?>