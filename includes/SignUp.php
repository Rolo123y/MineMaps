<?php
include_once 'dbconnect.php';

if (isset($_POST['newuser'])) {
    if (
        empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['studentnumber'])
        || empty($_POST['password']) || empty($_POST['confirmpassword'])
    ) {
        header("Location: ../Signup.php?Empty=Please fill in empty fields!");
    } else if ($_POST['password'] != $_POST['confirmpassword']) {
        header("Location: ../Signup.php?Empty=Passwords do not match!");
    } else {
        SignupCheck($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['studentnumber'], $_POST['password'], $conn);
    }
}

function SignupCheck($firstname, $lastname, $email, $studentnumber, $password, $conn)
{
    $firstname_ = mysqli_real_escape_string($conn, $firstname);
    $lastname_ = mysqli_real_escape_string($conn, $lastname);
    $email_ = mysqli_real_escape_string($conn, $email);
    $studentnumber_ = mysqli_real_escape_string($conn, $studentnumber);
    $password_ = mysqli_real_escape_string($conn, $password);

    $sql = "INSERT INTO users (user_first,user_last,user_email,user_uid,user_pwd)
        VALUES ('$firstname_','$lastname_','$email_','$studentnumber_','$password_');";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ../index.php?signup=success");
    } else {
        header("Location: ../Signup.php?Failed=Failed to signup");
    }
}
