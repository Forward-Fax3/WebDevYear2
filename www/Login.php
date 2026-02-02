<!DOCTYPE html>
<html>
<head>
  <title>test</title>
  <link rel="stylesheet" href="css.css">
</head>
<body>

<h1>My first PHP page</h1>
<p>
    <script type="text/javascript" src="http://localhost:80/JS/Login.js"></script>

    <p id="error"></p>

    <?php
        # TODO: add and check cookie

        echo "<form action=\"javascript:PostLoginRequest()\" method=\"post\">";
        echo "<label for=\"Email\">Email</label><br>";
        echo "<input type=\"text\" id=\"Email\" name=\"Email\"><br>";
        echo "<label for=\"Psw\">Password</label><br>";
        echo "<input type=\"text\" id=\"Psw\" name=\"Psw\"><br>";
        echo "<input type=\"submit\" value=\"login\">";
        echo '</form>';

        echo "<a href=\".\\CreateAccount.php\" class=\"button\">Go to create account</a>";
    ?>
</p>
</body>
</html>
