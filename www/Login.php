<?php
    session_start();
    if (isset($_SESSION["ID"]) && isset($_COOKIE["ID"])) {
        header("Location: http://localhost:80/HomePage.php");
    }

    if (isset($_SESSION["ID"]) || isset($_COOKIE["ID"])) {
        if (isset($_GET["reson"]))
            header("location: http://localhost:80/backend/logout.php?reson=" . $_GET["reson"]);
        else
            header("location: http://localhost:80/backend/logout.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ace Training</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src="http://localhost:80/JS/Login.js"></script>
    </head>
    <body class="w3-content w3-center w3-gray w3-padding">
        <div class="w3-container w3-display-middle w3-padding w3-light-grey">
            <header class="w3-display-container w3-content w3-wide w3-padding w3-grey" style="max-width:1500px;">
                <div class="w3-center">
                    <h1 class="w3-bar-item w3-wide">
                        Ace Training
                    </h1>
                </div>
            </header>
            
            <div class="w3-bar w3-bordery w3-center">   
                <h2 class="w3-bar-item w3-wide">
                    Login
                </h2>
            </div>

            <div class="w3-text-red" id="error">
                <?php
                    if (isset($_GET["reson"])) {
                        echo $_GET["reson"];
                    }
                ?>
            </div>

            <div class="w3-bar w3-container w3-bordery w3-padding w3-center">
                <form action="javascript:PostLoginRequest()" method="post" style="display: flex; flex-direction: column;">
                    <div class="w3-margin-bottom">
                        <label for="Email">Email</label>
                        <input class="w3-input w3-border" type="text" id="Email" name="Email">
                    </div>
                    <label class="w3-center" for="Psw">Password</label>
                    <div class="w3-margin-bottom" style="display: flex; align-items: center; margin-bottom: 1.5rem; ">
                        <input class="w3-input w3-border"  type="password" id="Psw" name="Psw" style="flex: 1; outline: none;">
                        <i class="fa fa-eye" id="Eye" onclick="javascript:ShowPassword()" style="position: absolute; right: 15%;"></i>
                    </div>

                    <input class="w3-button w3-dark-grey" type="submit" value="login">
                </form>
                <br>
                <a class="w3-button w3-border" href="http://localhost:80/CreateAccount.php">Go to create account</a>
            </div>
        </div>
    </body>
</html>
