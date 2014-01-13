<?php

// check for form submission - if it doesn't exist then send back to contact form
if (!isset($_POST['save']) || $_POST['save'] != 'contact') {
    header('Location: contact.php'); exit;
}
	
// get the posted data
$name = $_POST['contact_name'];
$email_address = $_POST['contact_email'];
$phone = $_POST['contact_phone'];
$message1 = $_POST['contact_message1'];
$message2 = $_POST['contact_message2'];
	
// check that a name was entered
if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email_address))
    $error = 'You must enter a valid email address.';
// check that a phone number was entered
// check if an error was found - if there was, send the user back to the form
if (isset($error)) {
    header('Location: contact.php?e='.urlencode($error)); exit;
}

$headers = "From: $email_address\r\n"; 
$headers .= "Reply-To: $email_address\r\n";

// write the email content
$email_content = "Name: $name\n";
$email_content .= "Email Address: $email_address\n";
$email_content .= "Phone Number: $phone\n";
$email_content .= "Info:\n\n$message1";
$email_content .= "Questions:\n\n$message2";
	
// send the email
//ENTER YOUR INFORMATION BELOW FOR THE FORM TO WORK!
mail ('recruitment@phideltcmu.org', 'PHIDELTCMU - Contact Form Submission', $email_content, $headers);
	
// send the user back to the form
header('Location: contact.php?s='.urlencode('Thank you for your message.')); exit;

?>