<?php
    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/index.php");
    }

    if (!isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/backend/Logout.php?reson=Automaticly%20Loggedout%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    require "./Core.php";

    // check if user is teacher
    $sql = "SELECT * FROM usrs WHERE ID = " . $conn->real_escape_string($_SESSION["ID"]);
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $conn->close();
        header("Location: http://localhost:80/HomePage.php");
    }

    $usr = $result->fetch_assoc();

    if ($usr["IsTeacher"] == 0) {
        $conn->close();
        header("Location: http://localhost:80/HomePage.php");
    }

    $CourseName = $conn->real_escape_string($_POST["CourseName"]);
    $Description = $conn->real_escape_string($_POST["Description"]);

    $sql = "INSERT INTO Courses (Name, CourseLayout, Description, CourseData) VALUES (\"" . $CourseName . "\", \"\", \"" . $Description . "\", \"{}\");";
    $conn->query($sql);

    // add teacher to course
    $sql = "SELECT * FROM Courses WHERE Name = \"$CourseName\"";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $conn->close();
        die("no course found");
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

    header("Location: http://localhost:80/Course.php?CourseID=" . $CourseID);
?>