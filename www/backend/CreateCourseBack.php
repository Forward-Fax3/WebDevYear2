<?php
    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/index.php");
    }

    if (!isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/Login.php?reson=Automaticly%20Loggedout%20due%20to%20timeout.<br>Please%20login%20again.");
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

    $jsonCourseData = json_encode(["Description" => $Description]);

    $sql = "INSERT INTO CourseData (CourseName, CourseData) VALUES (\"" . $CourseName . "\", \"" . $conn->real_escape_string($jsonCourseData) . "\")";
    $conn->query($sql);

    // add techer to course
    $sql = "SELECT * FROM CourseData WHERE CourseName = \"$CourseName\"";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $conn->close();
        die("no course found");
    }

    $courseData = $result->fetch_assoc();
    $CourseID = $courseData["ID"];
    
    $courseIndexes = $usr["CourseIndexes"];

    if ($courseIndexes == null) {
        $json = json_encode(["CourseIndexes" => [$CourseID]]);
        $json = $conn->real_escape_string($json);
        $sql = "UPDATE usrs SET CourseIndexes = \"$json\" WHERE ID = " . $conn->real_escape_string($_SESSION["ID"]);
        $conn->query($sql);
    } else {
        $courses = json_decode($usr["CourseIndexes"], false);

        array_push($courses->CourseIndexes, $CourseID);

        $json = json_encode($courses);
        $sql = "UPDATE usrs SET CourseIndexes = \"" . $conn->real_escape_string($json) . "\" WHERE ID = " . $conn->real_escape_string($_SESSION["ID"]);
        $conn->query($sql);

        $conn->close();
    }

    header("Location: http://localhost:80/HomePage.php");
?>