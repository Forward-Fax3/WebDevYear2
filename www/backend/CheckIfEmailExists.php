<?php
    require_once "./Core.php";

    $Email = $conn->real_escape_string($_POST["Email"]);
    $sql = "SELECT * FROM usrs WHERE Email = \"$Email\"";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $conn->close();
        die("{ \"success\": \"True\" }");
    }

    $conn->close();
    die("{ \"success\": \"False\", \"error\": \"Email already exists.\" }");
?>