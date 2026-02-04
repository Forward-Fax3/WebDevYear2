<?php
    session_start();
    if (isset($_SESSION["ID"]) && isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/HomePage.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ace Training</title>
        <link rel="stylesheet" href="css.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src="http://localhost:80/JS/Login.js"></script>
    </head>
    <body>
        <h1>Ace Training</h1>
        <?php
            echo "<h2>Login</h2>";

            echo "<p id=\"error\">";
            if (isset($_GET["reson"])) {
                echo $_GET["reson"];
            }
            echo "</p>";
          
            echo "<form action=\"javascript:PostLoginRequest()\" method=\"post\">";
            echo "<label for=\"Email\">Email</label><br>";
            echo "<input type=\"text\" id=\"Email\" name=\"Email\"><br>";
            echo "<label for=\"Psw\">Password</label><br>";
            echo "<input type=\"text\" id=\"Psw\" name=\"Psw\"><br>";
            echo "<input type=\"submit\" value=\"login\">";
            echo '</form>';
              
            echo "<a href=\".\\CreateAccount.php\" class=\"button\">Go to create account</a>";
        ?>
    </body>
</html>
