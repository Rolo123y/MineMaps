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
  if (
    @isset($_GET['Job-level']) == true && @isset($_GET['Duration']) == true && @isset($_GET['Region']) == true && @isset($_GET['City']) == true
    && @isset($_GET['Company']) == true && @isset($_GET['Min-Rating']) == true
  ) {
    $shortlist = array();
    $otherjobs = array();

    $Joblevel = $_GET['Job-level'];
    if (strpos($Joblevel, "ALL") == true) {
      $Joblevel = "DifficultyLevel";
    }
    $Duration = $_GET['Duration'];
    if (strpos($Duration, "ALL") == true) {
      $Duration = "Duration";
    }
    $Region = $_GET['Region'];
    if (strpos($Region, "ALL") == true) {
      $Region = "Region";
    }
    $City = $_GET['City'];
    if (strpos($City, "ALL") == true) {
      $City = "City";
    }
    $OrgName = $_GET['Company'];
    if (strpos($OrgName, "ALL") == true) {
      $OrgName = "OrgName";
    }
    $WTRating = $_GET['Min-Rating'];

    $sql5 = "SELECT DISTINCT * FROM Posting JOIN Location USING(LocationId) JOIN Organization USING(OrgID) WHERE JobID NOT IN(SELECT JobID FROM Bookmarks JOIN Posting USING(JobID) WHERE StudentID=" . $studentID . ")" . " AND DifficultyLevel LIKE " . $Joblevel . " AND Duration LIKE " . $Duration . " AND Region LIKE " . $Region . " AND City LIKE " . $City . " AND OrgName LIKE " . $OrgName . " AND WTRating >" . $WTRating . ";";
    $otherjobsquery = mysqli_query($conn, $sql5);
    $otherjobsqueryCheck = mysqli_num_rows($otherjobsquery);
    if ($otherjobsqueryCheck <= 0) {
      echo "Other jobs query returns nothing";
    }

    while ($row = mysqli_fetch_array($otherjobsquery)) {
      $otherjobs[] = array(
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

    $sql6 = "SELECT * FROM Bookmarks JOIN Posting USING(JobID) JOIN Location USING(LocationID) JOIN Organization USING (OrgID) WHERE StudentID= " . $studentID ." AND DifficultyLevel LIKE " . $Joblevel . " AND Duration LIKE " . $Duration . " AND Region LIKE " . $Region . " AND City LIKE " . $City . " AND OrgName LIKE " . $OrgName . " AND WTRating >" . $WTRating . ";";
    $shortlistquery = mysqli_query($conn, $sql6);
    $shortlistqueryCheck = mysqli_num_rows($shortlistquery);
    //if ($shortlistqueryCheck <= 0) {
      //echo "Shortlist query returns nothing";
    //}

    while ($row = mysqli_fetch_array($shortlistquery)) {
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

  } else {
    $shortlist = array();
    $otherjobs = array();

    $sql3 = "SELECT * FROM Bookmarks JOIN Posting USING(JobID) JOIN Location USING(LocationID) JOIN Organization USING (OrgID) WHERE StudentID= " . $studentID . ";";
    $shortlistquery = mysqli_query($conn, $sql3);

    while ($row = mysqli_fetch_array($shortlistquery)) {
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

    $sql4 = "SELECT DISTINCT * FROM Posting JOIN Location USING (LocationID) JOIN Organization USING (OrgID) WHERE JobID NOT IN (SELECT JobID FROM Bookmarks JOIN Posting USING(JobID) WHERE StudentID = " . $studentID . ")";
    $otherjobsquery = mysqli_query($conn, $sql4);

    while ($row = mysqli_fetch_array($otherjobsquery)) {
      $otherjobs[] = array(
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
        $row['WTRating'], //11
        $row['JobID'], //12
        $_SESSION['StudentID']//13
      );
    }
    mysqli_close($conn);
  }

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
          var otherjobs = <?php echo json_encode($otherjobs) ?>;

          var i;
          for (i = 0; i < shortlist.length; i++) {
            addMarker({
              coords: {
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
          var j;
          for (j = 0; j < otherjobs.length; j++) {
            addMarker({
              coords: {
                lat: otherjobs[j][0],
                lng: otherjobs[j][1]
              },
              content: '<h3>' + otherjobs[j][10] +
                ' (' + otherjobs[j][11] + ')</h3><h4>' + otherjobs[j][6] +
                '</h4><h5>Job Duration: ' + otherjobs[j][7] +
                '</h5><h5>Positions Open: ' + otherjobs[j][8] +
                '</h5><h5>Address: ' + otherjobs[j][2] +
                '<h5>City: ' + otherjobs[j][3] + ', ' + otherjobs[j][4] +
                '<h5>Region: ' + otherjobs[j][5] + '</h5>'+
                '<button onclick="Shortlistfunction('+otherjobs[j][13]+','+otherjobs[j][12]+')">Shortlist</button>',
              iconImage: 'http://maps.google.com/mapfiles/ms/icons/red.png'
            });
          }
          alert('Map Successfully Loaded');
        }

        function addMarker(props) {
          var marker = new google.maps.Marker({
            position: props.coords,
            map: map,
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

        function Shortlistfunction(StudentID,JobID)
        {

          $.ajax({
            url:"includes/Shortlistscript.php",
            type:'GET',
            data:'StudentID='+StudentID+'&JobID='+JobID,
            success: function(output){
              alert('Added to Shortlist'+output);
            },error: function()
            {
              alert('shortlist failed: JobID: '+JobID);
            }
          });
        }
        function Unshortlistfunction(StudentID,JobID)
        {

          $.ajax({
            url:"includes/Shortlistscript.php",
            type:'GET',
            data:'StudentID='+StudentID+'&JobID='+JobID,
            success: function(output){
              alert('Removed from Shortlist '+output);
            },error: function()
            {
              alert('unshortlist failed: JobID: '+JobID);
            }
          });
        }

      </script>

        <!-- INSERT API KEY BETWEEN THE CHARACTERS '=' AND '&' WHERE IT SAYS 'YOUR_API_KEY_HERE' -->
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initMap">
      </script>

    </div>

    <div class="Postings_constraints_container">

      <form action="includes/User_Inputs.php" class="Constraints_form" method="GET">

        <h1 class="header">Add Filter</h1>

        <div>
          <span>Search for a Job-level</span>
          <select id="Job-level" name="Job-level" required>
            <option value="ALL">ALL</option>
          </select>
        </div>

        <div>
          <span>Search for a Duration</span>
          <select id="Duration" name="Duration" required>
            <option value="ALL">ALL</option>
          </select>
        </div>

        <div>
          <span>Search for a Region</span>
          <select id="Region" name="Region" required>
            <option value="ALL">ALL</option>
          </select>
        </div>

        <div>
          <span>Search for a City</span>
          <select id="City" name="City" required>
            <option value="ALL">ALL</option>
          </select>
        </div>

        <div>
          <span>Search for a company</span>
          <select id="Company" name="Company" required>
            <option value="ALL">ALL</option>
          </select>
        </div>

        <div class="Company-Rating">
          <span>Minimum Company Rating
            <select id="Min-Rating" name="Min-Rating" required>
              <option value="1.0">1.0</option>
              <option value="2.0">2.0</option>
              <option value="3.0">3.0</option>
              <option value="4.0">4.0</option>
              <option value="5.0">5.0</option>
              <option value="6.0">6.0</option>
              <option value="7.0">7.0</option>
              <option value="8.0">8.0</option>
              <option value="9.0">9.0</option>
            </select></span>
        </div>
        <div>
          <button id="Shortlist_Page" name="Shortlist_Page">View Shortlisted only</button>
        </div>

        <div>
          <button id="Update" name="Update">Update</button>
          <button id="clear" name="clear">clear constraints</button>
        </div>

      </form>

    </div>


  </div>
  <?php
  include 'Copyright.php';
  ?>

</body>
