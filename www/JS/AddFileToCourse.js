function AddNewFileSection() {
    const courseID = (new URLSearchParams(window.location.search)).get("CourseID");
    const data = new FormData();
    data.append("Name", document.getElementById("Name").value);
    data.append("File", document.getElementById("File").files[0]);
    data.append("CourseID", courseID);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./backend/AddFileToCourseBack.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.response);
            if (response.success.localeCompare("True") === 0)
                window.location.href = "./EditCourse.php?CourseID=" + courseID;
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