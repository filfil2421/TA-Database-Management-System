<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 3. It allows the user to insert a new teaching assistant with the appropriate data fields. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>Insert New Teaching Assistant</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>    
    <h1>Insert New Teaching Assistant</h1>
    <!-- Form to input new TA information -->
    <form action="insert_ta.php" method="post" id="taForm">
        <label for="tauserid">TA User ID:</label>
        <input type="text" name="tauserid" required><br>

        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required><br>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" required><br>

        <label for="studentnum">Student Number:</label>
        <input type="text" name="studentnum" required><br>

        <label for="degreetype">Degree Type:</label>
        <input type="text" name="degreetype" required><br>

        <label for="imageurl">Image URL:</label>
        <input type="text" name="imageurl"><br>

        <label for="loves">Courses Loved (comma-separated):</label>
        <input type="text" name="loves"><br>

        <label for="hates">Courses Hated (comma-separated):</label>
        <input type="text" name="hates"><br>

        <input type="submit" value="Insert TA">
    </form>
    <?php
        include("connect_database.php");
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tauserid = isset($_POST["tauserid"]) ? $_POST["tauserid"] : "";
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $studentnum = $_POST["studentnum"];
            $degreetype = $_POST["degreetype"];
            $imageurl = isset($_POST["imageurl"]) ? $_POST["imageurl"] : "";
            $loves = isset($_POST["loves"]) ? $_POST["loves"] : "";
            $hates = isset($_POST["hates"]) ? $_POST["hates"] : "";

            // Check if studentnum and tauserid are set
            if (!empty($studentnum) && !empty($tauserid)) {
                // Check if the user already exists based on student number or Western user ID
                $checkUserQuery = mysqli_query($connection, "SELECT * FROM ta WHERE studentnum='$studentnum' OR tauserid='$tauserid'");
                if (mysqli_num_rows($checkUserQuery) > 0) {
                    echo "<p class='error-message'>Error: A TA with the same student number or user ID already exists. Please enter a unique student number and user ID.</p>";
                } else {
                    // Set image to the generic image if no URL is provided
                    if (empty($imageurl)) {
                        $imageurl = "genericprofile.png";
                    }
                    // Insert new TA into the database
                    $insertQuery = mysqli_query($connection, "INSERT INTO ta (tauserid, firstname, lastname, studentnum, degreetype, image) VALUES ('$tauserid', '$firstname', '$lastname', '$studentnum', '$degreetype', '$imageurl')");

                    if ($insertQuery) {
                        echo "<p class='success-message'>New TA added successfully!</p>";
                        // If courses loved are provided, insert them into the loves table.
                        if (!empty($loves)) {
                            $lovesArray = explode(",", $loves);
                            foreach ($lovesArray as $love) {
                                $love = trim($love);
                                mysqli_query($connection, "INSERT INTO loves (ltauserid, lcoursenum) VALUES ('$tauserid', '$love')");
                            }
                        }
                        // If courses hated are provided, insert them into the hates table.
                        if (!empty($hates)) {
                            $hatesArray = explode(",", $hates);
                            foreach ($hatesArray as $hate) {
                                $hate = trim($hate);
                                mysqli_query($connection, "INSERT INTO hates (htauserid, hcoursenum) VALUES ('$tauserid', '$hate')");
                            }
                        }
                    } else {
                        echo "<p class='error-message'>Error: Adding TA failed.</p>";
                    }
                }
            } 
            else {
                echo "<p class='error-message'>Error: A student number and user ID must be inputted.</p>";
            }
            mysqli_close($connection);
        }
    ?>
</body>
</html>