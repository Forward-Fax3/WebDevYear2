<?php
    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/index.php");
    }

    if (!isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/backend/Logout.php?reson=Automatically%20Logged%20out%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    require "./Core.php";
	require "./GetUser.php";

    if ($usr["IsTeacher"] == 0) {
        $conn->close();
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");
    }

    $CourseName = $conn->real_escape_string($_POST["Name"]);

	// check if course already exists
	$sql = "SELECT 1 FROM Courses WHERE Name = \"" . $conn->real_escape_string($CourseName) . "\"";
	$result = $conn->query($sql);
	if ($result->num_rows == 1) {
		$conn->close();
		die("{ \"success\": \"False\", \"error\": \"Course already exists. Please choose another.\" }");
	}

    $Description = $conn->real_escape_string($_POST["Description"]);

    $sql = "INSERT INTO Courses (Name, CourseLayout, Description, CourseData) VALUES (\"" . $CourseName . "\", \"\", \"" . $Description . "\", \"{}\");";
    $conn->query($sql);

    // add teacher to course
    $sql = "SELECT * FROM Courses WHERE Name = \"" . $CourseName . "\"";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $conn->close();
		die("{ \"success\": \"False\", \"error\": \"Unknown error.\" }");
    }

    $courseData = $result->fetch_assoc();
    $CourseID = $courseData["ID"];
    
    $courseIndexes = $usr["CourseIndexes"];

    if ($courseIndexes == null || $courseIndexes == "") {
        $sql = "UPDATE usrs SET CourseIndexes = \"" . $CourseID . "\" WHERE ID = " . $conn->real_escape_string($_SESSION["ID"]);
        $conn->query($sql);
    } else {
		$courseIndexes = $courseIndexes . "," . $CourseID;

        $sql = "UPDATE usrs SET CourseIndexes = \"" . $conn->real_escape_string($courseIndexes) . "\" WHERE ID = " . $conn->real_escape_string($_SESSION["ID"]);
		$conn->query($sql);
        $conn->close();
    }

	echo "{ \"success\": \"True\", \"id\": \"" . $CourseID . "\" }";
?>