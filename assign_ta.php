<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 6. It allows the user to assign a TA to a course if allowed. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>Assign TA</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>    
    <h1>Assign Teaching Assistant to a Course Offering</h1>
    <?php
        include("connect_database.php");
        // Checks if the form is submitted.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tauserid = $_POST["tauserid"];
            $coid = $_POST["coid"];
            $hours = $_POST["hours"];

            // Check if the TA assignment already exists.
            $checkAssignmentQuery = mysqli_query($connection, "SELECT * FROM hasworkedon WHERE tauserid='$tauserid' AND coid='$coid'");
            if (mysqli_num_rows($checkAssignmentQuery) > 0) {
                echo "<p class='error-message'>Warning: This TA is already assigned to the course offering you selected.</p>";
            } else {
                // Creates the assignment.
                $insertAssignmentQuery = mysqli_query($connection, "INSERT INTO hasworkedon (tauserid, coid, hours) VALUES ('$tauserid', '$coid', '$hours')");
                if ($insertAssignmentQuery) {
                    echo "<p class='success-message'>TA was assigned successfully!</p>";
                } else {
                    echo "<p class='error-message'>Error: Failed to assign TA.</p>";
                }
            }
        }

        // Display the form with dropdown lists for TA and course offering.
        echo "<form action='assign_ta.php' method='post'>";
        echo "<label for='tauserid'>Select TA:</label>";
        echo "<select name='tauserid'>";
        $taResult = mysqli_query($connection, "SELECT tauserid FROM ta");
        while ($taRow = mysqli_fetch_assoc($taResult)) {
            echo "<option value='{$taRow['tauserid']}'>{$taRow['tauserid']}</option>";
        }
        echo "</select><br>";
        echo "<label for='coid'>Select Course Offering:</label>";
        echo "<select name='coid'>";
        $courseResult = mysqli_query($connection, "SELECT coid FROM courseoffer");
        while ($courseRow = mysqli_fetch_assoc($courseResult)) {
            echo "<option value='{$courseRow['coid']}'>{$courseRow['coid']}</option>";
        }
        echo "</select><br>";
        echo "<label for='hours'>Number of Hours:</label>";
        echo "<input type='text' name='hours' required class='form-field'><br>";
        echo "<input type='submit' value='Assign TA'>";
        echo "</form>";
        mysqli_close($connection);
    ?>
</body>
</html>