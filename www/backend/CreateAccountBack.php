<?php
    if ($_SERVER["REQUEST_METHOD"] != "POST" ||
        !isset($_POST['Email']) ||
        !isset($_POST['Psw'])) {
        header("Location: http://localhost:80/index.php");
        die();
    }

    require_once "Core.php";

    $Email = $conn->real_escape_string($_POST["Email"]);
    $Psw = $conn->real_escape_string(password_hash($_POST["Psw"], PASSWORD_DEFAULT));

    $sql = "INSERT INTO usrs (Email, Psw) VALUES (\"$Email\", \"$Psw\")";
    $conn->query($sql);

    echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost:80/Login.php\">";

    $conn->close();
?>
