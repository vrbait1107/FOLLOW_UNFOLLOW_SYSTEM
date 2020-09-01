<?php
// -------------------->> DB CONFIG
require_once "../config/mysqlConfig.php";

session_start();

$userEmail = $_SESSION['user'];

$userId = $_SESSION['userId'];

extract($_POST);
extract($_FILES);

//----------------------------------------> INSERTING POST

if (isset($_POST['insert'])) {

    $uploadImageName = $_FILES['uploadImage']['name'];
    $uploadImageDir = $_FILES['uploadImage']['tmp_name'];

    $post = $_POST['post'];

    if ($post !== "" && $uploadImageName == "") {

        $sql = "INSERT INTO post_information (user_id, postContent, postImage) VALUES (:userId, :post, :postImage)";

        $result = $conn->prepare($sql);
        $result->bindValue(":userId", $userId);
        $result->bindValue(":post", $post);
        $result->bindValue(":postImage", "");

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

    } elseif ($post == "" && $uploadImageName !== "") {

        $uploadImageNameNew = rand(11111, 99999) . $uploadImageName;

        move_uploaded_file($uploadImageDir, "C:/xampp/htdocs/follow-unfollow-system/images/" . $uploadImageNameNew);

        $sql = "INSERT INTO post_information (user_id, postContent, postImage) VALUES (:userId, :post, :postImage)";

        $result = $conn->prepare($sql);
        $result->bindValue(":userId", $userId);
        $result->bindValue(":post", "");
        $result->bindValue(":postImage", $uploadImageNameNew);

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

    } elseif ($post !== "" && $uploadImageName !== "") {

        $uploadImageNameNew = rand(11111, 99999) . $uploadImageName;

        move_uploaded_file($uploadImageDir, "C:/xampp/htdocs/follow-unfollow-system/images/" . $uploadImageNameNew);

        $sql = "INSERT INTO post_information (user_id, postContent, postImage) VALUES (:userId, :post, :postImage)";

        $result = $conn->prepare($sql);
        $result->bindValue(":userId", $userId);
        $result->bindValue(":post", $post);
        $result->bindValue(":postImage", $uploadImageNameNew);

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

    } else {
        echo "<script>Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Tweet Cannot Be Empty'
            })</script>";
    }

}

//----------------------------------------> DELETING POST

