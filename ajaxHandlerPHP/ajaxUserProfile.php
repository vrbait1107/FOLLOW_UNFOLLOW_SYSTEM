<?php

// -------------------->> DB CONFIG
require_once "../config/mysqlConfig.php";

session_start();

$userEmail = $_SESSION['user'];

extract($_POST);

extract($_FILES);

//---------------------------->> UPDATE PROFILE IMAGE

if (isset($_FILES['updateProfileImage'])) {

    $image = $_FILES['updateProfileImage'];
    $imageName = $_FILES['updateProfileImage']["name"];
    $imageLocation = $_FILES['updateProfileImage']['tmp_name'];
    $imageSize = $_FILES['updateProfileImage']['size'];

    if ($imageSize > 2097152) {
        echo "<script>Swal.fire({
              icon: 'warning',
              title: 'Warning',
              text: 'Image cannot be larger than 2MB'
            })</script>";

    } else {

        $sql = "UPDATE user_information SET profileImage = :imageName WHERE email= :hiddenEmail1";

        $result = $conn->prepare($sql);

        $result->bindValue(":imageName", $imageName);
        $result->bindValue(":hiddenEmail1", $hiddenEmail1);

        $result->execute();

        if ($result) {
            move_uploaded_file($imageLocation, "C:/xampp/htdocs/follow-unfollow-system/profileImage/" . $imageName);
            echo "<script>Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Your Profile Image Successfully Updated'
            })</script>";

        } else {
            echo "<script>Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'We Failed to Update Your Profile Image'
            })</script>";

        }
    }

}

// ------------------------->> READING RECORD
{
    if (isset($_POST["profileData"])) {

        $sql = "SELECT * FROM user_information WHERE email = :userEmail";

        //Preparing Query
        $result = $conn->prepare($sql);

        //Biding Value
        $result->bindValue(":userEmail", $userEmail);

        //Executing Value
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        $response = json_encode($row);

        echo $response;
    }
}

// --------------------->> UPDATING  PROFILE DATA

if (isset($_POST["hiddenEmail2"])) {

    $updateName = htmlspecialchars($_POST["updateName"]);
    $updateBio = htmlspecialchars($_POST['updateBio']);
    $hiddenEmail2 = htmlspecialchars($_POST["hiddenEmail2"]);

    $sql = "UPDATE user_information SET name = :updateName, bio = :updateBio WHERE email = :hiddenEmail2";

    $result = $conn->prepare($sql);

    $result->bindValue(":updateName", $updateName);
    $result->bindValue(":updateBio", $updateBio);
    $result->bindValue(":hiddenEmail2", $hiddenEmail2);

    $result->execute();

    if ($result) {
        echo "<script>Swal.fire({
              icon: 'success',
              title: 'Successful',
              text: 'Your Profile Data updated Successfully'
            })</script>";

    } else {
        echo "<script>Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'We failed to update your profile data'
            })</script>";

    }

}
