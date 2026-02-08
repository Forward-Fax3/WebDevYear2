<?php
    if ($_SERVER["REQUEST_METHOD"] != "POST" ||
        !isset($_POST['Email']) ||
        !isset($_POST['Psw']) ||
        !isset($_POST['FName']) ||
        !isset($_POST['Surname']) ||
        !isset($_POST['Phone']) ||
        !isset($_POST['DOB']) ||
        !isset($_POST['Gender']) ||
        !isset($_POST['Pronouns'])) {
        die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");
    }

    require_once "Core.php";

    $Email = $conn->real_escape_string($_POST["Email"]);
    $Psw = $conn->real_escape_string(password_hash($_POST["Psw"], PASSWORD_DEFAULT));

    $FName = $conn->real_escape_string($_POST["FName"]);
    $Surname = $conn->real_escape_string($_POST["Surname"]);
    $Phone = $conn->real_escape_string($_POST["Phone"]);
    $DOB = $conn->real_escape_string($_POST["DOB"]);
    $Gender = $conn->real_escape_string($_POST["Gender"]);
    $Pronouns = $conn->real_escape_string($_POST["Pronouns"]);
    $CourseIndexes = "";

    $sql = "INSERT INTO usrs (Email, Psw, Fname, Surname, Phone, DOB, Gender, Pronouns, CourseIndexes) VALUES (\"$Email\", \"$Psw\", \"$FName\", \"$Surname\", \"$Phone\", \"$DOB\", \"$Gender\", \"$Pronouns\", \"$CourseIndexes\")";
    $conn->query($sql);

    // check if first user
    $sql = "SELECT * FROM usrs";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $sql = "UPDATE usrs SET IsTeacher = 1 WHERE Email = \"$Email\"";
        $conn->query($sql);
    }

    echo "{ \"success\": \"True\" }";

    $conn->close();
?>
