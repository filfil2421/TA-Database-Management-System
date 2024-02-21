<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 8. It allows the user to select a ta and see all the course offerings that this ta has worked on.  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>TA Course Offerings</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>
    <h1>Teaching Assistant Course Offerings</h1>
    <?php
        include("connect_database.php");
        // Gets TAs from the database.
        $taResult = mysqli_query($connection, "SELECT tauserid, firstname, lastname FROM ta");
        $tas = mysqli_fetch_all($taResult, MYSQLI_ASSOC);
        // Checks if the form is submitted.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selectedTA = $_POST["tauserid"];
            // Get course offerings that the selected TA has worked on
            $query = "SELECT h.tauserid, h.coid, c.coursenum, c.coursename, o.term, o.year, h.hours, lo.ltauserid IS NOT NULL AS loved, ha.htauserid IS NOT NULL AS hated FROM hasworkedon h JOIN courseoffer o ON h.coid = o.coid JOIN course c ON o.whichcourse = c.coursenum LEFT JOIN loves lo ON h.tauserid = lo.ltauserid AND h.coid = lo.lcoursenum LEFT JOIN hates ha ON h.tauserid = ha.htauserid AND h.coid = ha.hcoursenum WHERE h.tauserid='$selectedTA'";
            $result = mysqli_query($connection, $query);
            // Displays the results in a table.
            if ($result !== false) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr><th>Course Offering ID</th><th>Course Number</th><th>Course Name</th><th>Term</th><th>Year</th><th>Hours</th><th>Loved</th><th>Hated</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['coid']}</td>";
                        echo "<td>{$row['coursenum']}</td>";
                        echo "<td>{$row['coursename']}</td>";
                        echo "<td>{$row['term']}</td>";
                        echo "<td>{$row['year']}</td>";
                        echo "<td>{$row['hours']}</td>";
                        echo "<td>" . ($row['loved'] ? '&#128522;' : '') . "</td>"; // Smiley face in HTML
                        echo "<td>" . ($row['hated'] ? '&#128542;' : '') . "</td>"; // Sad face in HTML
                        echo "</tr>";
                    }
                    echo "</table>";
                } 
                else {
                    echo "<p class='error-message'>There are no course offerings for the selected TA.</p>";
                }
            } 
        }
        // Display the form with dropdown list for TAs
        echo "<form action='ta_course_offerings.php' method='post'>";
        echo "<label for='tauserid'>Select TA:</label>";
        echo "<select name='tauserid'>";
        foreach ($tas as $ta) {
            echo "<option value='{$ta['tauserid']}'>{$ta['tauserid']} - {$ta['firstname']} {$ta['lastname']}</option>";
        }
        echo "</select><br>";
        echo "<input type='submit' value='View Course Offerings'>";
        echo "</form>";
        mysqli_close($connection);
    ?>
</body>
</html>