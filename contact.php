<?php

require_once 'connection.php';
require_once 'header.php';

?>

<div class="container col-md-6">
    <h2 class="py-4">Contact</h2>
    <form action="contact.php" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required autofocus>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="sender" required>
        </div>
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="comment" name="text" required></textarea>
        </div>
        <button type="submit" value="1" class="btn large-button">Submit</button>

        <?php
        // checks if text has a value and sends a mail if it has
        if (filter_has_var(INPUT_POST, "text")) {
            $name = $_POST['name'];
            $email = $_POST['sender'];
            $message = $_POST['text'];
            $formcontent = "From: $name \n Message: $message";
            // address the mails are sent to
            $recipient = "1@t45.nl";
            $subject = "Contact Form";
            $mailheader = "From: $email \r\n";
            mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
            echo "Thank You!";
        }
        ?>

    </form>
</div>
<?php
require_once 'footer.php';
?>