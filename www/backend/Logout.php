<?php
    setcookie("ID", "", 0, "/");

    session_start();
    session_destroy();
    if (isset($_GET["reson"]))
        header("Location: http://localhost:80/Login.php?reson=" . $_GET["reson"]);
    else
        header("Location: http://localhost:80/Login.php");
?>
