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
          <div class="card-header">
            Start Write Here
          </div>
          <div class="card-body">
            <form action="" method="post" id="commentForm" name="commentForm">
              <div class="form-group">
                <textarea name="comment" id="comment" cols="30" rows="3" class="form-control"
                  placeholder="Write your story"></textarea>
              </div>
              <!-- Response Message -->
              <div id="responseMessage"></div>
              <Button type="submit" class="btn btn-primary float-right">Share</Button>
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
          </div>
        </div>
      </section>

      <section class="col-md-4">

        <div class="card">
          <div class="card-header">Users List</div>
          <div class="card-body">

            <div class="row">
              <div class="col-4">
                <img src="images/developer1.jpg" class="img-fluid" alt="">
              </div>

              <div class="col-5">
                <button class="btn btn-small btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>
                  Follow</button>
              </div>

              <div class="col-3  px-0">
                <p class="bg-success text-white py-1 pt-1">0 Followers</p>
              </div>
            </div>

          </div>
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