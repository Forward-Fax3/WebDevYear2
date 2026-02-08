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
        <div class="w3-container w3-display-middle w3-padding w3-light-grey" style="max-width: 310px; margin: auto;">
            <header class="w3-display-container w3-content w3-wide w3-padding w3-grey">
                <div class="w3-center">
                    <h1 class="w3-bar-item w3-wide">
                        Ace Training
                    </h1>
                </div>
            </header>
            
            <div class="w3-container w3-bar w3-bordery w3-center">  
                <div id="Page1Title">
                    <h2 class="w3-bar-item w3-wide">
                        Create Account
                    </h2>
                </div>
                <div id="Page2Title" hidden>
                    <h3 class="w3-bar-item w3-wide">
                        Further details
                    </h3>
                </div>
            </div>
            <br>
            
            <div class="w3-text-red" id="error" hidden>
            </div>

            <div class="w3-bar w3-container w3-bordery w3-padding w3-center">
                <form action="javascript:NextPage()" id="Form" method="post" style="display: flex; flex-direction: column;">
                    <div id="FirstPage">
                        <div class="w3-margin-bottom">
                            <label for="Email">Email</label>
                            <input class="w3-input w3-border" type="email" id="Email" oninput="javascript:CheckPassword()" name="Email">
                        </div>
                        <div class="w3-margin-bottom w3-text-red" type="text" id="EmailCheck" hidden></div>

                        <label class="w3-center" for="Psw">Password</label>
                        <div class="w3-margin-bottom" style="display: flex; align-items: center; margin-bottom: 1.5rem; ">
                            <input class="w3-input w3-border"  type="password" id="Psw" oninput="javascript:CheckPassword()" name="Psw" style="flex: 1; outline: none;">
                            <i class="fa fa-eye" id="Eye" onclick="javascript:ShowPassword()" style="position: absolute; right: 15%;"></i>
                        </div>
                        <div class="w3-margin-bottom w3-text-red" type="text" id="CharCheck" hidden></div>

                        <label class="w3-center" for="PswA">Password Again</label>
                        <div class="w3-margin-bottom" style="display: flex; align-items: center; margin-bottom: 1.5rem; ">
                            <input class="w3-input w3-border"  type="password" id="PswA" oninput="javascript:CheckPassword()" name="PswA" style="flex: 1; outline: none;">
                            <i class="fa fa-eye" id="EyeA" onclick="javascript:ShowPasswordAgain()" style="position: absolute; right: 15%;"></i>
                        </div>
                        <div class="w3-margin-bottom" type="text" id="PasswordCheck" hidden></div>
                        
                        <br>
                        <input class="w3-button w3-dark-grey" type="submit" id="NextButton" value="next" disabled>
                    </div>

                    <div id="SecondPage" hidden>
                        <div class="w3-margin-bottom">
                            <label for="FName">Name</label>
                            <input class="w3-input w3-border" type="text" oninput="javascript:SecondPageChecks()" id="FName" name="fName">
                        </div>
                        <div class="w3-margin-bottom w3-text-red" type="text" id="FNameError" hidden></div>
                        <div hidden id="FNameWrittenTo">f</div>

                        <div class="w3-margin-bottom">
                            <label for="Surname">Surname</label>
                            <input class="w3-input w3-border" type="text" oninput="javascript:SecondPageChecks()" id="Surname" name="Surname">
                        </div>
                        <div class="w3-margin-bottom w3-text-red" type="text" id="SurnameError" hidden></div>
                        <div hidden id="SurnameWrittenTo">f</div>

                        <div class="w3-margin-bottom">
                            <label for="Phone">Phone</label>
                            <input class="w3-input w3-border" type="text" oninput="javascript:SecondPageChecks()" id="Phone" name="Phone">
                        </div>
                        <div class="w3-margin-bottom w3-text-red" type="tel" id="PhoneError" hidden></div>
                        <div hidden id="PhoneWrittenTo">f</div>

                        <div class="w3-margin-bottom">
                            <label for="DOB">Date of Birth</label>
                            <input class="w3-input w3-border" type="date" id="DOB" name="DOB">
                        </div>

                        <div class="w3-margin-bottom">
                            <label for="Gender">Gender</label>
                            <select class="w3-input w3-border" id="Gender" name="Gender">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="N">Non-binary</option>
                                <option value="A">Agender</option>
                                <option value="O">Other</option>
                                <option value="P">Prefer not to say</option>
                            </select>
                        </div>

                        <div class="w3-margin-bottom">
                            <label for="Pronouns">Pronouns</label>
                            <input class="w3-input w3-border" type="text" oninput="javascript:SecondPageChecks()" id="Pronouns" name="Pronouns">
                        </div>
                        <div class="w3-margin-bottom w3-text-red" type="text" id="PronounsError" hidden></div>
                        <div hidden id="PronounsWrittenTo">f</div>

                        <br>
                        <input class="w3-button w3-dark-grey" type="submit" id="SubmitButton" value="Create Account" disabled>

                        <br><br>
                        <button class="w3-button w3-dark-grey" type="button" onclick="javascript:BackPage()">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
