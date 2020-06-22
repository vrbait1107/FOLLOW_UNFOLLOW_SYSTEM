<?php
// Creating Database Connection
require_once "../config.php";
session_start();

$userEmail = $_SESSION['user'];

$userId = $_SESSION['userId'];

extract($_POST);

//####################### INSERTING POST

if (isset($_POST['insert'])) {

    $sql = "INSERT INTO post_information (user_id, postContent) VALUES (:userId, :post)";

    $result = $conn->prepare($sql);
    $result->bindValue(":userId", $userId);
    $result->bindValue(":post", $post);

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

    $sql = "SELECT * FROM post_information INNER JOIN user_information ON
    post_information.user_id = user_information.user_id LEFT JOIN follow_information ON
    follow_information.following_id = post_information.user_id WHERE
    post_information.user_id = :userId OR follow_information.followers_id = :userId2
    GROUP BY post_information.post_id
    ORDER BY post_information.post_id DESC";

    $result = $conn->prepare($sql);
    $result->bindValue(":userId", $userId);
    $result->bindValue(":userId2", $userId);
    $result->execute();

    if ($result->rowCount() > 0) {

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $profileImage = "";

            if ($row['profileImage'] == "") {
                $profileImage = '<img src = "profileImage/defaultUser.png" class="img-fluid img-thumbnail"/>';
            } else {
                $profileImage = '<img src = "profileImage/' . $row['profileImage'] . '" class="img-fluid img-thumbnail"/>';
            }

            $data = '<div class= "jumbotron" style = "padding: 24px 30px 24px 30px" >
            <div class="row">

            <div class="col-md-2 col-4">
              ' . $profileImage . '
            </div>

            <div class="col-md-10 col-8">
            <h3><b>@ ' . $row['username'] . '</b></h3>
            <p class="mt-2">' . $row['postContent'] . ' </p>

            <p class="float-right btn btn-link toggleButton" id="' . $row["post_id"] . '">Comment</p>

            <form name="commentForm" style="display:none" id="commentForm' . $row["post_id"] . '" >
            <textarea name="comments" id="comments" class="form-control"
            cols="30" rows="2"></textarea>
            <input type="hidden" name="hiddenPostId" id="hiddenPostId" value= ' . $row["post_id"] . '>
            <button type="button" id="insertComment" class="btn btn-primary btn-small mt-2 float-right">Submit</button>
             </form>

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

            $data1 = '<b class="text-center"><h5>@' . $row["username"] . '</h5> </b> <div class="row">
            ' . $profileImage . '
                  <div class="col-5">
                  ' . make_follow_button($conn, $row['user_id'], $userId) . '
                  </div>

              <div class="col-3  px-0">
                <p class="bg-success text-white py-1 pt-1">' . $row['followers'] . ' Followers</p>
              </div>

            </div>';

            echo $data1;
        }

    } else {
        echo '<p>NO USERS AVAILABLE </p>';
    }
}

// ############################################ FOLLOW USER

if (isset($_POST["follow"])) {

    //Query
    $sql = "INSERT INTO follow_information (following_id, followers_id) VALUES (:followingId, :userId)";

    //Preparing Query
    $result = $conn->prepare($sql);

    //Binding Values
    $result->bindValue(":followingId", $followingId);
    $result->bindValue(":userId", $userId);

    //Executing Query
    $result->execute();

    if ($result) {

        $sql = "UPDATE user_information SET followers = followers + 1 WHERE user_id = $followingId";
        $result = $conn->prepare($sql);
        $result->execute();

    } else {
        echo "Something Went Wrong";
    }
}

// ################################################## UNFOLLOW USER

if (isset($_POST["unfollow"])) {

    //Query
    $sql = "DELETE FROM follow_information WHERE following_id = :followingId AND followers_id = :userId";

    //Preparing Query
    $result = $conn->prepare($sql);

    //Binding Values
    $result->bindValue(":followingId", $followingId);
    $result->bindValue(":userId", $userId);

    //Executing Query
    $result->execute();

    if ($result) {

        $sql = "UPDATE user_information SET followers = followers - 1 WHERE user_id = $followingId";
        $result = $conn->prepare($sql);
        $result->execute();

    } else {
        echo "Something Went Wrong";
    }
}

// ##################################################### FOLLOW UNFOLLOW BUTTON

// Followers Id means User that is login that users id
// Following Id means that Users Id which We Want to Follow

function make_follow_button($conn, $following_id, $followers_id)
{

    $sql = "SELECT * FROM follow_information WHERE following_id = :following_id AND followers_id = :followers_id";

    $result = $conn->prepare($sql);

    $result->bindValue(":following_id", $following_id);
    $result->bindValue(":followers_id", $followers_id);

    $result->execute();

    if ($result->rowCount() > 0) {
        $output = '<button class="btn btn-small btn-primary" id="followingAction" onclick= unfollowUser(' . $following_id . ') >
            Following</button>';
    } else {
        $output = '<button class="btn btn-small btn-primary" id="followAction" onclick= followUser(' . $following_id . ') >
     <i class="fa fa-plus" aria-hidden="true"></i>
            Follow</button>';
    }

    return $output;
}
