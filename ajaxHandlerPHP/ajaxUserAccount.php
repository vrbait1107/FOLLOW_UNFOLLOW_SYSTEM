<?php

// -------------------->> DB CONFIG
require_once "../config/mysqlConfig.php";

// -------------------->> START SESSION
session_start();

// -------------------->> USER SESSION VARIABLE

$userId = $_SESSION['userId'];

// Extracting Post data
extract($_POST);

try {

// -------------------->> CHANGE PASSWORD

    if (isset($_POST['changePassword'])) {

        $userId = $_SESSION['userId'];

        # Query
        $sql = "SELECT password FROM user_information WHERE user_id = :userId";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Values
        $result->bindValue(":userId", $userId);

        # Executing Query
        $result->execute();

        # Fetching Value in associative array
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $dbPassword = $row['password'];

        if (password_verify($currentPassword, $dbPassword)) {

            if ($newPassword === $conNewPassword) {

                $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                # Query
                $sql1 = "UPDATE user_information SET password= :newPassword WHERE user_id = :userId";

                # Preparing Query
                $result1 = $conn->prepare($sql1);

                # Binding Values
                $result1->bindValue(":newPassword", $newPassword);
                $result1->bindValue(":userId", $userId);

                # Executing Query
                $result1->execute();

                if ($result1) {
                    echo "<script>Swal.fire({
                    icon: 'success',
                    title: 'Successful',
                    text: 'Your Password is Successfully Changed'
                    })</script>";

                } else {
                    echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'We are failed to change Password'
                    })</script>";
                }

            } else {
                echo "<script>Swal.fire({
                icon: 'warning',
                title: 'Field does not match',
                text: 'New Password and Confirm New Password field are not matching'
                })</script>";
            }

        } else {
            echo "<script>Swal.fire({
            icon: 'warning',
            title: 'Check Credentials',
            text: 'Current Password is not Correct'
            })</script>";
        }

    }

// -------------------->>  CHANGE EMAIL ADDRESS

    if (isset($_POST['changeEmail'])) {

        $userId = $_SESSION['userId'];

        # Query
        $sql = "SELECT * FROM user_information WHERE user_id = :userId";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Value
        $result->bindValue(":userId", $userId);

        # Executing Query
        $result->execute();

        $sql = "SELECT * FROM user_information WHERE user_id = :userId";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Value
        $result->bindValue(":userId", $userId);

        # Executing Query
        $result->execute();

        # Fetching Values in associative array
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $dbPassword = $row['password'];

        if (password_verify($password, $dbPassword)) {

            # sql Query
            $sql = "UPDATE user_information SET email = :newEmail WHERE user_id = :userId";

            # Preparing Query
            $result = $conn->prepare($sql);

            # Binding Values
            $result->bindValue(":newEmail", $newEmail);
            $result->bindValue(":userId", $userId);

            # Executing Query
            $result->execute();

            if ($result) {
                echo "<script>Swal.fire({
            icon: 'success',
            title: 'Successful',
            text: 'Your Email Successfully Changed'
            })</script>";
            }

        } else {
            echo "<script>Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Check Your Password to Change your Email please enter valid password '
            })</script>";
        }

    }

// -------------------->> DELETE ACCOUNT

    if (isset($_POST['deleteAccount'])) {

        $userId = $_SESSION['userId'];

        # sql Query
        $sql = "DELETE FROM user_information WHERE user_id = :userId";

        # Preparing Query
        $result = $conn->prepare($sql);

        # Binding Value
        $result->bindValue(":userId", $userId);

        # Executing Query
        $result->execute();

        if ($result) {
            echo "<script>Swal.fire({
            icon: 'success',
            title: 'sucess',
            text: 'Your Account is Successfully Deleted'
            })</script>";
        }
    }

} catch (PDOException $e) {
    echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
    # Development Purpose Error Only
    echo "Error " . $e->getMessage();

}

// closing Database Connnection
$conn = null;
