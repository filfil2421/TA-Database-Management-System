<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 5. It allows the user to modify the image url of a TA. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>Modify TA</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>    
    <h1>Modify Teaching Assistant Image URL</h1>
    <?php
    include("connect_database.php");
    // Checks if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tauserid = isset($_POST["tauserid"]) ? $_POST["tauserid"] : "";
        $newImageUrl = isset($_POST["newImageUrl"]) ? $_POST["newImageUrl"] : "";

        if (!empty($tauserid) && !empty($newImageUrl)) {
            // Updates the image URL for the specified TA
            $updateQuery = mysqli_query($connection, "UPDATE ta SET image='$newImageUrl' WHERE tauserid='$tauserid'");
            if ($updateQuery) {
                echo "<p class='success-message'>Image URL updated successfully!</p>";
            } else {
                echo "<p class='error-message'>There was an error updating the image URL.</p>";
            }
        } else {
            echo "<p class='error-message'>Error: Please provide a TA User ID and a new Image URL.</p>";
        }
    } 
    else {
        // Displays the form to allow the user to input TA User ID and new Image URL.
        echo "<form action='modify_ta.php' method='post'>";
        echo "<label for='tauserid'>Select TA:</label>";
        echo "<select name='tauserid'>";
        // Fetch TA User IDs from the database
        $result = mysqli_query($connection, "SELECT tauserid FROM ta");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['tauserid']}'>{$row['tauserid']}</option>";
        }
        echo "</select><br>";
        echo "<label for='newImageUrl'>New Image URL:</label>";
        echo "<input type='text' name='newImageUrl' required><br>";
        echo "<input type='submit' value='Modify URL'>";
        echo "</form>";
    }
    mysqli_close($connection);
    ?>
</body>
</html>