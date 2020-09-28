<?php

// -------------------->> DB CONFIG
require_once "config/mysqlConfig.php";

// -------------------->> SECRETS
require_once "config/Secret.php";

// -------------------->> START SESSION
session_start();

// -------------------->> CHECKING USER
if (isset($_SESSION['user'])) {
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FOLLOW UNFOLLOW SYSTEM | LOGIN</title>
  <?php include_once "includes/headerScripts.php";?>
    <!-- Google Recaptcha -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>

<?php

try {

    if (isset($_POST["login"])) {

        if (isset($_POST['g-recaptcha-response'])) {

            $secretKey = $recaptchaSecretKey;
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
            $response = json_decode($verifyResponse);

            if ($response->success) {

                # Avoid XSS
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $sql = "SELECT * FROM user_information WHERE username= :username OR email =:email";
                $result = $conn->prepare($sql);

                $result->bindValue(":username", $username);
                $result->bindValue(":email", $username);

                $result->execute();

                $row = $result->fetch(PDO::FETCH_ASSOC);
                $activeStatus = $row['status'];
                $dbPassword = $row['password'];
                $userEmail = $row['email'];
                $userId = $row['user_id'];
                $username = $row['username'];

                # Verify Password
                if (password_verify($password, $dbPassword)) {

                    if ($activeStatus == "active") {

                        $_SESSION['user'] = $userEmail;
                        $_SESSION['userId'] = $userId;
                        $_SESSION['username'] = $username;

                        # Redirect to Index Page
                        header("Location:index.php");

                    } else {
                        echo "<script>Swal.fire({
                        icon: 'warning',
                        title: 'Activate Your Account',
                        text: 'Please activate your Account'
                      })</script>";
                    }

                } else {
                    echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Unable to Login',
                    text: 'Please Check Your Credentials'
                  })</script>";
                }

            } else {
                echo "<script>Swal.fire({
                icon: 'warning',
                title: 'Google Recaptcha Error',
                text: 'Something Went Wrong With G-Recaptcha'
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

          <h3 class="breadcrumb font-time mb-3 text-uppercase">Login here</h3>

          <form action="" method="post" onsubmit = "return loginValidation()">

            <div class="form-group">
              <label for="username">Username/ Email</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username/Email">
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter Your Password">
            </div>

            <div class="text-center my-2">
              <div class="g-recaptcha text-center" data-sitekey=<?php echo $recaptchaSiteKey; ?>></div>
            </div>

            <a href="forgotPassword.php" class="text-danger font-sans">Forgot Password?</a>

            <input type="submit" value="Login" name="login" id= "login" class="btn mt-3 btn-primary btn-block rounded-pill">
          </form>

          <p class="my-2 font-sans">Not have an account? <a href="register.php">Create Account here</a></p>

      </section>
    </div>
  </main>

  <?php include_once "includes/footerScripts.php";?>
  <!-- Custom JS -->
  <script src="js/login.js"></script>

</body>

</html>