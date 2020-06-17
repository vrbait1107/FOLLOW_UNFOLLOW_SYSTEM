<?php
// Creating Database Connection
require_once "../config.php";
session_start();

$userEmail = $_SESSION['user'];

$userId = $_SESSION['userId'];

extract($_POST);

//####################### INSERTING POST

if (isset($_POST['insert'])) {

    $sql = "INSERT INTO post_information (user_id, postContent) VALUES (:userId, :comment)";

    $result = $conn->prepare($sql);
    $result->bindValue(":userId", $userId);
    $result->bindValue(":comment", $comment);

    $result->execute();

    if ($result) {
        echo "<script>Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Your Post Successfully Shared'
            })</script>";

    } else {
        echo "<script>Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'We failed to share your post'
            })</script>";

    }

}

//##################### DISPLAYING POST

if (isset($_POST["readingPostData"])) {

    $sql = "SELECT * FROM user_information INNER JOIN post_information
     ON user_information.user_id = post_information.user_id GROUP BY post_information.post_id
      ORDER BY post_information.post_id DESC";

    $result = $conn->prepare($sql);
    $result->execute();

    if ($result->rowCount() > 0) {

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $profileImage = "";

            if ($row['profileImage'] !== "") {
                $profileImage = '<img src = "profileImage/' . $row['profileImage'] . '" class="img-fluid img-thumbnail"/>';
            } else {
                $profileImage = '<img src = "profileImage/defaultUser.png" class="img-fluid img-thumbnail"/>';
            }

            $data = '<div class= "jumbotron" style = "padding: 24px 30px 24px 30px" >
            <div class="row">
            <div class="col-md-2 col-4">
              ' . $profileImage . '
            </div>

            <div class="col-md-10 col-8">
            <h3><b>@ ' . $row['username'] . '</b></h3>
            <p>' . $row['postContent'] . ' </p>
            </div>
           </div>
            </div>';

            echo $data;
        }

    } else {
        echo '<p>No Data Found</p>';
    }

}

// #################### DISPLAYING USER PROFILES

if (isset($_POST["readingProfiles"])) {

    $sql = "SELECT * FROM user_information WHERE user_id != :userId";

    $result = $conn->prepare($sql);
    $result->bindValue(":userId", $userId);
    $result->execute();

    if ($result->rowCount() > 0) {

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $profileImage = "";

            if ($row["profileImage"] == "") {

                $profileImage = '<div class="col-4">
                <img src = "profileImage/defaultUser.png" class="img-fluid" alt="">
              </div>';

            } else {

                $profileImage = '<div class="col-4">
                <img src = "profileImage/' . $row['profileImage'] . '" class="img-fluid" alt="">
              </div>';

            }

            $data1 = '<div class="row">
            ' . $profileImage . '
                  <div class="col-5">
                <button class="btn btn-small btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>
                  Follow</button>
                  </div>

              <div class="col-3  px-0">
                <p class="bg-success text-white py-1 pt-1">' . $row['followers'] . ' Followers</p>
              </div>
            </div>
            </div>';

            echo $data1;
        }

    } else {
        echo '<p>NO USERS AVAILABLE </p>';
    }
}
