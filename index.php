<?php

// -------------------->> DB CONFIG
require_once "config/mysqlConfig.php";

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

  // Including Navbar
  <?php include_once "includes/userNavbar.php";?>

  <div id="layoutSidenav_content">

    <main class="container-fluid my-5">
      <div class="row">
        <section class="col-md-8">
          <!-- Response Message -->
          <div id="responseMessage"></div>

          <div class="card">

            <form action="" method="post" id="postForm" name="postForm" enctype="multipart/form-data">
              <div class="card-header">
                <span> Start Write Here </span>
                <div class="form-group float-right">
                  <label for="uploadImage"><i class="fa fa-upload"></i></label>
                  <input type="file" class="form-control-file" name="uploadImage" id="uploadImage"
                    accept=".jpg,.png,.jpeg" style="display: none;" onchange="loadImg(event)">
                </div>
              </div>

              <div class="card-body">

                <img id="frame" class="img-fluid" />

                <div class="form-group">
                  <textarea name="post" id="post" cols="30" rows="3" class="form-control"
                    placeholder="What's happening"></textarea>
                </div>

                <input type="hidden" name="insert" id="insert" value="insert">

                <button type="submit" class="btn btn-primary float-right mb-3">Tweet</button>

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
          <div id="responseDelete"></div>
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