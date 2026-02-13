<?php
    if (!isset($_SESSION))
        session_start();
    if (!isset($_SESSION["ID"]))
        header("Location: http://localhost:80/backend/Login.php");

    require $_SERVER["DOCUMENT_ROOT"] . "/Backend/Core.php";

    if (!isset($usr)) {
        $userID = $_SESSION["ID"];
        $sql = "SELECT * FROM usrs WHERE ID =" . $conn->real_escape_string($userID);
        $usr = $conn->query($sql);

        if ($usr->num_rows == 0) {
            $conn->close();
            die("{ \"Successful\": \"User does not exist\" }");
        }

        $usr = $usr->fetch_assoc();
    }
?>
