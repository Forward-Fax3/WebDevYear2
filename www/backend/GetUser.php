<?php
    require "./backend/Core.php";

    if (!isset($usr)) {
        $userID = $_SESSION["ID"];
        $sql = "SELECT * FROM usrs WHERE ID =" . $conn->real_escape_string($userID);
        $usr = $conn->query($sql);

        if ($usr->num_rows == 0) {
            $conn->close();
            die("no user found");
        }

        $usr = $usr->fetch_assoc();
    }
?>
