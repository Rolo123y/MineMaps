<?php

$JobID = mysqli_real_escape_string($_GET['JobID'], $conn);
$StudentID = mysqli_real_escape_string($_GET['StudentID'], $conn);

// $sql = "INSERT INTO Bookmarks (StudentID ,JobID ,ShortList) VALUES ('" . $StudentID . "','" . $JobID . "','1');";
// $result = $mysqli_query($conn, $sql);
