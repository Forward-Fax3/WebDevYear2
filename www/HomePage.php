<?php
    session_start();

    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/index.php");
    }

    if (!isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/Login.php?reson=Automaticly%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ace Training</title>
        <link rel="stylesheet" href="css.css">
    </head>
    <body>
        <p>
            <?php
                require_once "./backend/Core.php";

                echo "this is the home page";
                echo "<br><a href=\"http://localhost:80/backend/Logout.php\" class=\"button\">Logout</a>";

                $userID = $_SESSION["ID"];
                echo "<br>user id: $userID";
                $sql = "SELECT * FROM usrs WHERE ID =" . $conn->real_escape_string($userID);
                $usr = $conn->query($sql);                                                                
                
                // parse json response
                if ($usr->num_rows == 0) {
                    $conn->close();
                    die("no user found");
                }

                // add button for teachers to create courses
                $usr = $usr->fetch_assoc();
                if ($usr["IsTeacher"] == 1) {
                    echo "<br><a href=\"http://localhost:80/CreateCourse.php\" class=\"button\">Create Course</a>";
                }

                if ($usr["CourseIndexes"] == null) {
                    $conn->close();
                    die("<br>no courses found");
                }

                $json = $usr["CourseIndexes"];
                $ClassIndexes = json_decode($json, true);
                $ClassIndexesValues = array_values($ClassIndexes)[0];

                for ($i = 0; $i < count($ClassIndexesValues); $i++) {
                    $sql = "SELECT * FROM CourseData WHERE ID = " . (int)$ClassIndexesValues[$i];
                    $result = $conn->query($sql);

                    if ($result->num_rows == 0) {
                        $conn->close();
                        die("no courses found");
                    }

                    $courseData = $result->fetch_assoc();
                    // print course name first then parse json

                    echo "<br><br>course name: " . $courseData["CourseName"] . "<br><br>";

                    $json = $courseData["CourseData"];
                    $json = json_decode($json, false);
                    
                    echo "<br>Description: " . $json->Description . "<br>";
                }

                $conn->close();
            ?>
        </p>
    </body>
</html>
