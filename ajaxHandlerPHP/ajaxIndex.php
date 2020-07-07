<?php
// Creating Database Connection
require_once "../config.php";
session_start();

$userEmail = $_SESSION['user'];

$userId = $_SESSION['userId'];

extract($_POST);

//----------------------------------------> INSERTING POST

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

//----------------------------------------> DISPLAYING POST

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

            $repost = "button";

            if ($row['user_id'] === $userId) {
                $repost = "disabled";
            }

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

            <div class="mt-2">
            <span>' . $row['postContent'] . ' </span>
            <hr/>
            <span><button ' . $repost . '   class= "btn btn-danger float-right repostButton"
            data-post_id= ' . $row["post_id"] . '><i class="fa fa-retweet"></i> ' . countRetweet($conn, $row["post_id"]) . '</button></span>

             <span class="float-right btn btn btn-primary mx-2 toggleButton" id="' . $row["post_id"] . '">
             <i class="fa fa-comments"></i> ' . commentCount($conn, $row["post_id"]) . '</span>

             <span class="float-right btn btn-info mx-2 likeButton" data-like_id="' . $row["post_id"] . '">
             <i class="fa fa-thumbs-up"></i> ' . likeCount($conn, $row["post_id"]) . '</span>
            </div>


            <form name="commentForm" style="display:none" id="commentForm' . $row["post_id"] . '" >

            <div id= "oldComments' . $row["post_id"] . '" class="mt-3"></div>

            <textarea name="comments" id="comments' . $row["post_id"] . '" class="form-control"
            cols="30" rows="2"></textarea>

            <button class="btn btn-primary btn-small mt-2 insertComment  float-right">Submit</button>
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

// ---------------------------------------->DISPLAYING USER PROFILES

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

// ----------------------------------------> FOLLOW  USER FUNCTIONALITY

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

// ----------------------------------------> UNFOLLOW USER FUNCTINALITY

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

//-------------------------------------------> COUNT COMMENT

function commentCount($conn, $post_id)
{
    $sql = "SELECT * FROM comment_information WHERE post_id = :postId";

    $result = $conn->prepare($sql);
    $result->bindValue(":postId", $post_id);
    $result->execute();
    $count = $result->rowCount();

    return $count;
}

//----------------------------------------->> COUNT LIKES

function likeCount($conn, $post_id)
{
    $sql = "SELECT * FROM like_information WHERE post_id = :postId";

    $result = $conn->prepare($sql);
    $result->bindValue(":postId", $post_id);
    $result->execute();
    $count = $result->rowCount();

    return $count;
}

//------------------------------------------>> COUNT RETWEEET

function countRetweet($conn, $postId)
{
    $sql = "SELECT * FROM repost_information WHERE post_id = :postId";

    $result = $conn->prepare($sql);
    $result->bindValue(":postId", $postId);
    $result->execute();

    $count = $result->rowCount();

    return $count;
}

// ----------------------------------------> FOLLOW UNFOLLOW BUTTON

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

extract($_POST);

//--------------------------------> INSRTING COMMENT

if (isset($_POST["submitComment"])) {

    $sql = "INSERT INTO comment_information (user_id, post_id, comment) VALUES (:userId, :postId, :comment)";

    // Prepare Query
    $result = $conn->prepare($sql);

    //Binding Values
    $result->bindValue(":userId", $userId);
    $result->bindValue(":postId", $postId);
    $result->bindValue(":comment", $comment);

    //Executing Query
    $result->execute();

}

//---------------------------------------> FETCHING OLD COMMENT TO RESPECTIVE POST

if (isset($_POST['fetchComment'])) {
    $sql = "SELECT * FROM comment_information INNER JOIN user_information ON
comment_information.user_id = user_information.user_id  WHERE
 post_id= :postId ORDER BY comment ASC";

    $result = $conn->prepare($sql);
    $result->bindValue(":postId", $postId);
    $result->execute();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $profileImage = "";

        if ($row["profileImage"] == "") {

            $profileImage = '<img src = "profileImage/defaultUser.png" class="img-fluid rounded-circle" alt="">';

        } else {

            $profileImage = '<img src = "profileImage/' . $row['profileImage'] . '" class="img-fluid rounded-circle" alt="">';

        }

        $data = '<div class="row">

            <div class="col-md-2">
              ' . $profileImage . '
            </div>

            <div class="col-md-10">
            <h6><b>@ ' . $row['username'] . '</b></h6>
            <p class="mt-2">' . $row['comment'] . ' </p>
            </div>
            </div>';

        echo $data;
    }
}

