<?php
session_start();
include_once "dbconnect.php";

if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['Password'])) {
        header("Location: ../Login.php?Empty=Please fill in empty fields");
    } else {
        LogInCheck($_POST['email'], $_POST['Password'], $conn);
    }
}

function LogInCheck($email, $Password, $conn)
{
    $email_ = mysqli_real_escape_string($conn, $email);
    $Password_ = mysqli_real_escape_string($conn, $Password);

    $sql = "SELECT * FROM User where StudentEmail='" . $email_ . "' AND StudentPass='" . $Password_ . "';";
    $result = mysqli_query($conn, $sql);
    $resulCheck = mysqli_num_rows($result);

    if ($resulCheck > 0 && $resulCheck < 2) {
        while ($row = mysqli_fetch_array($result)) {
            $firstname = $row['FirstName'];
            $studentID = $row['StudentID'];
        }
        $_SESSION['FirstName'] = strtoupper($firstname);
        $_SESSION['StudentID'] = $studentID;

        header("Location: ../Userpage.php?Login=success?FirstName=" . $firstname);
    } else {
        header("Location: ../Login.php?Empty=email or password incorrect. Try again!");
    }
}