if (isset($_POST['postDelete'])) {

    $sql = "DELETE FROM post_information WHERE user_id = :userId AND post_id = :postId";

    $result = $conn->prepare($sql);
    $result->bindValue(":userId", $userId);
    $result->bindValue(":postId", $postId);

    $result->execute();

    if ($result) {
        echo "<script>Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Your Post Successfully Deleted'
            })</script>";

    } else {
        echo "<script>Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'We failed to delete your post'
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

            $deleteIcon = "";

            if ($row['user_id'] === $userId) {
                $deleteIcon = "<i  style= 'font-size:20px' class= 'fa fa-trash text-danger
                float-right my-2' onclick = 'deletePost($row[post_id])'></i>";
            }

            $postImage = "";

            if ($row["postImage"] !== "") {
                $img = $row['postImage'];
                $postImage = '<img src= "images/' . $img . '" class="img-fluid my-2" alt="' . $img . '">';
            }

            $profileImage = "";

            if ($row['profileImage'] == "") {
                $profileImage = '<img src = "profileImage/defaultUser.png" class="img-fluid rounded-circle"/>';
            } else {
                $profileImage = '<img src = "profileImage/' . $row['profileImage'] . '" class="img-fluid rounded-circle"/>';
            }

            $data = '<div class= "jumbotron" style = "padding: 24px 30px 24px 30px" >

            ' . $deleteIcon . '

            <div class="row">

            <div class="col-md-2 col-4">
              ' . $profileImage . '
            </div>

            <div class="col-md-10 col-8">
            <h3><b>@ ' . $row['username'] . '</b></h3>

            <div class="my-2">
            <span class="dbPostContent">' . $row['postContent'] . ' </span>

            <hr/>

             ' . $postImage . '

            ' . retweet_untweet_function($conn, $row["post_id"], $userId) . '

             <span style= "font-size: 20px" class="float-right mx-2 toggleButton mb-2" id="' . $row["post_id"] . '">
             <i class="fa fa-comment-o"></i> ' . commentCount($conn, $row["post_id"]) . '</span>

             ' . like_unlike_function($conn, $row["post_id"], $userId) . '

            </div>


            <form name="commentForm" style="display:none" id="commentForm' . $row["post_id"] . '" >

            <div class="row">
            <div id= "oldComments' . $row["post_id"] . '" class="mt-3">
            </div>
            </div>

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

// ------------------------------------------>> LIKE FUNCTIONALITY

if (isset($_POST["likeButton"])) {

    $sql = "INSERT INTO like_information (post_id, user_id) VALUES (:postId, :userId)";
    $result = $conn->prepare($sql);

    $result->bindValue(":postId", $postId);
    $result->bindValue(":userId", $userId);

    $result->execute();
}

// ------------------------------------------>> UNLIKE FUNCTIONALITY

if (isset($_POST["unlikeButton"])) {

    $sql = "DELETE FROM like_information WHERE post_id = :postId AND user_id = :userId";
    $result = $conn->prepare($sql);

    $result->bindValue(":postId", $postId);
    $result->bindValue(":userId", $userId);

    $result->execute();
}

//---------------------------------------->> RETWEET FUNCTIONALITY

if (isset($_POST["retweet"])) {

    $sql = "INSERT INTO repost_information (post_id, user_id) VALUES (:postId, :userId)";

    $result = $conn->prepare($sql);

    $result->bindValue(":postId", $postId);
    $result->bindValue(":userId", $userId);

    if ($result->execute()) {

        $sql1 = "SELECT * FROM post_information WHERE post_id = :postId";

        $result1 = $conn->prepare($sql1);

        $result1->bindValue(":postId", $postId);

        $result1->execute();

        $row = $result1->fetch(PDO::FETCH_ASSOC);

        $postContent = $row['postContent'];
        $postImage = $row['postImage'];

        if ($postImage == "") {
            $postImage = "";
        }

        $sql2 = "INSERT INTO post_information (user_id, postContent, postImage) VALUES (:userId, :post, :postImage)";

        $result2 = $conn->prepare($sql2);
        $result2->bindValue(":userId", $userId);
        $result2->bindValue(":post", $postContent);
        $result2->bindValue("postImage", $postImage);

        $result2->execute();

    }

}

//---------------------------------------->> UNTWEET FUNCTIONALITY

if (isset($_POST["untweet"])) {

    $sql = "DELETE FROM repost_information WHERE post_id = :postId AND user_id = :userId";

    $result = $conn->prepare($sql);

    $result->bindValue(":postId", $postId);
    $result->bindValue(":userId", $userId);

    if ($result->execute()) {

        $sql1 = "SELECT * FROM post_information WHERE post_id = :postId";

        $result1 = $conn->prepare($sql1);

        $result1->bindValue(":postId", $postId);

        $result1->execute();

        $row = $result1->fetch(PDO::FETCH_ASSOC);

        $postContent = $row['postContent'];

        $sql2 = "DELETE FROM post_information WHERE user_id = :userId AND  postContent = :post";

        $result2 = $conn->prepare($sql2);

        $result2->bindValue(":userId", $userId);
        $result2->bindValue(":post", $postContent);

        $result2->execute();

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

// ----------------------------------------> FOLLOW UNFOLLOW FUNCTIONALITY

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

// ----------------------------------------> LIKE UNLIKE FUNCTIONALITY

function like_unlike_function($conn, $postId, $userId)
{

    $sql = "SELECT * FROM like_information WHERE post_id = :postId AND user_id = :userId";

    $result = $conn->prepare($sql);

    $result->bindValue(":postId", $postId);
    $result->bindValue(":userId", $userId);

    $result->execute();

    if ($result->rowCount() > 0) {

        $output = '<span style= "font-size: 20px" class="float-right text-danger mx-2 mb-2 likeButton" data-like_id ="' . $postId . '">
        <i class="fa fa-heart"  onclick= unlikePost(' . $postId . ')></i> ' . likeCount($conn, $postId) . '</span>';

    } else {
        $output = '<span style= "font-size: 20px" class="float-right mx-2 mb-2 likeButton" data-like_id ="' . $postId . '">
             <i class="fa fa-heart-o" onclick= likePost(' . $postId . ') ></i> ' . likeCount($conn, $postId) . '</span>';

    }

    return $output;
}

// ----------------------------------------> RETWEET UNTWEET FUNCTIONALITY

function retweet_untweet_function($conn, $postId, $userId)
{
    $sql = "SELECT * FROM repost_information WHERE post_id = :postId AND user_id = :userId";

    $result = $conn->prepare($sql);

    $result->bindValue(":postId", $postId);
    $result->bindValue(":userId", $userId);

    $result->execute();

    if ($result->rowCount() > 0) {

        $output = '<span class="mb-2 mx-2 float-right repostButton text-success" style="font-size:20px">
        <i class="fa fa-retweet" onclick= untweet(' . $postId . ') ></i>
             ' . countRetweet($conn, $postId) . '</span>';

    } else {
        $output = '<span class="mb-2 mx-2 float-right repostButton" style="font-size:20px">
        <i class="fa fa-retweet" onclick= retweet(' . $postId . ')></i>
             ' . countRetweet($conn, $postId) . '</span>';
    }

    return $output;
}

//----------------------------------------->> INSRTING COMMENT

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

//----------------------------------------->> FETCHING OLD COMMENT TO RESPECTIVE POST

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

        $data = '
            <div class="row">
            <div class="col-2">
              ' . $profileImage . '
            </div>

            <div class="col-10">
            <h6><b>@ ' . $row['username'] . '</b></h6>
            <p class="mt-2">' . $row['comment'] . ' </p>
            </div>
            </div>';

        echo $data;
    }
}

//----------------------------------------->> TOOLTIP FOR LIKE FUNCTIONALITY

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
