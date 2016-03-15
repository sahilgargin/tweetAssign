<?php 

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$formcontent="Contact form\n\nFrom: $name \nMessage: $message";
$recipient = "sahilgargin@gmail.com";
$subject = "Contact Form";
$mailheader = "From: $email \r\n";
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "Thank You! E-mail send.";

?>