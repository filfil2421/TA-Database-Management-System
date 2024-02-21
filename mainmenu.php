<!-- Programmer name: 29 -->
<!-- This is the main menu page file, where there are 9 buttons displayed, leading to pages where each corresponding task is accomplished. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <style>
        body {
            text-align: center;
            background-color: #f2ebf9;
        }

        h1 {
            color: #333;
        }

        button {
            background-color: #512888; 
            color: white; 
            padding: 12px 20px;
            margin: 6px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }

        .buttondiv {
            border: 2px solid #512888;
            padding: 10px;
            display: inline-block;
            background-color: white;
        }
    </style>
</head>
<body>
    <img src="uwologo.gif" alt="UWO Logo" style="max-width: 100%; height: auto; margin: 20px auto 60px; display: block;">
    <div class="buttondiv">
        <!-- Task 1 Button -->
        <a href="ta_info.php"><button>TA Info</button></a><br>

        <!-- Task 2 Button -->
        <a href="degree_typeTa.php"><button>Degree Type (TA)</button></a><br>

        <!-- Task 3 Button -->
        <a href="insert_ta.php"><button>Insert TA</button></a><br>

        <!-- Task 4 Button -->
        <a href="delete_ta.php"><button>Delete TA</button></a><br>

        <!-- Task 5 Button -->
        <a href="modify_ta.php"><button>Modify TA</button></a><br>

        <!-- Task 6 Button -->
        <a href="assign_ta.php"><button>Assign TA</button></a><br>

        <!-- Task 7 Button -->
        <a href="course_offerings.php"><button>Course Offerings</button></a><br>

        <!-- Task 8 Button -->
        <a href="ta_course_offerings.php"><button>TA's Course Offerings</button></a><br>

        <!-- Task 9 Button -->
        <a href="tas_of_course_offering.php"><button>Course Offering's TAs</button></a><br>
    </div>
</body>
</html>