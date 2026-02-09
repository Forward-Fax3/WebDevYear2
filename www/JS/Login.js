function SendRequest(XML_URL, data, url) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", XML_URL , true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0) {
                window.location.href = url;
            } else {
                const node = document.getElementById("error");
                node.innerHTML = response.error;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    };

    xhr.send(data);
}

function PostLoginRequest() {
    const formData = new FormData();
    formData.append("Email", document.getElementById("Email").value);
    formData.append("Psw", document.getElementById("Psw").value);

    let url = $.cookie("ReturnURL");
    if (url === undefined || url == null) {
        url = "http://localhost:80/HomePage.php";
    } else {
        $.removeCookie("ReturnURL");
    }

    const XML_URL = "http://localhost:80/backend/LoginVerify.php";
    SendRequest(XML_URL, formData, url);
}

function CreateAccount() {
    const formData = new FormData();
    formData.append("Email", document.getElementById("Email").value);
    formData.append("Psw", document.getElementById("Psw").value);
    formData.append("FName", document.getElementById("FName").value);
    formData.append("Surname", document.getElementById("Surname").value);
    formData.append("Phone", document.getElementById("Phone").value);
    formData.append("DOB", document.getElementById("DOB").value);
    formData.append("Gender", document.getElementById("Gender").value);
    formData.append("Pronouns", document.getElementById("Pronouns").value);

    const XML_URL = "http://localhost:80/backend/CreateAccountBack.php";
    let url = "http://localhost:80/Login.php";
    SendRequest(XML_URL, formData, url);
}

function ShowPassword() {
    const passwordField = document.getElementById("Psw");
    const eye = document.getElementById("Eye");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eye.className = "fa fa-eye-slash";
    } else {
        passwordField.type = "password";
        eye.className = "fa fa-eye";
    }
}

function ShowPasswordAgain() {
    const passwordField = document.getElementById("PswA");
    const eye = document.getElementById("EyeA");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eye.className = "fa fa-eye-slash";
    } else {
        passwordField.type = "password";
        eye.className = "fa fa-eye";
    }
}

function CheckPassword() {
    const EmailField = document.getElementById("Email");
    const passwordField = document.getElementById("Psw");
    const passwordAgainField = document.getElementById("PswA");
    const EmailCheck = document.getElementById("EmailCheck");
    const charCheck = document.getElementById("CharCheck");
    const passwordCheck = document.getElementById("PasswordCheck");
    const nextButton = document.getElementById("NextButton");
    let boolLengthSatisfied = false;
    let boolMatchSatisfied = false;

    if (EmailField.value.length > 255) {
        EmailCheck.hidden = false;
        EmailCheck.innerHTML = "Email must be less than 256 characters long.";
    } else {
        EmailCheck.hidden = true;
    }

    if (passwordField.value.length === 0) {
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

    if (passwordAgainField.value.length === 0) {
        return;
    }

    if (passwordField.value === passwordAgainField.value) {
        passwordCheck.style.color = 'green';
        passwordCheck.innerHTML = 'Passwords Match';
        passwordCheck.hidden = false;
        boolMatchSatisfied = true;
    } else {
        passwordCheck.style.color = 'red';
        passwordCheck.innerHTML = 'Passwords Do Not Match';
        passwordCheck.hidden = false;
    }

    nextButton.disabled = !(boolLengthSatisfied && boolMatchSatisfied && EmailField.value.length > 0);
}

function NextPage() {
    const formData = new FormData();
    formData.append("Email", document.getElementById("Email").value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/CheckIfEmailExists.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const errorField = document.getElementById("error");
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
    let fNameSatisfied = false;
    let sNameSatisfied = false;
    let phoneSatisfied = false;
    let pronounsSatisfied = false;

    {
        const FName = document.getElementById("FName").value;
        const FNameErrorField = document.getElementById("FNameError");
        const FNameWrittenTo = document.getElementById("FNameWrittenTo");

        if (FName.length === 0 && FNameWrittenTo.innerHTML === 't') {
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
        const sName = document.getElementById("Surname").value;
        const SNameErrorField = document.getElementById("SurnameError");
        const SNameWrittenTo = document.getElementById("SurnameWrittenTo");

        if (sName.length === 0 && SNameWrittenTo.innerHTML === 't') {
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

    PhoneNumberTest: {
        const Phone = document.getElementById("Phone").value;
        const PhoneErrorField = document.getElementById("PhoneError");
        const PhoneWrittenTo = document.getElementById("PhoneWrittenTo");

        if (Phone.length === 0 && PhoneWrittenTo.innerHTML === 't') {
            PhoneErrorField.hidden = false;
            PhoneErrorField.innerHTML = "Phone Number is required.";
            break PhoneNumberTest;
        } else if (Phone.length > 0) {
            PhoneWrittenTo.innerHTML = 't';
        }

        if (Phone.length > 63) {
            PhoneErrorField.hidden = false;
            PhoneErrorField.innerHTML = "Phone Number must be less than 64 numbers long.";
            break PhoneNumberTest;
        } 

        for (let i = 0; i < Phone.length; i++) {
            if (Phone[i] < '0' || Phone[i] > '9') {
                PhoneErrorField.hidden = false;
                PhoneErrorField.innerHTML = "Phone Number must only contain numbers.";
                break PhoneNumberTest;
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
        const Pronouns = document.getElementById("Pronouns").value;
        const PronounsErrorField = document.getElementById("PronounsError");
        const PronounsWrittenTo = document.getElementById("PronounsWrittenTo");

        if (Pronouns.length === 0 && PronounsWrittenTo.innerHTML === 't') {
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

    document.getElementById("SubmitButton").disabled = !(fNameSatisfied && sNameSatisfied && phoneSatisfied && pronounsSatisfied);
}
