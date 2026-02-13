<?php
    require "./backend/Core.php";

    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/index.php");
    }

    if (!isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/Login.php?reson=Automaticly%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    include "./backend/GetUser.php";

    // check if user is teacher
    if ($usr["IsTeacher"] == 0) {
        $conn->close();
        header("Location: http://localhost:80/HomePage.php");
    }
?>

<!DOCTYPE html>
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
        <script src="./JS/CreateCourse.js"></script>
    </head>
    <body class="w3-light-grey">
        <?php include "./Backend/SideBar.php" ?>
        <div class="w3-bar w3-container w3-bordery w3-center w3-display-middle w3-white w3-padding-16" style="max-width:900px; width: 100%;">
            <h1 class="w3-center w3-padding-16 w3-light-gray">
                Create Course
            </h1>
            <div class="w3-padding-32 w3-light-grey w3-left" style="width: 100%">
                <p class="w3-container w3-text-red" id="error" hidden>
                </p>
                <form action="javascript:CreateCourse()" method="post">
                    <div class="w3-section w3-left-align w3-margin-left w3-margin-right">
                        <label for="Name">Course Name</label>
                        <input class="w3-input w3-border w3-padding" type="text" id="Name" name="Name" required>
                    </div>
                    <div class="w3-section w3-left-align w3-margin-left w3-margin-right" style="width: 100%">
                        <label for="Description">Course Description</label>
                        <textarea class="w3-input w3-border w3-text" rows="8" style="width: 100%" id="Description" name="Description" required></textarea>
                    </div>
                    <input class="w3-button w3-light-grey" type="submit" value="Create Course">
                </form>
            </div>
        </div>
    </body>
</html>
