<?php

/// -------------------->> DB CONFIG
require_once "config/mysqlConfig.php";

// Staring Session
session_start();

if (!isset($_SESSION['user'])) {
    header("location:login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>

    <!-- header Scripts and Links -->
    <?php include_once "includes/headerScripts.php";?>

</head>


<body>

    <!-- Navbar PHP -->
    <?php include_once "includes/userNavbar.php";?>

<div id="layoutSidenav_content">
    <main class="container">
        <div class="row">
            <section class="col-md-6 my-5 offset-md-3">

                <ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-password-tab" data-toggle="pill" href="#pills-password"
                            role="tab" aria-controls="pills-password" aria-selected="false">Password</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-email-tab" data-toggle="pill" href="#pills-email" role="tab"
                            aria-controls="pills-email" aria-selected="false">Email Address</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" id="pills-delete-tab" data-toggle="pill" href="#pills-delete" role="tab"
                            aria-controls="pills-delete" aria-selected="false">Delete Account</a>
                    </li>

                </ul>

                <!-- #### Change Password -->

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-password" role="tabpanel"
                        aria-labelledby="pills-password-tab">

                        <section class="mt-5">
                            <h3 class="text-center font-time font-weight-bold text-uppercase">
                                Change Password
                            </h3>

                            <hr>

                            <form action="" method="post">

                                <!-- Change Password Response -->
                                <div id="changePasswordResponse"></div>

                                <div class="form-group">
                                    <label>Enter Current Password</label>
                                    <input type="password" class="form-control" name="currentPassword"
                                        id="currentPassword">
                                </div>

                                <div class="form-group">
                                    <label>Enter New Password</label>
                                    <input type="password" class="form-control" name="newPassword" id="newPassword">
                                </div>

                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" class="form-control" name="conNewPassword"
                                        id="conNewPassword">
                                </div>

                                <button type="submit" class="btn btn-danger mt-3 rounded-pill btn-block"
                                    name="changePassword" id="changePassword">
                                    Change Password
                                </button>

                            </form>
                        </section>
                    </div>

                    <!-- ## Change Email Address -->

                    <div class="tab-pane fade" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab">

                        <section>
                            <h3 class="text-center font-time mt-5">YOUR EMAIL ADDRESS</h3>
                            <h5 class="text-center"><?php echo $_SESSION['user']; ?></h5>


                            <h3 class="font-time mt-5 text-uppercase text-center">Change Email address
                            </h3>

                            <hr>

                            <form action="" method="post">

                                <!-- Change Email Response -->
                                <div id="changeEmailResponse"></div>

                                <div class="form-group">
                                    <label>Enter a new email address</label>
                                    <input type="email" name="newEmail" id="newEmail" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Confirm to change email address by entering Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>

                                <input type="submit" class="btn btn-danger btn-block rounded-pill" name="changeEmail"
                                    id="changeEmail" value="Change my email Address">

                            </form>
                        </section>
                    </div>

                    <!-- ### Delete Account -->

                    <div class="tab-pane fade" id="pills-delete" role="tabpanel" aria-labelledby="pills-delete-tab">

                        <h3 class="text-center mt-5"><?php echo $_SESSION['username']; ?>, we’re sorry to see you go
                        </h3>

                        <hr />

                        <p>Deleting your account will remove your all data, It permanently delete your account
                            deleting your account cannot be undone.</p>


                        <form>

                            <!-- Delete Account Response -->
                            <div id="deleteAccountResponse"></div>

                            <div class="form-group">
                                <input type="button" value="Delete Your Account" name="deleteAccount" id="deleteAccount"
                                    class="btn btn-danger btn-block rounded-pill mt-3">
                            </div>
                        </form>

                    </div>



                </div>

            </section>
        </div>
    </main>
    </div>


    <!-- Footer Script -->
    <?php include_once "includes/footerScripts.php";?>
    <!-- Custom JS Script -->
    <script src="js/userAccount.js"></script>

    <?php
// closing Database Connnection
$conn = null;
?>

</body>

</html>