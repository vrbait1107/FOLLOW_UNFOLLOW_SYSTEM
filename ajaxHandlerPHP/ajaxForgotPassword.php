<?php

// ------------------------------->> DB CONFIG
require_once "../config/mysqlConfig.php";

// ------------------------------->> START SESSION
session_start();

extract($_POST);

try {

// --------------------------------->>  FORGOT PASSWORD

    # Generate Token.
    $token = bin2hex(random_bytes(15));

    if (isset($_POST['submit'])) {

        # Avoid XSS
        $email = htmlspecialchars($email);

        # Query
        $sql = "SELECT email FROM user_information WHERE email = :email";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Value
        $result->bindValue(":email", $email);

        # Executing Query
        $result->execute();

        if ($result->rowCount() === 1) {

            # Including Email Code
            include_once "../emailCode/mailForgotPassword.php";

            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {

                $tokenDate = date("Y-m-d H:i:s");
                $tokenDateMain = date('Y-m-d H:i:s', strtotime('+45 minutes', strtotime($tokenDate)));

                # Update Query
                $sql = "UPDATE user_information SET token = :token, tokenDate = :tokenDateMain WHERE email = :email";

                # Preparing Query
                $result = $conn->prepare($sql);

                # Binding Value
                $result->bindValue(":token", $token);
                $result->bindValue(":tokenDateMain", $tokenDateMain);
                $result->bindValue(":email", $email);

                #  Executing Query
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

} catch (PDOException $e) {
    echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
    # Development Purpose Error Only
    echo "Error " . $e->getMessage();

}
