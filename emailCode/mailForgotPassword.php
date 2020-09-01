<?php

//--------------------------->> SECRETS
require_once "../config/Secret.php";

// Mail PHP code For more details read official documentation of PHPMailer Library
date_default_timezone_set('Etc/UTC');
require '../PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
// Enter Your Email
$mail->Username = "$emailUsername";
// Enter Your Password
$mail->Password = "$emailPassword";
$mail->setFrom("$emailSetFrom", 'The Follow Unfollow System Team');
$mail->addReplyTo('non-reply@gmail.com', 'The Follow Unfollow System Team');
$mail->addAddress($email, $email);
$mail->Subject = "The Follow Unfollow System follow-unfollow-system PASSWORD RESET";

$mail->msgHTML("<!doctype html>
    <html><body> <p>$email You're receiving this e-mail because you requested a password reset
    for your user account at Follow Unfollow System</p>
    <p>Please go to the following page and choose a new password:</p>
    <p>http://localhost//resetPassword.php?token=$token</p>
    <p> This Link valid for 45 Minutes Only </p>
    <p>If you didn't request this change, you can disregard this email - we have not yet reset your password.</p>
    <p>Thanks for using our site!</p>
    <p> The Follow Unfollow System Team<p>
     </body></html>");

$mail->AltBody = "$email You're receiving this e-mail because you requested a password reset
    for your user account at Follow Unfollow System <br/>
    Please go to the following page and choose a new password: <br/>
    http://localhost/follow-unfollow-system/resetPassword.php?token=$token<br/>
    This Link valid for 45 Minutes Only <br/>
    If you didn't request this change, you can disregard this email - we have not yet reset your password. <br/>
     Thanks for using our site!<br/>
     The Follow Unfollow System Team";
