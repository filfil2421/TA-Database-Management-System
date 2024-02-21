<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 9. It allows the user to select a course offering and display the course number and name and the first and last names and user ids of all t.a.s  who have worked on this course offering.  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>Tas of Course Offering</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>
    <h1>Teaching Assistants of a Course Offering</h1>
    <?php
        include("connect_database.php");
        // Gets course offerings from the database.
        $courseOfferingResult = mysqli_query($connection, "SELECT coid, term, year FROM courseoffer");
        $courseOfferings = mysqli_fetch_all($courseOfferingResult, MYSQLI_ASSOC);
        // Checks if the form is submitted.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selectedCourseOffering = $_POST["coid"];
            // Get information about TAs who have worked on the selected course offering.
            $query = "SELECT h.tauserid, t.firstname, t.lastname, o.whichcourse AS coursenum FROM hasworkedon h JOIN ta t ON h.tauserid = t.tauserid JOIN courseoffer o ON h.coid = o.coid WHERE h.coid='$selectedCourseOffering'";
            $result = mysqli_query($connection, $query);
            // Display the results.
            if ($result !== false) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<p>Selected Course Offering ID: $selectedCourseOffering</p>";
                    echo "<table>";
                    echo "<tr></th><th>Course Number</th><th>TA User ID</th><th>First Name</th><th>Last Name</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['coursenum']}</td>";
                        echo "<td>{$row['tauserid']}</td>";
                        echo "<td>{$row['firstname']}</td>";
                        echo "<td>{$row['lastname']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } 
                else {
                    echo "<p class='error-message'>There are no TAs for the selected course offering.</p>";
                }
            } 
        }
        // Display the form with dropdown list for course offerings.
        echo "<form action='tas_of_course_offering.php' method='post'>";
        echo "<label for='coid'>Select a Course Offering:</label>";
        echo "<select name='coid'>";
        foreach ($courseOfferings as $courseOffering) {
            echo "<option value='{$courseOffering['coid']}'>{$courseOffering['coid']} ({$courseOffering['term']} {$courseOffering['year']})</option>";
        }
        echo "</select><br>";
        echo "<input type='submit' value='View the TAs'>";
        echo "</form>";
        mysqli_close($connection);
    ?>
</body>
</html>