//---------------------------------------->> RETWEET FUNCTIONALITY

if (isset($_POST["retweet"])) {

    $sql1 = "SELECT  * FROM repost_information WHERE post_id = :postId AND user_id = :userId";

    $result1 = $conn->prepare($sql1);

    $result1->bindValue(":postId", $postId);
    $result1->bindValue(":userId", $userId);

    $result1->execute();

    if ($result1->rowCount() > 0) {
        echo "<script>Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Your already reposted this tweet'
            })</script>";

    } else {

        $sql2 = "INSERT INTO repost_information (post_id, user_id) VALUES (:postId ,:userId)";

        $result2 = $conn->prepare($sql2);

        $result2->bindValue(":postId", $postId);
        $result2->bindValue(":userId", $userId);

        if ($result2->execute()) {

            $sql3 = "SELECT * FROM post_information WHERE post_id = :postId";

            $result3 = $conn->prepare($sql3);

            $result3->bindValue(":postId", $postId);

            $result3->execute();

            $row = $result3->fetch(PDO::FETCH_ASSOC);

            $postContent = $row['postContent'];

            $sql4 = "INSERT INTO post_information (user_id, postContent) VALUES (:userId, :post)";

            $result4 = $conn->prepare($sql4);
            $result4->bindValue(":userId", $userId);
            $result4->bindValue(":post", $postContent);

            $result4->execute();

            if ($result4) {
                echo "<script>Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Post Successfully Reposted'
            })</script>";

            } else {
                echo "<script>Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'We failed to repost the tweet'
            })</script>";

            }

        }

    }
}

// ------------------------------------------>> LIKE FUNCTIONALITY

if (isset($_POST["likeButton"])) {

    $sqlLike = "SELECT * FROM like_information WHERE post_id = :postId AND user_id = :userId";

    $resultLike = $conn->prepare($sqlLike);
    $resultLike->bindValue(":postId", $postId);
    $resultLike->bindValue(":userId", $userId);

    $resultLike->execute();

    if ($resultLike->rowCount() > 0) {

        echo "<script>Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'You already liked this tweet'
            })</script>";

    } else {
        $sqlLike1 = "INSERT INTO like_information (post_id, user_id) VALUES (:postId, :userId)";
        $resultLike1 = $conn->prepare($sqlLike1);

        $resultLike1->bindValue(":postId", $postId);
        $resultLike1->bindValue(":userId", $userId);

        $resultLike1->execute();

        if ($resultLike1) {
            echo "<script>Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'You liked tweet'
            })</script>";

        } else {
            echo "<script>Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Failed to like tweet'
            })</script>";
        }

    }
}

//------------------------------------------->> TOOLTIP FOR LIKE FUNCTIONALITY

if (isset($_POST["likedUsersList"])) {
    $sql = "SELECT * FROM user_information INNER JOIN like_information
     ON user_information.user_id = like_information.user_id WHERE post_id = :postId";

    $result = $conn->prepare($sql);
    $result->bindValue(":postId", $postId);
    $result->execute();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $output = '<span>' . $row['username'] . '  </span>';

        echo $output;
    }
}

if (!empty($_FILES)) {

    $fileExtension = strtolower(pathinfo($_FILES["uploadFile"]["name"], PATHINFO_EXTENSION));
    $newFileName = rand() . "." . $fileExtension;

    $sourcePath = $_FILES["uploadFile"]["tmp_name"];
    $targetPath = 'target/' . $_FILES["uploadFile"]["name"];

    if (move_uploaded_file($sourcePath, $targetPath)) {
        if ($fileExtension == "jpg" || $fileExtension = "png") {
            echo '<p><img src= "' . $targetPath . '"  class="image-fluid img-thumbnail" /> </p>';
        }
    }

}
