<?php

function Job_level($conn)
{
    $Job_Level = array();
    $sql = "SELECT DISTINCT DifficultyLevel FROM Posting";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $Job_Level[] = $row['DifficultyLevel'];
    }
    return $Job_Level;
}

function Duration($conn)
{
    $Duration = array();
    $sql = "SELECT DISTINCT Duration FROM Posting";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $Duration[] = $row['Duration'];
    }
    return $Duration;
}

function Region($conn)
{
    $Region = array();
    $sql = "SELECT DISTINCT Region FROM Location";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $Region[] = $row['Region'];
    }
    return $Region;
}

function City($conn)
{
    $City = array();
    $sql = "SELECT DISTINCT City FROM Location";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $City[] = $row['City'];
    }
    return $City;
}
function Company($conn)
{
    $Company = array();
    $sql = "SELECT DISTINCT OrgName FROM Organization";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $Company[] = $row['OrgName'];
    }
    return $Company;
}
