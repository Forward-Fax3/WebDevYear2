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
                window.location.href = "http://localhost:80/HomePage.php";
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