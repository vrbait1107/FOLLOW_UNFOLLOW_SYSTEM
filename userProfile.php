<?php

// Creating Connection to Database
require_once "config.php";

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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>

    <!-- header Scripts and Links -->
    <?php include_once "includes/headerScripts.php";?>

</head>

<body>

    <!-- Navbar PHP -->
    <?php include_once "includes/navbarUser.php";?>


    <main class="container">

        <h4 class="breadcrumb text-uppercase font-time mt-5">User Profile</h4>

        <div class="row">

            <section class="col-md-3 offset-md-1 my-5">
                <div class="text-center">
                    <img src="" id="showProfileImage" class="img-fluid rounded-circle mb-3" style="height:220px">
                </div>

                <!-- Change Profile Image -->
                <form method="post" enctype="multipart/form-data" id="changeProfileImageForm">

                <!-- Update Response -->
                <div id="updateImageResponse"></div>
                    <div class="form-group">
                        <label>Change Profile Image</label>
                        <input type="file" id="updateProfileImage" class="form-control-file" accept=".jpg, .jpeg, .png"
                            name="updateProfileImage">

                        <input type="hidden" name="hiddenEmail1" id="hiddenEmail1">

                        <input type="submit" value="Change Profile Image" class="btn btn-primary mt-3"
                            id="changeProfileImage">
                    </div>
                </form>
            </section>

            <section class="col-md-5 my-5 offset-md-2">

                <form action="" method="post" name="userProfileForm" id="userProfileForm">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="updateName" id="updateName">
                    </div>

                    <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea name = "updateBio"  cols="30" rows="3" id = "updateBio" class="form-control"></textarea>
                    </div>

                    <input type="hidden" name="hiddenEmail2" id="hiddenEmail2">

                    <input type="submit" value="Update" name="updateUserProfile" id="updateUserProfile"
                        class="btn btn-primary btn-block rounded-pill">

                    <div id="updateResponse"></div>

                </form>

            </section>
        </div>
    </main>


    <!-- Footer Script -->
    <?php include_once "includes/footerScripts.php";?>
    <!-- Custom JS -->
    <script src="js/userProfile.js"></script>


    <?php
// closing Database Connnection
$conn = null;
?>

</body>

</html>