<?php
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$people = $_POST['people'];
$message = $_POST['message'];
$error = "";
$errorMessage = 'Sorry your message can not be sent.';

//Validate first
if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time) || empty($people) || empty($message)) {
    echo "Name and email and message are required !";
    header('Location: index.html');
}
//validate against any email injection attempts
if (IsInjected($email)) {
    echo "Bad email value!";
    header('Location: index.html');
}


$msg =  " Name : $name \r\n";
$msg .= " Email: $email \r\n";
$msg .= " WebSite: " . $_SERVER["SERVER_NAME"] . "\r\n";
$msg .= " Phone: $phone \r\n";
$msg .= " Date: $date \r\n";
$msg .= " Time: $time \r\n";
$msg .= " People: $people \r\n";
$msg .= " Message : " . stripslashes($_POST['message']) . "\r\n\n";
$msg .= "User information \r\n";
$msg .= "User IP : " . $_SERVER["REMOTE_ADDR"] . "\r\n";
$msg .= "Browser info : " . $_SERVER["HTTP_USER_AGENT"] . "\r\n";
$msg .= "User come from : " . $_SERVER["SERVER_NAME"] . "\r\n";
$msg .= "Template Name : Rajain Food";

$recipient = "info@rajainfood.com"; // Change the recipient email adress to your adrees  
$sujet =  "Sender information";
$mailheaders = "From: $email\r\nReply-To: $email\r\nReturn-Path: $email\r\n";

if (!$error) {

    $sending = mail($recipient, $sujet, $msg, $mailheaders);

    if ($sending) {
        // If the message is sent we output a string to use it 
        echo "<script>alert('Message Sending')</script>";
        echo "<meta http-equiv='refresh' content='0 url=index.html'>";
    } else {
        // Display Error Message
        echo $errorMessage;
    }
} else {
    echo $error; // Display Error Message
}


// Function to validate against any email injection attempts
function IsInjected($str)
{
    $injections = array(
        '(\n+)',
        '(\r+)',
        '(\t+)',
        '(%0A+)',
        '(%0D+)',
        '(%08+)',
        '(%09+)'
    );
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    if (preg_match($inject, $str)) {
        return true;
    } else {
        return false;
    }
}
