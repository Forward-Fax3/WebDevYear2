<?php
    try {
        if ($_SERVER["REQUEST_METHOD"] != "POST" ||
            !isset($_POST["Email"]) ||
            !isset($_POST["Psw"])) {
            header("Location: http://localhost:80/index.php");
        }

        require "./Core.php";

        $Email = $conn->real_escape_string($_POST["Email"]);

        $sql = "SELECT * FROM usrs WHERE Email = \"$Email\"";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            $conn->close();
            die("{ \"success\": \"False\", \"error\": \"Incorrect Email or password.\" }");
        }

        $usr = $result->fetch_assoc();
        if (!password_verify($_POST["Psw"], $usr["Psw"])) {
            $conn->close();
            die("{ \"success\": \"False\", \"error\": \"Incorrect Email or password.\" }");
        }

        session_start();
        $_SESSION["ID"] = $usr["ID"];
        setcookie("ID", $_SESSION["ID"], time() + (3600 * 6), "/");
        echo "{ \"success\": \"True\" }";
    }
    catch (Exception $e) {
        echo "{ \"success\": \"False\", \"error\": \"" . $e->getMessage() . "\" }";
    }

    $conn->close();
    exit();
?>
