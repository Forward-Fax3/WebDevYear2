<?php
    session_start();

    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/backend/backend/Logout.php?reson=Invalid%20Session.<br>Please%20login%20again.");
    }

    if (!isset($_COOKIE["ID"])) {
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
        <script src="http://localhost:80/backend/JS/SideBar.js"></script>
    </head>
    <body class="w3-content w3-light-grey">
        <?php
            require "./backend/Core.php";

            include "./Backend/GetUser.php";
            
            $isHomePage = true;
            include "./Backend/SideBar.php";

            // main content part of the page
            echo "<div class=\"w3-main\" style=\"margin-left:250px\"><div class=\"w3-row w3-padding-64\">";
        ?>
    </body>
</html>
