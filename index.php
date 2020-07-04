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

<body>


  <?php include_once "includes/navbarUser.php";?>

  <main class="container my-5">
    <div class="row">
      <section class="col-md-8">
        <div class="card">
          <div class="card-header" >
            Start Write Here
          </div>
          <div class="card-body">
            <form action="" method="post" id="postForm" name="postForm" >
              <div class="form-group">
                <textarea name="post" id="post" cols="30" rows="3" class="form-control"
                  placeholder="What's happening"></textarea>
              </div>
              <!-- Response Message -->
              <div id="responseMessage"></div>
              <Button type="submit" class="btn btn-primary float-right">Tweet</Button>
            </form>
          </div>
        </div>

        <!--Trending Now-->

        <div class="card mt-5">
          <div class="card-header">
            Trending Now
          </div>
          <div class="card-body">
            <!-- Response Data -->
            <div id="responsePostData"></div>
            <div id="responseComment"></div>
          </div>
        </div>
      </section>

      <section class="col-md-4">

        <div id="responseFollow"></div>
        <div id="responseUnfollow"></div>

        <div class="card">
          <div class="card-header">Who to Follow</div>
          <div class="card-body">
            <!-- Users Profile -->
            <div id="responseUserProfiles"></div>
          </div>

      </section>
    </div>
  </main>

  <!-- include footer script -->
  <?php include_once "includes/footerScripts.php";?>
  <!-- Local JS -->
  <script src="js/index.js"></script>

</body>

</html>