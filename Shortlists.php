<?php
include 'head.php';
session_start();
?>

<body>

  <div class="MineMaps_title">
    <a href="Userpage.php">Home</a>
    <a href="includes/LogOut.php?logout">Logout</a>
  </div>
  <br>

  <?php
  $studentID = $_SESSION['StudentID'];
  $shortlist = array();

  $sql3 = "SELECT * FROM Bookmarks JOIN Posting USING(JobID) JOIN Location USING(LocationID) JOIN Organization USING (OrgID) WHERE StudentID= " . $studentID . ";";
  $shortlistquery = mysqli_query($conn,$sql3);

    while($row = mysqli_fetch_array($shortlistquery)){
      $shortlist[] = array(
        (float) $row['Longitude'], //0
        (float) $row['Latitude'], //1
        $row['Address'], //2
        $row['City'], //3
        $row['ProvinceOrState'], //4
        $row['Region'], //5
        $row['JobTitle'], //6
        $row['Duration'], //7
        $row['OpenPositions'], //8
        $row['DifficultyLevel'], //9
        $row['OrgName'], //10
        $row['WTRating'] //11
      );
    }
  mysqli_close($conn);

  ?>

  <div class="flex-container">
    <div id="map">

      <script>
        var map;
        function initMap() {
          var myLatLng = {
            lat: 43.4723,
            lng: -80.5449
          };
          map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: myLatLng
            });

          var shortlist = <?php echo json_encode($shortlist) ?>;

          var i;
          for(i = 0;i<shortlist.length;i++){
            addMarker({
              coords:{
                lat: shortlist[i][0],
                lng: shortlist[i][1]
              },
              content: '<h3>' + shortlist[i][10] +
                ' (' + shortlist[i][11] + ')</h3><h4>' + shortlist[i][6] +
                 '</h4><h5>Job Duration: ' + shortlist[i][7] +
                 '</h5><h5>Positions Open: ' + shortlist[i][8] +
                 '</h5><h5>Address: ' + shortlist[i][2] +
                 '<h5>City: ' + shortlist[i][3] + ', ' + shortlist[i][4] +
                 '<h5>Region: ' + shortlist[i][5] + '</h5>' +
                 '<button onclick="Unshortlistfunction()">Unshortlist</button>',
              iconImage: 'http://maps.google.com/mapfiles/ms/icons/blue.png'
            });
          }
      }

      function Unshortlist(){

      }

        function addMarker(props) {
          var marker = new google.maps.Marker({
            position:props.coords,
            map:map,
            title: 'Click to View Job'
          });

          if (props.iconImage) {
            marker.setIcon(props.iconImage);
          }

          if (props.content) {
            var infoWindow = new google.maps.InfoWindow({
              content: props.content
            });

            marker.addListener('click', function() {
              infoWindow.open(map, marker);
            });
          }
        }

      </script>

      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzS646oxXO5J1dEr0khC70ANpmGRv2hIA&callback=initMap">
      </script>

    </div>

    </div>


  </div>
  <?php
  include 'Copyright.php';
  ?>

</body>
