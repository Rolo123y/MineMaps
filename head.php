<?php
include_once 'includes/dbconnect.php';
include 'includes/Fill_Filters.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineMaps</title>
    <link rel="shortcut icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="style.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var Job_Level = <?php echo json_encode(Job_level($conn)) ?>;
            var Duration = <?php echo json_encode(Duration($conn)) ?>;
            var Region = <?php echo json_encode(Region($conn)) ?>;
            var City = <?php echo json_encode(City($conn)) ?>;
            var Company = <?php echo json_encode(Company($conn)) ?>;

            $("#Job-level").select2({
                data: Job_Level
            });
            $("#Duration").select2({
                data: Duration
            });
            $("#Region").select2({
                data: Region
            });
            $("#City").select2({
                data: City
            });
            $("#Company").select2({
                data: Company
            });

        });
    </script>

</head>