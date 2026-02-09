function CreateCourse() {
    const formData = new FormData();
    formData.append("Name", document.getElementById("Name").value);
    formData.append("Description", document.getElementById("Description").value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:80/backend/CreateCourseBack.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success.localeCompare("True") === 0)
                window.location.href = "http://localhost:80/EditCourse.php?CourseId=" + response.id;
            else {
                const node = document.getElementById("error");

                node.innerHTML = response.error;
                node.hidden = false;
            }
        } else {
            alert("Error: " + xhr.status);
        }
    };

    xhr.send(formData);
}
