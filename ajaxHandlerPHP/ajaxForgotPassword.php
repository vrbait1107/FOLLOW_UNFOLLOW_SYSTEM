<?php
// Creating Database Connection
require_once "../config.php";
session_start();

extract($_POST);

// #########################  FORGOT PASSWORD

// Generating Random token to Send Over Email.
$token = bin2hex(random_bytes(15));

if (isset($_POST['submit'])) {

    //Query
    $sql = "SELECT email FROM user_information WHERE email = :email";

    //Preparing Query
    $result = $conn->prepare($sql);

    // Binding Value
    $result->bindValue(":email", $email);

    //Executing Query
    $result->execute();

    if ($result->rowCount() === 1) {

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
        $mail->Username = "YOUR EMAIL ADDRESS";
        // Enter Your Password
        $mail->Password = "YOUR EMAIL PASSWORD";
        $mail->setFrom('YOUR EMAIL ADDRESS', 'The Follow Unfollow System Team');
        $mail->addReplyTo('non-reply@gmail.com', 'The Follow Unfollow System Team');
        $mail->addAddress($email, $email);
        $mail->Subject = "The Follow Unfollow System PASfollow-unfollow-systemSWORD RESET";

        $mail->msgHTML("<!doctype html>
    <html><body> <p>$email You're receiving this e-mail because you requested a password reset
    for your user account at Follow Unfollow System</p>
    <p>Please go to the following page and choose a new password:</p>
    <p>http://localhost//resetPassword.php?token=$token</p>
    <p>If you didn't request this change, you can disregard this email - we have not yet reset your password.</p>
    <p>Thanks for using our site!</p>
    <p> The Follow Unfollow System Team<p>
     </body></html>");

        $mail->AltBody = "$email You're receiving this e-mail because you requested a password reset
    for your user account at Follow Unfollow System <br/>
    Please go to the following page and choose a new password: <br/>
    http://localhost/follow-unfollow-system/resetPassword.php?token=$token<br/>
    If you didn't request this change, you can disregard this email - we have not yet reset your password. <br/>
     Thanks for using our site!<br/>
     The Follow Unfollow System Team";

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {

            //Update Query
            $sql = "UPDATE user_information SET token = :token WHERE email = :email";

            //Preparing Query
            $result = $conn->prepare($sql);

            //Binding Value
            $result->bindValue(":token", $token);
            $result->bindValue(":email", $email);

            // Executing Query
            $result->execute();

            if ($result) {
                echo "<script>Swal.fire({
                        icon: 'success',
                        title: 'Successful',
                        text: 'Password Reset Link sent to your email, Check Your Mail.'
                    })</script>";

            } else {
                echo "<script>Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'We are failed to send email for reset password.'
                    })</script>";

            }

        }
    } else {
        echo "<script>Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'No Such Email Found'
                })</script>";
    }

}
