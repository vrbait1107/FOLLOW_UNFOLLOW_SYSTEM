<?php

// -------------------->> DB CONFIG
require_once "config/mysqlConfig.php";

// -------------------->> SECRETS
require_once "config/Secret.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FOLLOW UNFOLLOW SYSTEM | REGISTER</title>
  <?php include_once "includes/headerScripts.php";?>
   <!-- Google Recaptcha -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>

  <?php

try {

    if (isset($_POST["register"])) {

        if (isset($_POST['g-recaptcha-response'])) {

            $secretKey = $recaptchaSecretKey;
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
            $response = json_decode($verifyResponse);

            if ($response->success) {

                # Avoid XSS
                $username = htmlspecialchars($_POST["username"]);
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);

                # Generate Token
                $token = bin2hex(random_bytes(15));

                # Check Password & Confirm Password are Equal.
                if ($password == $confirmPassword) {

                    # Hash Password
                    $hashPassword = password_hash($password, PASSWORD_BCRYPT);

                    $sql = "SELECT *  FROM user_information WHERE username= :username";
                    $result = $conn->prepare($sql);
                    $result->bindValue(":username", $username);
                    $result->execute();

                    # Checking  Username Already Exist
                    if ($result->rowCount() > 0) {
                        echo "<script>Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Username Already Taken Try Another'
              })</script>";

                    } else {

                        # Set Time for Token
                        $tokenDate = date("Y-m-d H:i:s");
                        $tokenDateMain = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($tokenDate)));

                        # Query
                        $sql = "INSERT INTO user_information (username, email, password, token, tokenDate)
            VALUES (:username, :email, :password, :token, :tokenDateMain)";

                        # Preparing Query
                        $result = $conn->prepare($sql);

                        # Binding Values
                        $result->bindValue(":username", $username);
                        $result->bindValue(":email", $email);
                        $result->bindValue(":password", $hashPassword);
                        $result->bindValue(":token", $token);
                        $result->bindValue(":tokenDateMain", $tokenDateMain);

                        # Executing Query
                        $result->execute();

                        if ($result) {

                            # Include Email Code
                            include_once "./emailCode/emailRegister.php";

                            if (!$mail->send()) {
                                echo "Mailer Error: " . $mail->ErrorInfo;

                            } else {
                                echo "<script>Swal.fire({
                                icon: 'success',
                                title: 'Activate Your Account',
                                text: 'Check Your Email for activate your account'
                              })</script>";
                            }

                        } else {
                            echo "<script>Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'You are failed to register'
                          })</script>";
                        }

                    }

                } else {
                    echo "<script>Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Password & Confirm Password Field are not Matching'
                  })</script>";

                }

            } else {
                echo "<script>Swal.fire({
                icon: 'warning',
                title: 'Google Recaptcha Error',
                text: 'Something Went Wrong with G-recaptcha'
              })</script>";

            }
        } else {
            echo "<script>Swal.fire({
            icon: 'warning',
            title: 'Google Recaptcha Error',
            text: 'Please fill Google Recaptcha'
          })</script>";

        }
    }

} catch (PDOException $e) {
    echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
    # Development Purpose Error Only
    echo "Error " . $e->getMessage();
}

?>

  <!-- Navbar -->
  <?php include_once "includes/navbarLogin.php";?>

  <main class="container my-5">
    <div class="row">
      <section class="col-md-6 offset-md-3">

        <h3 class="breadcrumb font-time mb-3 text-uppercase">Register here</h3>

        <form action="" method="post" onsubmit="return registerValidation()">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username"
              aria-describedby="usernameHelp">
            <small id="usernameHelp" class="text-muted"></small>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Your Password">
             <small class="text-danger">Password should Contain atleast 8 Character, Minimum one uppercase letter,
               Minimum one lowercase letter,
               minimum one number, Minimum one special character. </small>
          </div>

          <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
              placeholder="Confirm Your Password">
          </div>

           <div class="text-center my-2">
              <div class="g-recaptcha text-center" data-sitekey=<?php echo $recaptchaSiteKey; ?>></div>
            </div>

          <input type="submit" value="Register" name="register" class="btn btn-primary btn-block rounded-pill">
        </form>

        <p class="my-2 font-sans">Already Register? <a href="login.php">Please Login here</a></p>

      </section>
    </div>
  </main>

  <!-- include footer script -->
  <?php include_once "includes/footerScripts.php";?>
  <!-- Custom JS -->
  <script src="js/register.js"></script>


</body>

</html>