<?php
include 'head.php';
?>

<body>
    <div class="MineMaps_title">
        <span>MineMaps</span>
    </div>
    <br>

    <div class="flex-container">
        <div class="flex-MineMaps_SignUp">
            <div>
                <span>Sign up</span>
                <h1>Please fill in this form to create an account!</h1>
            </div>

            <?php
            if (@$_GET['Empty'] == true) {
                echo "<div class=" . '"div_Empty"' . ">";
                echo $_GET['Empty'];
                echo "</div>";
            }
            if (@$_GET['Failed'] == true) {
                echo "<div class=" . '"div_Empty"' . ">";
                echo $_GET['Empty'];
                echo "</div>";
            }
            ?>

            <form class="flex_Signup" action="includes/SignUp.php" method="POST">
                <div>
                    <input type="text" name="firstname" placeholder="First Name">
                    <input type="text" name="lastname" placeholder="Last Name">
                </div>
                <input type="text" name="email" placeholder="Student Email">
                <input type="text" name="studentnumber" placeholder="Student Number">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirmpassword" placeholder="Confirm Password">
                <button type="newuser" name="newuser" value="newuser">Sign Up</button>
            </form>

            <div>
                <a href="index.php">Go back</a>
            </div>
        </div>

    </div>

    <?php
    include 'Copyright.php';
    ?>

</body>