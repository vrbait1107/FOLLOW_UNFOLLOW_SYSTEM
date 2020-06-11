<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <?php include_once "includes/headerScripts.php";?>
</head>

<body>

<!-- Navbar -->
<?php include_once "includes/navbarLogin.php";?>

  <main class="container my-5">
    <div class="row">
      <section class="col-md-6 offset-md-3">

          <h3 class="breadcrumb font-time mb-3 text-uppercase">Login here</h3>

          <form action="" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username">
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter Your Password">
            </div>

            <input type="submit" value="Login" class="btn btn-primary btn-block rounded-pill">
          </form>

          <p class="my-2 font-sans">Not have an account? <a href="register.php">Create Account here</a></p>

      </section>
    </div>
  </main>

</body>

</html>