function EditCourse(){
    const id = new URLSearchParams(window.location.search).get("CourseID");

    const data = new FormData();
    data.append("ID", id);
    data.append("Name", document.getElementById("Name").value);
    data.append("Description", document.getElementById("Description").value);

    let i = 0;
    for (; document.getElementById("Element" + i) != null; i++) {
        data.append("Element" + i, document.getElementById("Element" + i).value);
    }
    data.append("NumberOfElements", i.toString());

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/EditCourseBack.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0)
                window.location.reload()
            else {
                const node = document.getElementById("error");
                node.innerHTML = response.error;
                node.hidden = false;
            }
        }
        else {
            alert("Error: " + xhr.status);
        }
    }

    xhr.send(data);
}

function RemoveElement(id) {
    const data = new FormData();
    data.append("ElementPosition", id);
    data.append("CourseID", (new URLSearchParams(window.location.search)).get("CourseID"));

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/RemoveCourseElement.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0)
                window.location.reload()
            else {
                const node = document.getElementById("error");
                node.innerHTML = response.error;
                node.hidden = false;
            }
        }
    }

    xhr.send(data);
}

function MakeTeacher(id) {
    const data = new FormData();
    data.append("ID", id);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./backend/MakeUserTeacher.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0)
                window.location.reload()
            else {
                const node = document.getElementById("error");
                node.innerHTML = response.error;
                node.hidden = false;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    }

    xhr.send(data);
}

function MakeStudent(id) {
    const data = new FormData();
    data.append("ID", id);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./backend/MakeUserStudent.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0)
                window.location.reload()
            else {
                const node = document.getElementById("error");
                node.innerHTML = response.error;
                node.hidden = false;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    }

    xhr.send(data);
}

function UserSearch() {
    const fname = document.getElementById("Fname").value;
    const surname = document.getElementById("Surname").value;
    const email = document.getElementById("Email").value;
    const usrID = document.getElementById("UsrID").value;

    if (fname === "" && surname === "" && email === "" && usrID === "")
    {
        document.getElementById("AddUserButton").disabled = true;
        document.getElementById("SearchResults").innerHTML = "";
        return;
    }

    const data = new FormData();
    data.append("Fname", fname);
    data.append("Surname", surname);
    data.append("Email", email);
    data.append("UsrID", usrID);

    const xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const node = document.getElementById("SearchResults");
            let html = "";
            if (response.length > 1) {
                for (let i = 0; i < response.length; i++) {
                    const date = new Date(response[i]["DOB"]);
                    response[i]["DOB"] = date.toLocaleDateString();
                    html = html + "<p>id: " + response[i]["ID"] + ", Name: " + response[i]["Fname"] + " " + response[i]["Surname"] + ", Email: " + response[i]["Email"] + ", Date Of Birth: " + response[i]["DOB"] + "</p>";
                }
                document.getElementById("AddUserButton").disabled = true;
            } else if (response.length === 1) {
                document.getElementById("AddUserButton").disabled = false;
                html = html + "<p>id: " + response[0]["ID"] + ", Name: " + response[0]["Fname"] + " " + response[0]["Surname"] + ", Email: " + response[0]["Email"] + ", Date Of Birth: " + response[0]["DOB"] + "</p>";
            }
            node.innerHTML = html;
        } else {
            alert("Error: " + xhr.status);
        }
    }
    xhr.open("POST", "http://localhost:80/backend/SearchUsers.php", true);

    xhr.send(data);
}

function AddUser() {
    const data = new FormData();
    data.append("Fname", document.getElementById("Fname").value);
    data.append("Surname", document.getElementById("Surname").value);
    data.append("Email", document.getElementById("Email").value);
    data.append("UsrID", document.getElementById("UsrID").value);
    data.append("CourseID", new URLSearchParams(window.location.search).get("CourseID"));

    const xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0) {
                window.location.reload();
            } else {
                const node = document.getElementById("error");
                node.innerHTML = response.error;
                node.hidden = false;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    }
    xhr.open("POST", "http://localhost:80/backend/AddUserToCourse.php", true);
    xhr.send(data);
}

function RemoveUser(id) {
    const courseID = new URLSearchParams(window.location.search).get("CourseID");
    const data = new FormData();
    data.append("ID", id);
    data.append("CourseID", courseID);

    console.log(data);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/RemoveUserFromCourse.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.reload();
        }
    }

    xhr.send(data);
}
