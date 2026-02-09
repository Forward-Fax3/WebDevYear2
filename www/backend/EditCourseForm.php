<?php
    require("./Backend/Core.php");
    require("./Backend/GetUser.php");

	$usrCourses = explode(",", $usr["CourseIndexes"]);
	$usrCourses = array_filter($usrCourses, "is_numeric");

    // check if the user has access to the course
    if (!in_array($_GET["CourseID"], $usrCourses)) {
        header("Location: http://localhost:80/HomePage.php");
    }

    $CourseID = $conn->real_escape_string($_GET["CourseID"]);
    $sql = "SELECT * FROM courses WHERE ID = " . $CourseID;
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $conn->close();
        die("no course found");
    }

    $courseData = $result->fetch_assoc();
    $JSONCourseData = json_decode($courseData["CourseData"]);
?>