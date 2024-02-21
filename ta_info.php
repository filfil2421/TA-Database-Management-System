<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 1. It allows the user to select various options for TAs including ordering options, and then updates it for the user to see. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>TA Information</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>    
    <h1>Teaching Assistant Information</h1>
    <!-- Drop down selections -->
    <form action="ta_info.php" method="post">
        <label for="order">Order By:</label>
        <select name="order" id="order">
            <option value="lastname">Last Name</option>
            <option value="degreetype">Degree Type</option>
        </select>

        <label for="direction">Order Direction:</label>
        <select name="direction" id="direction">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>

        <label for="ta">Select TA:</label>
        <?php
            // Populates the TA dropdown list.
            include("connect_database.php"); 
            if ($connection) {
                echo '<select name="ta" id="ta">';
                echo '<option value="all" selected>All TAs</option>';
                $result = mysqli_query($connection, "SELECT tauserid, firstname, lastname FROM ta");
                while ($row = mysqli_fetch_assoc($result)) {
                    $optionText = $row['firstname'] . ' ' . $row['lastname'];
                    echo '<option value="' . $row['tauserid'] . '">' . $optionText . '</option>';
                }
                echo '</select>';
                mysqli_close($connection);
            } else {
                echo '<p>Failed to connect to Database.</p>';
            }
        ?>
        <input type="submit" value="Show Info">
    </form>
    <?php
        include("connect_database.php");
        $selectedTA = isset($_POST["ta"]) ? $_POST["ta"] : "all";   // Retrieve selected TA
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // If user has selected a specific TA then that TA's info is also displayed.
            if ($selectedTA !== "all") {
                // Display information for the selected TA
                $taResult = mysqli_query($connection, "SELECT * FROM ta WHERE tauserid = '$selectedTA'");
                $taRow = mysqli_fetch_assoc($taResult);

                // Display TA information in a specific format
                echo "<h3>Selected TA Information:</h3>";
                echo "<div style='display: flex;'>";
                $imageUrl = $taRow['image'];
                // If ta image exists then use it and display it
                if ($imageUrl) {
                    echo "<img src='$imageUrl' alt='TA Image' style='max-width: 10%; height: auto;'>";
                } 
                // Otherwise display default image.
                else {
                    echo "<img src='genericprofile.png' alt='Generic Head Image' style='max-width: 10%; height: auto;'>";
                }
                echo "<div style='margin-left: 20px;'>";
                echo "<p><strong>Name:</strong> {$taRow['firstname']} {$taRow['lastname']}</p>";
                echo "<p><strong>Student Number:</strong> {$taRow['studentnum']}</p>";
                echo "<p><strong>Degree Type:</strong> {$taRow['degreetype']}</p>";

                // Display courses loved and hated by the TA
                $taUserID = $taRow['tauserid'];
                $lovesResult = mysqli_query($connection, "SELECT lcoursenum FROM loves WHERE ltauserid = '$taUserID'");
                $hatesResult = mysqli_query($connection, "SELECT hcoursenum FROM hates WHERE htauserid = '$taUserID'");

                // Displays courses loved
                echo "<p><strong>Courses Loved:</strong> ";
                if (mysqli_num_rows($lovesResult) > 0) {
                    while ($loveRow = mysqli_fetch_assoc($lovesResult)) {
                        echo "{$loveRow['lcoursenum']}, ";
                    }
                } else {
                    echo "This TA has not picked any courses that they love.";
                }
                echo "</p>";

                // Displays courses hated
                echo "<p><strong>Courses Hated:</strong> ";
                if (mysqli_num_rows($hatesResult) > 0) {
                    while ($hateRow = mysqli_fetch_assoc($hatesResult)) {
                        echo "{$hateRow['hcoursenum']}, ";
                    }
                } else {
                    echo "This TA has not picked any courses that they hate.";
                }
                echo "</p>";
                echo "</div></div>";
                } 
            } 
            // Display information for all TAs in a table by default.
            $order = isset($_POST['order']) ? $_POST['order'] : 'lastname';
            $direction = isset($_POST['direction']) ? $_POST['direction'] : 'asc';
            $result = mysqli_query($connection, "SELECT tauserid, firstname, lastname, studentnum, degreetype FROM ta ORDER BY $order $direction");

            echo "<table>";
            echo "<tr><th>TA User ID:</th><th>First Name:</th><th>Last Name:</th><th>Student Number:</th><th>Degree Type:</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['tauserid']}</td>";
                echo "<td>{$row['firstname']}</td>";
                echo "<td>{$row['lastname']}</td>";
                echo "<td>{$row['studentnum']}</td>";
                echo "<td>{$row['degreetype']}</td>";
                echo "</tr>";
            }
            echo "</table>";   
            mysqli_close($connection);
    ?>
</body>
</html>