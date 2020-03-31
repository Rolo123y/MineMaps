<?php
include 'head.php';
session_start();
?>

<body>
    <div class="MineMaps_title">
        <a href="UserPage.php">Home</a>
        <a href="includes/LogOut.php?logout">Logout</a>
    </div>
    <br>

    <div class="flex-container">
        <div id="map"></div>
        <script>
            function initMap() {
                var options = {
                    zoom: 8,
                    center: {
                        lat: 43.4723,
                        lng: -80.5449
                    }
                }
                var map = new google.maps.Map(document.getElementById('map'), options);
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>

    </div>

    <?php
    include 'Copyright.php';
    ?>

</body>