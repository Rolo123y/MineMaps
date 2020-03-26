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
        <div class="flex-MineMaps_Userpage">
            <div>
                <span>Hello,</span>
                <span class="Userpage_Username">
                    <?php
                    echo $_SESSION['Username'] . "!";
                    ?>
                </span>
                <h1>What would you like to do?</h1>
            </div>

            <form class="flex_Userpage" action="Postings.php" method="POSt">
                <button type="viewposting" name="viewposting" value="viewposting">View Job Postings</button>
            </form>
            <form class="flex_Userpage" action="Shortlists.php" method="POSt">
                <button type="viewshortlist" name="viewshortlist" value="viewshortlist">My Shortlist</button>
            </form>
        </div>
    </div>

    <?php
    include 'Copyright.php';
    ?>

</body>