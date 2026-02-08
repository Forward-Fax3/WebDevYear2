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
    <body class="w3-content" style="align-content: left">
        <?php
            require "./backend/Core.php";
            include "./Backend/GetUser.php";
            include "./Backend/SideBar.php";

            $sql = "SELECT * FROM CourseData WHERE ID = " . (int)$_GET["CourseID"];
            $result = $conn->query($sql);
            
            if ($result->num_rows == 0) {
                $conn->close();
                die("no courses found");
            }
            
            $courseData = $result->fetch_assoc();
            $JSONCourseData = json_decode($courseData["CourseData"]);
        ?>
        <div class="w3-main" style="margin-left:250px">
            <div class="w3-hide-large" style="margin-top:83px"></div>
            <header class="w3-container w3-xlarge">
                <p class="w3-left">
                    <?php echo $courseData["CourseName"]; ?>
                </p>
                <p class="w3-right">
                    <!--
                    <i class="fa fa-search"></i>
                    TODO: if have time add search
                    -->
                </p>
            </header>
            <div class="w3-container">
                <p>
                    <?php
                        echo $JSONCourseData->Description;
                    ?>
                </p>
            </div>
        </div>
    </body>
</html>
<?php
    $conn->close();
?>
