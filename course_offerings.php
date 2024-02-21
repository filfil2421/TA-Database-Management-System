<!-- Programmer name: 29 -->
<!-- This file is used to set up Task 7. It allows the user user to select a course and see all the course offering for the course.  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <title>Course Offerings</title>
</head>
<body>
    <!-- Home button -->
    <a id="home-button" href="mainmenu.php">Home</a>
    <h1>Available Course Offerings</h1>
    <?php
        include("connect_database.php");
        // Gets courses from database.
        $courseResult = mysqli_query($connection, "SELECT DISTINCT coursenum FROM course");
        $courses = mysqli_fetch_all($courseResult, MYSQLI_ASSOC);
        // Checks if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selectedCourse = $_POST["course"];
            $startYear = $_POST["startYear"];
            $endYear = $_POST["endYear"];
            // Validates that the start year is before the end year.
            if ($startYear > $endYear) {
                echo "<p class='error-message'>Error: The Start year of the course must be before the end year.</p>";
            } else {
                // Get course offerings based on user input.
                $query = "SELECT coid, numstudent, term, year FROM courseoffer WHERE whichcourse='$selectedCourse'";
                if (!empty($startYear) && !empty($endYear)) {
                    // Includes course offerings with the same year offered as the inputted start and end years by the user.
                    $query .= " AND (year >= $startYear AND year <= $endYear)";
                }
                $result = mysqli_query($connection, $query);
                // Displays the results.
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr><th>Course Offering ID</th><th>Number of Students</th><th>Term</th><th>Year</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['coid']}</td>";
                        echo "<td>{$row['numstudent']}</td>";
                        echo "<td>{$row['term']}</td>";
                        echo "<td>{$row['year']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p class='error-message'>No course offerings found for the selected criteria.</p>";
                }
            }
        }
        // Displays the form with dropdown lists for courses and years.
        echo "<form action='course_offerings.php' method='post'>";
        echo "<label for='course'>Select Course:</label>";
        echo "<select name='course'>";
        foreach ($courses as $course) {
            echo "<option value='{$course['coursenum']}'>{$course['coursenum']}</option>";
        }
        echo "</select><br>";
        echo "<label for='startYear'>Start Year:</label>";
        echo "<input type='number' name='startYear' min='1878' max='2050'><br>";
        echo "<label for='endYear'>End Year:</label>";
        echo "<input type='number' name='endYear' min='1878' max='2050'><br>";
        echo "<input type='submit' value='View Offerings'>";
        echo "</form>";
        mysqli_close($connection);
    ?>
</body>
</html>