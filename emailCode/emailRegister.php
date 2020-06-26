<?
                // (Please Read Documentation https: //github.com/PHPMailer/PHPMailer


                date_default_timezone_set('Etc/UTC');

                require 'PHPMailer/PHPMailerAutoload.php';

                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Debugoutput = 'html';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                // Enter Your Username
                $mail->Username = "YOUR EMAIL";
                // Enter Your Password
                $mail->Password = "YOUR PASSWORD";
                $mail->setFrom('YOUR EMAIL', 'Follow Unfollow System');
                $mail->addReplyTo('non-reply@gmail.com', 'Follow Unfollow System');
                $mail->addAddress($email, $username);
                $mail->Subject = "Activate Your Follow Unfollow System Account";

//Read an HTML message body from an external file, convert referenced images to embedded,
                //convert HTML into a basic plain-text alternative body

                $mail->msgHTML("<!doctype html>
    <html>
    <body>
    <p>Thank you $username for creating an account with Follow Unfollow System</p>

    <p>There's just one more step before you can login you need to activate your Follow
    Unfollow System account. To activate your account, click the following link. If that
    doesn't work, copy and paste the link into your browser's address bar.</p>
    <p>http://localhost/follow-unfollow-system/activateEmail.php?token=$token</p>

    <p>If you didn't create an account, you don't need to do anything; you won't
    receive any more email from us. If you need assistance, please do not reply to
    this email message. Check the help section of the Follow Unfollow System website.</p>

  </body>
  </html>");

                $mail->AltBody = "Thank you $username for creating an account with Follow Unfollow System <br/>
  There's just one more step before you can login, you need to activate your Follow Unfollow System
  account. To activate your account, click the following link. If that doesn't work, copy and paste the link into
  your browser's address bar. <br/>
  http://localhost/follow-unfollow-system/activateEmail.php?token=$token <br/>
  If you didn't create an account, you don't need to do anything; you won't receive any more email from us. If you
  need assistance, please do not reply to this email message. Check the help section of the follow-unfollow-system.";

?>
