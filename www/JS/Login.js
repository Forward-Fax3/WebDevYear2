function PostLoginRequest() {
    var formData = new FormData();
    formData.append("Email", document.getElementById("Email").value);
    formData.append("Psw", document.getElementById("Psw").value);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/LoginVerify.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0) {
                url = $.cookie("ReturnURL");
                if (url === undefined || url == null) {
                    url = "http://localhost:80/HomePage.php";
                } else {
                    $.removeCookie("ReturnURL");
                }
                window.location.href = url;
            } else {
                node = document.getElementById("error");
                node.innerHTML = response.error;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    };

    xhr.send(formData);
}

function CreateAccount() {
    var formData = new FormData();
    formData.append("Email", document.getElementById("Email").value);
    formData.append("Psw", document.getElementById("Psw").value);
    formData.append("FName", document.getElementById("FName").value);
    formData.append("Surname", document.getElementById("Surname").value);
    formData.append("Phone", document.getElementById("Phone").value);
    formData.append("DOB", document.getElementById("DOB").value);
    formData.append("Gender", document.getElementById("Gender").value);
    formData.append("Pronouns", document.getElementById("Pronouns").value);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/CreateAccountBack.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0) {
                window.location.href = "http://localhost:80/Login.php";
            } else {
                node = document.getElementById("error");
                node.innerHTML = response.error;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    };

    xhr.send(formData);
}

function ShowPassword() {
    var passwordField = document.getElementById("Psw");
    var eye = document.getElementById("Eye");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eye.className = "fa fa-eye-slash";
    } else {
        passwordField.type = "password";
        eye.className = "fa fa-eye";
    }
}

function ShowPasswordAgain() {
    var passwordField = document.getElementById("PswA");
    var eye = document.getElementById("EyeA");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eye.className = "fa fa-eye-slash";
    } else {
        passwordField.type = "password";
        eye.className = "fa fa-eye";
    }
}

function CheckPassword() {
    var EmailField = document.getElementById("Email");
    var passwordField = document.getElementById("Psw");
    var passwordAgainField = document.getElementById("PswA");
    var EmailCheck = document.getElementById("EmailCheck");
    var charCheck = document.getElementById("CharCheck");
    var passwordCheck = document.getElementById("PasswordCheck");
    var nextButton = document.getElementById("NextButton");
    var boolLengthSatisfied = false;
    var boolMatchSatisfied = false;

    if (EmailField.value.length > 255) {
        EmailCheck.hidden = false;
        EmailCheck.innerHTML = "Email must be less than 256 characters long.";
    } else {
        EmailCheck.hidden = true;
    }

    if (passwordField.value.length == 0) {
        charCheck.hidden = true;
        return;
    }

    if (passwordField.value.length < 8) {
        charCheck.hidden = false;
        charCheck.innerHTML = "Password must be at least 8 characters long.";
    } else if (passwordField.value.length > 255) {
        charCheck.hidden = false;
        charCheck.innerHTML = "Password must be less than 256 characters long.";
    } else {
        charCheck.hidden = true;
        boolLengthSatisfied = true;
    }

    if (passwordAgainField.value.length == 0) {
        return;
    }

    if (passwordField.value == passwordAgainField.value) {
        passwordCheck.style.color = 'green';
        passwordCheck.innerHTML = 'Passwords Match';
        passwordCheck.hidden = false;
        boolMatchSatisfied = true;
    } else {
        passwordCheck.style.color = 'red';
        passwordCheck.innerHTML = 'Passwords Do Not Match';
        passwordCheck.hidden = false;
    }

    if (boolLengthSatisfied && boolMatchSatisfied && EmailField.value.length > 0) {
        nextButton.disabled = false;
    } else {
        nextButton.disabled = true;
    }
}

function NextPage() {
    var formData = new FormData();
    formData.append("Email", document.getElementById("Email").value);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/CheckIfEmailExists.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var errorField = document.getElementById("error");
            if (response.success.localeCompare("True") === 0) {
                document.getElementById("FirstPage").hidden = true;
                document.getElementById("SecondPage").hidden = false;
                document.getElementById("Page1Title").hidden = true;
                document.getElementById("Page2Title").hidden = false;
                errorField.hidden = true;
                errorField.innerHTML = "";
                document.getElementById("Form").action = "javascript:CreateAccount()";
            } else {
                errorField.innerHTML = response.error;
                errorField.hidden = false;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    };

    xhr.send(formData);
}

function BackPage() {
    document.getElementById("FirstPage").hidden = false;
    document.getElementById("SecondPage").hidden = true;
    document.getElementById("Page1Title").hidden = false;
    document.getElementById("Page2Title").hidden = true;

    document.getElementById("FNameWrittenTo").innerHTML = 'f';
    document.getElementById("FNameError").hidden = true;
    document.getElementById("SurnameWrittenTo").innerHTML = 'f';
    document.getElementById("SurnameError").hidden = true;
    document.getElementById("PhoneWrittenTo").innerHTML = 'f';
    document.getElementById("PhoneError").hidden = true;
    document.getElementById("PronounsWrittenTo").innerHTML = 'f';
    document.getElementById("PronounsError").hidden = true;

    document.getElementById("Form").action = "javascript:NextPage()";
}

