<?php
    require "./backend/Core.php";

    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/index.php");
    }

    if (!isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/Login.php?reson=Automaticly%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    $sql = "SELECT * FROM usrs WHERE ID = " . $conn->real_escape_string($_SESSION["ID"]);
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $conn->close();
        die("no user found");
    }

    $usr = $result->fetch_assoc();

    // check if user is teacher
    if ($usr["IsTeacher"] == 0) {
        $conn->close();
        header("Location: http://localhost:80/HomePage.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ace Training</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    </head>
    <body>
        <?php
            echo "<form action=\"http://localhost:80/backend/CreateCourseBack.php\" method=\"post\">";
            echo "<label for=\"CourseName\">Course Name</label><br>";
            echo "<input type=\"text\" id=\"CourseName\" name=\"CourseName\"><br>";
            echo "<label for=\"Description\">Course Data</label><br>";
            echo "<input type=\"text\" id=\"Description\" name=\"Description\"><br>";
            echo "<input type=\"submit\" value=\"Create Course\">";
            echo '</form>';
        ?>
    </body>
</html>