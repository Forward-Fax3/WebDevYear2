<?php
    // delete cookie
    setcookie("Email", "", time() - 3600);

    session_start();
    session_destroy();
    header("Location: http://localhost:80/index.php");
?>