function SecondPageChecks() {
    var fNameSatisfied = false;
    var sNameSatisfied = false;
    var phoneSatisfied = false;
    var pronounsSatisfied = false;

    {
        var FName = document.getElementById("FName").value;
        var FNameErrorField = document.getElementById("FNameError");
        var FNameWrittenTo = document.getElementById("FNameWrittenTo");

        if (FName.length == 0 && FNameWrittenTo.innerHTML == 't') {
            FNameErrorField.hidden = false;
            FNameErrorField.innerHTML = "First Name is required.";
        } else if (FName.length > 255) {
            FNameErrorField.hidden = false;
            FNameErrorField.innerHTML = "First Name must be less than 256 characters long.";
        } else {
            FNameErrorField.hidden = true;
        }

        if (FName.length > 0) {
            FNameWrittenTo.innerHTML = 't';
        }

        if (FName.length > 0 && FName.length <= 255) {
            fNameSatisfied = true;
        }
    }

    {
        var sName = document.getElementById("Surname").value;
        var SNameErrorField = document.getElementById("SurnameError");
        var SNameWrittenTo = document.getElementById("SurnameWrittenTo");

        if (sName.length == 0 && SNameWrittenTo.innerHTML == 't') {
            SNameErrorField.hidden = false;
            SNameErrorField.innerHTML = "Last Name is required.";
        } else if (sName.length > 255) {
            SNameErrorField.hidden = false;
            SNameErrorField.innerHTML = "Last Name must be less than 256 characters long.";
        } else {
            SNameErrorField.hidden = true;
        }

        if (sName.length > 0) {
            SNameWrittenTo.innerHTML = 't';
        }

        if (sName.length > 0 && sName.length <= 255) {
            sNameSatisfied = true;
        }
    }

    PhoneNumbertest: {
        var Phone = document.getElementById("Phone").value;
        var PhoneErrorField = document.getElementById("PhoneError");
        var PhoneWrittenTo = document.getElementById("PhoneWrittenTo");

        if (Phone.length == 0 && PhoneWrittenTo.innerHTML == 't') {
            PhoneErrorField.hidden = false;
            PhoneErrorField.innerHTML = "Phone Number is required.";
            break PhoneNumbertest;
        } else if (Phone.length > 0) {
            PhoneWrittenTo.innerHTML = 't';
        }

        if (Phone.length > 63) {
            PhoneErrorField.hidden = false;
            PhoneErrorField.innerHTML = "Phone Number must be less than 64 numbers long.";
            break PhoneNumbertest;
        } 

        for (var i = 0; i < Phone.length; i++) {
            if (Phone[i] < '0' || Phone[i] > '9') {
                PhoneErrorField.hidden = false;
                PhoneErrorField.innerHTML = "Phone Number must only contain numbers.";
                break PhoneNumbertest;
            }
        }

        PhoneErrorField.hidden = true;
        phoneSatisfied = true;
    }

    {
        //var DateOfBirthErrorField = document.getElementById("DateOfBirthError");
        //
        //if (DateOfBirth.length == 0) {
        //    DateOfBirthErrorField.hidden = false;
        //    DateOfBirthErrorField.innerHTML = "Date of Birth is required.";
        //} else if (DateOfBirth.length > 255) {
        //    DateOfBirthErrorField.hidden = false;
        //    DateOfBirthErrorField.innerHTML = "Date of Birth must be less than 256 characters long.";
        //} else {
        //    document.getElementById("DateOfBirthError").hidden = true;
        //}
    }

    {
        var Pronouns = document.getElementById("Pronouns").value;
        var PronounsErrorField = document.getElementById("PronounsError");
        var PronounsWrittenTo = document.getElementById("PronounsWrittenTo");

        if (Pronouns.length == 0 && PronounsWrittenTo.innerHTML == 't') {
            PronounsErrorField.hidden = false;
            PronounsErrorField.innerHTML = "Pronouns is required.";
        } else if (Pronouns.length > 63) {
            PronounsErrorField.hidden = false;
            PronounsErrorField.innerHTML = "Pronouns must be less than 64 characters long.";
        } else {
            PronounsErrorField.hidden = true;
        }

        if (Pronouns.length > 0) {
            PronounsWrittenTo.innerHTML = 't';
        }

        if (Pronouns.length > 0 && Pronouns.length <= 63) {
            pronounsSatisfied = true;
        }
    }

    if (fNameSatisfied && sNameSatisfied && phoneSatisfied && pronounsSatisfied) {
        document.getElementById("SubmitButton").disabled = false;
    }
}
