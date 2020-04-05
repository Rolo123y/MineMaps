<?php
session_start();

if (isset($_GET['Update'])) {
  header("location: ../Postings.php?Job-level='" . $_GET['Job-level'] . "'&Duration='" . $_GET['Duration'] . "'&Region='" . $_GET['Region'] . "'&City='" .
    $_GET['City'] . "'&Company='" . $_GET['Company'] . "'&Min-Rating=" . $_GET['Min-Rating']);
}

if (isset($_GET['clear'])) {
  header("location: ../Postings.php?");
}

if (isset($_GET['Shortlist_Page'])) {
  header("location: ../Shortlists.php?");
}