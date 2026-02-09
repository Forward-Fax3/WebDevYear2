<?php
    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/backend/Logout.php?reson=Invalid%20Session.<br>Please%20login%20again.");
    }

    if (!isset($_GET["CourseID"])) {
        header("Location: http://localhost:80/HomePage.php");
    }

    if (!isset($_COOKIE["ID"])) {
        setcookie("ReturnURL", "http://localhost:80/Course.php?CourseID=" . $_GET["CourseID"], time() + (3600 * 24), "/");
        header("Location: http://localhost:80/backend/Logout.php?reson=Automaticly%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    require "./backend/Core.php";
    include "./Backend/GetUser.php";

    $usrCourses = explode(",", $usr["CourseIndexes"]);
    $usrCourses = array_filter($usrCourses, "is_numeric");

    // check if the user has access to the course
    if (!in_array($_GET["CourseID"], $usrCourses)) {
        header("Location: http://localhost:80/HomePage.php");
    }
?>

<!DOCTYPE html>
<html>
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
            include "./Backend/SideBar.php";

            $sql = "SELECT * FROM Courses WHERE ID = " . (int)$_GET["CourseID"];
            $result = $conn->query($sql);
            
            if ($result->num_rows == 0) {
                $conn->close();
                die("no course found");
            }
            
            $courseData = $result->fetch_assoc();
            $JSONCourseData = json_decode($courseData["CourseData"]);
        ?>
        <div class="w3-main" style="left:250px">
            <div class="w3-hide-large" style="margin-top:83px"></div>
                <header class="w3-container w3-xlarge">
                    <h1 class="w3-left w3-wide">
                        <?php echo $courseData["Name"]; ?>
                    </h1>
                    <div class="w3-right w3-padding">
                        <?php
                            if ($usr["IsTeacher"] == 1) {
                                echo "<a class=\"w3-button w3-grey\" href=\"http://localhost:80/EditCourse.php?CourseID=" . $courseData["ID"] . "\">Edit Course</a>";
                            }
                        ?>
                        <i class="fa fa-search"></i>
                        <!--
                        TODO: if have time add search
                        -->
                    </div>
                </header>
                <div class="w3-container">
                    <div class="w3-bordery">
                        <h2 class="w3-wide">
                            Description
                        </h2>
                    </div>
                    <div class="w3-container w3-padding">
                        <?php
                            echo $courseData["Description"];
                        ?>
                    </div>
                    <div class="w3-bordery">
                        <?php
                            $courseLayout = $courseData["CourseLayout"];
                            $courseLayout = explode(",", $courseLayout);
                            $courseLayout = array_filter($courseLayout, "is_numeric");

                            $blockNumber = 0;

                            $courseLayout = array_map(function ($item) {
                                return (int)$item;
                            }, $courseLayout);
                            echo count($courseLayout);

                            for ($i = 0; $i < count($courseLayout); $i++) {
                                switch ($courseLayout[$i]) {
                                case 0:
                                    // new block
                                    echo "<div class=\"w3-container w3-padding w3-grey\"><h2 class=\"w3-wide\">";
                                    echo $JSONCourseData["Name"][$blockNumber];
                                    $blockNumber++;
                                    break;
                                case 1: 
                                    // end block
                                    echo "</h2></div>";
                                }
                            }
                        ?>
                    </div>
                    <?php
                        if ($usr["IsTeacher"] == 1) {
                            echo "<div class=\"w3-container w3-bottom w3-left w3-bar w3-padding w3-grey\" style=\"z-index:3;width:315px\">"
                                . "<a class=\"w3-button w3-black\" href=\"http://localhost:80/DeleteCourse.php?CourseID=" . $courseData["ID"] . "\">Delete Course</a>"
                            . "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
    $conn->close();
?>
