<?php
include 'dbconnect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email = $_POST["email"];
$sql = "SELECT * FROM `users` WHERE email='$email'";
$result = mysqli_query($connection,$sql);
$num = mysqli_num_rows($result);
if($num==0){
    echo 0;
}
else{
    $row = mysqli_fetch_assoc($result);
    $token = $row["token"];
    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'krshivam4545@gmail.com';                     // SMTP username
    $mail->Password   = 'Assam@123';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($email, 'Mailer');
    $mail->addAddress($email, 'Joe User');     // Add a recipient

    // Content
    //$mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Recovery Password Mail';
    $mail->Body    = "Hii You  May Rest Your Password By Clicking on This link http://localhost/finalauth/updatepassword.php?token=$token&email=$email";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 1;
}
?>