<?php

require_once "config.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location:login.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Follow Unfollow System</title>
  <?php include_once "includes/headerScripts.php";?>
</head>

<body class="sb-nav-fixed">


  <?php include_once "includes/userNavbar.php";?>

  <div id="layoutSidenav_content">

    <main class="container-fluid my-5">
      <div class="row">

        <section class="col-md-8">
          <div class="card">

            <div class="card-header">
              <span> Start Write Here </span>
            </div>

            <div class="card-body">
              <form action="" method="post" id="postForm" name="postForm">
                <!-- Response Message -->
                <div id="responseMessage"></div>
                <div class="form-group">
                  <textarea name="post" id="post" cols="30" rows="3" class="form-control"
                    placeholder="What's happening"></textarea>
                </div>
                <button type="submit" class="btn btn-primary float-right">Tweet</button>

              </form>
            </div>
          </div>

          <!--Trending Now-->

          <div class="card mt-5">
            <div class="card-header">
              Trending Now
            </div>
            <div class="card-body">
              <!-- Ajax Response Data -->
              <div id="responsePostData"></div>
              <div id="responseComment"></div>
              <div id="responseRetweet"></div>
              <div id="responseLike"></div>
            </div>
          </div>
        </section>

        <section class="col-md-4">

          <div id="responseFollow"></div>
          <div id="responseUnfollow"></div>

          <div class="card">
            <div class="card-header">Who to Follow</div>
            <div class="card-body">
              <!-- Ajax Response Users Profile Data-->
              <div id="responseUserProfiles"></div>
            </div>

        </section>
      </div>
    </main>
  </div>

  <!-- include footer script -->
  <?php include_once "includes/footerScripts.php";?>
  <!-- Local JS -->
  <script src="js/index.js"></script>

</body>

</html>