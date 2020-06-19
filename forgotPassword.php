<?php

// Creating Connection to Database
require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password Page</title>

    <!-- header Scripts and Links -->
    <?php include_once "includes/headerScripts.php";?>

</head>

<body>

    <!-- Navbar PHP -->
    <?php include_once "includes/navbarUser.php";?>


    <main class="container">
        <div class="row my-5">
            <section class="col-md-6 offset-md-3 mb-5">
                <div class="card shadow p-5">


                    <h3 class="text-center text-uppercase font-time text-primary mb-3">Forgot Your Password?</h3>

                    <p class="text-center">We get it, stuff happens. Just enter your email address below and we'll send
                        you a link to reset
                        your password!</p>

                    <hr>

                    <form action="" method="POST" id="forgotPasswordForm" name="forgotPasswordForm">
                        <div class="form-group">
                            <label>Enter Your Email</label>
                            <input type="email" name="email" id="email" class="form-control mb-3" placeholder="Email"
                                autocomplete="off">
                        </div>

                        <!-- Response Message by Ajax -->
                        <div id="responseMessage"></div>

                        <input type="submit" value="Submit" name="submit"
                            class="btn btn-primary mt-3 btn-block rounded-pill">

                    </form>

                     <p class="my-2 font-sans">Already Register? <a href="login.php">Please Login here</a></p>
                      <p class="font-sans">Not have an account? <a href="register.php">Create Account here</a></p>
                </div>
            </section>
        </div>
    </main>


    <!-- Footer Script -->
    <?php include_once "includes/footerScripts.php";?>
    <!-- Javascript -->
    <script src="js/forgotPassword.js"></script>

     <?php
// closing Database Connnection
$conn = null;
?>

</body>

</html>