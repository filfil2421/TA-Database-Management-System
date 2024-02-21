<!-- Programmer name: 29 -->
<!-- This file is used to complete task 2: showing TA information based on the type of degree the user selects. -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>TA Info by Degree Type</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>
    <h1>Teaching Assistant Information by Degree Type</h1>
    <!-- Drop down selection -->
    <form action="" method="post">
        <label for="degree">Select Degree Type:</label>
        <select name="degree" id="degree">
            <option value="Masters">Masters</option>
            <option value="PhD">PhD</option>
        </select>
        <input type="submit" value="Show Info">
    </form>

    <?php
    // Checks if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Gets the selected degree from the form
        $selectedDegree = $_POST["degree"];
        include("connect_database.php");

        if ($connection) {
            $query = "SELECT tauserid, firstname, lastname, studentnum FROM ta WHERE degreetype = '$selectedDegree'";
            $result = mysqli_query($connection, $query);

            // Makes sure that rows are returned and the database isn't empty.
            if (mysqli_num_rows($result) > 0) {
                // Displays the TA information in a formatted table.
                echo '<table>';
                echo '<tr><th>TA User ID:</th><th>First Name:</th><th>Last Name:</th><th>Student Number:</th></tr>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['tauserid'] . '</td>';
                    echo '<td>' . $row['firstname'] . '</td>';
                    echo '<td>' . $row['lastname'] . '</td>';
                    echo '<td>' . $row['studentnum'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>There are no TAs with the degree you selected.</p>';
            }
            mysqli_close($connection);
        } else {
            echo '<p>Failed to connect to Database.</p>';
        }
    }
    ?>
</body>
</html>