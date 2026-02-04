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
        <link rel="stylesheet" href="http://localhost:80/css.css">
        <style>
            .w3-sidebar a {font-family: "Roboto", sans-serif}
            body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
        </style>
    </head>
    <body class="w3-content" style="align-content: left">
        <?php
            require "./backend/Core.php";
            include "./Backend/GetUser.php";
            include "./Backend/SideBar.php";

            echo "this is the course page";
            echo "<br><a href=\"http://localhost:80/backend/Logout.php\" class=\"button\">Logout</a>";
        ?>
    </body>
</html>
