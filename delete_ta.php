<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 4. It allows the user to delete a TA from the database as long as he/she is not assigned to a course offering. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>Delete TA</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>    
    <h1>Delete Teaching Assistant</h1>
    <?php
        include("connect_database.php");
        // Checks if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $deleteTA = isset($_POST["deleteTA"]) ? $_POST["deleteTA"] : "";
            if (!empty($deleteTA)) {
                // Check if the TA exists
                $checkTAResult = mysqli_query($connection, "SELECT * FROM ta WHERE tauserid='$deleteTA'");
                if (mysqli_num_rows($checkTAResult) > 0) {
                    // Check if the TA is assigned to a course offering
                    $checkAssignmentSql = mysqli_query($connection, "SELECT * FROM hasworkedon WHERE tauserid='$deleteTA'");
                    if (mysqli_num_rows($checkAssignmentSql) > 0) {
                        echo "<p class='error-message'>Error: This TA is already assigned to a course offering and can not be deleted.</p>";
                        echo "<a href='delete_ta.php'>Go back</a>";
                    } 
                    else {
                        // Display confirmation message to the user.
                        echo "<p>Warning: Are you sure you want to delete this TA?</p>";
                        echo "<form action='delete_ta.php' method='get'>";
                        echo "<input type='hidden' name='confirmedDelete' value='$deleteTA'>";
                        echo "<input type='submit' value='Yes, delete'>";
                        echo "</form>";
                        echo "<a href='delete_ta.php'>No, go back</a>";
                    }
                } 
            } 
        } 
        else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["confirmedDelete"])) {
            // Performs the actual deletion if the user confirms to delete.
            $deleteTA = $_GET["confirmedDelete"];
            $deleteQuery = mysqli_query($connection, "DELETE FROM ta WHERE tauserid='$deleteTA'");
            if ($deleteQuery) {
                echo "<p class='success-message'>TA deleted successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: TA was not deleted.</p>";
            }
        } 
        else {
            // Displays the form with a dropdown list of TAs.
            echo "<form action='delete_ta.php' method='post'>";
            echo "<label for='deleteTA'>Select a TA to delete:</label>";
            echo "<select name='deleteTA'>";
            $result = mysqli_query($connection, "SELECT tauserid, firstname, lastname FROM ta");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['tauserid']}'>{$row['tauserid']} - {$row['firstname']} {$row['lastname']}</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Delete TA'>";
            echo "</form>";
        }
        mysqli_close($connection);
    ?>
</body>
</html>