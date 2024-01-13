<?php
$url= "PHPMailer/class.smtp.php";
include("$url"); 
// optional, gets called from within class.phpmailer.php if not 
$url2="PHPMailer/class.phpmailer.php";
require_once("$url2");

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username   = "nancyjariwala93@gmail.com";  // GMAIL username
$mail->Password   = "bdon uwur lbop nyzp";            // GMAIL password

$mail->SetFrom("nancyjariwala93@gmail.com");
$mail->Subject = "Test Mail I am sending to learn mail";
$email="unnati9.jariwala@gmail.com";

$permitted_chars = '0123456789';
$otp=substr(str_shuffle($permitted_chars), 0, 4);

//http://127.0.0.1/hope/CodeIgniter-3.1.6//index.php/login_con/resetpass
$mail->Body = "Hello OTP is $otp";
$mail->AddAddress($email);
 if(!$mail->Send())
    {
   echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
		
   echo "Message has been sent $otp";
    }
	
    ?>