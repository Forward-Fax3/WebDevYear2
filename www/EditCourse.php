<?php
    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/backend/Logout.php?reson=Invalid%20Session.<br>Please%20login%20again.");
    }

    if (!isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/backend/Logout.php?reson=Automaticly%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    require "./backend/Core.php";
    require "./Backend/GetUser.php";

    if (!isset($_GET["CourseID"])) {
        header("Location: http://localhost:80/HomePage.php");
    }

    $usrCourses = explode(",", $usr["CourseIndexes"]);
    $usrCourses = array_filter($usrCourses, "is_numeric");

    // check if the user has access to the course
    if (!in_array($_GET["CourseID"], $usrCourses)) {
        header("Location: http://localhost:80/HomePage.php");
    }

    require "./backend/Core.php";
    require "./Backend/GetUser.php";
    
    if ($usr["IsTeacher"] == 0) {
        header("Location: http://localhost:80/HomePage.php");
    }
?>

<!Doctype html>
<html lang="en">
    <head>
        <title>Ace Training</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .w3-sidebar a {font-family: "Roboto", sans-serif}
            body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
        </style>
        <script src="./backend/JS/SideBar.js"></script>
    </head>
    <body class="w3-content w3-light-grey">
        <?php
            $sql = "SELECT * FROM Courses WHERE ID = " . (int)$_GET["CourseID"];
            $result = $conn->query($sql);
            
            if ($result->num_rows == 0) {
                $conn->close();
                die("no course found");
            }
            
            $courseData = $result->fetch_assoc();
            $JSONCourseData = json_decode($courseData["CourseData"]);
        ?>
        <header class="w3-container w3-xlarge w3-left">
            <h1 class="w3-left w3-wide">
                <?php echo $courseData["Name"]; ?>
            </h1>
            <div class="w3-right w3-padding">
                <!--
                <i class="fa fa-search"></i>
                TODO: if have time add search
                -->
            </div>
        </header>
        <body class="w3-content w3-light-grey w3-margin-left">
            <?php
                include "./Backend/SideBar.php";
            ?>
            <div class="w3-hide-large" style="left:250px">
                <?php
                    include "./Backend/EditCourseForm.php";
                    $conn->close();
                ?>
            </div>
        </body>
    </body>
</html>
