function AddNewTextSection() {
    const CourseID = (new URLSearchParams(window.location.search)).get("CourseID");

    const data = new FormData();
    data.append("Name", document.getElementById("Name").value);
    data.append("Text", document.getElementById("Text").value);
    data.append("CourseID", CourseID);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./backend/AddTextToCourseBack.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.response);
            if (response.success.localeCompare("True") === 0)
                window.location.href = "./EditCourse.php?CourseID=" + CourseID;
            else {
                const node = document.getElementById("error");
                node.innerHTML = response.error;
            }
        }
    }

    xhr.send(data);
}