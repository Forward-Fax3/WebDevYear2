<!DOCTYPE html>
<html>
    <head>
        <title>test</title>
        <link rel="stylesheet" href="css.css">
    </head>
    <body>
        <p>
            <?php
                echo "<form action=\"http://localhost:80/backend/CreateAccountBack.php\" method=\"post\">";
                echo "<label for=\"Email\">Username</label><br>";
                echo "<input type=\"text\" id=\"Email\" name=\"Email\"><br>";
                echo "<label for=\"Psw\">password</label><br>";
                echo "<input type=\"text\" id=\"Psw\" name=\"Psw\"><br>";
                echo "<input type=\"submit\" value=\"login\">";
                echo '</form>';
            ?>
        </p>
    </body>
</html>