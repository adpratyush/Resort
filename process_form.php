<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Compose email message
    $to = 'adpratyush@gmail.com';
    $subject = 'New Form Submission';
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";

    // Send email
    if (mail($to, $subject, $body)) {
        // Redirect to contact.php
        echo '<script>alert("Thank you! Your message has been sent.");</script>';
        header("Location: contact.php");
        exit();
        
    } else {
        echo '<script>alert("Sorry, something went wrong. Please try again later.");</script>';
    }
}
?>
