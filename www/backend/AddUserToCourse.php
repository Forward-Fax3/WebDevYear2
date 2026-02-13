<?php
	session_start();
	include "./Core.php";
	include "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	if (!isset($_POST["Fname"]) || !isset($_POST["Surname"]) || !isset($_POST["Email"]) || !isset($_POST["UsrID"]) || !isset($_POST["CourseID"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

	$sql = "SELECT * FROM usrs WHERE FName LIKE \"%" . $_POST["Fname"] . "%\" AND Surname LIKE \"%" . $_POST["Surname"] . "%\" AND Email LIKE \"%" . $_POST["Email"] . "%\" AND ID LIKE \"%" . $_POST["UsrID"] . "%\"";
	$result = $conn->query($sql);

	if ($result->num_rows == 2) {
		for ($i = 0; $i < $result->num_rows; $i++) {
			if ($result->fetch_assoc()["ID"] != $_SESSION["ID"])
				continue;

			$Ausr = $result->fetch_assoc();
			break;
		}
	} else if ($result->num_rows != 1)
		die("{ \"success\": \"False\", \"error\": \"Something went wrong. Please try again.\" }");
	else
		$Ausr = $result->fetch_assoc();

	$CourseID = $_POST["CourseID"];

	if ($Ausr["CourseIndexes"] == null || $Ausr["CourseIndexes"] == "")
		$Ausr["CourseIndexes"] = $CourseID;
	else
		$Ausr["CourseIndexes"] = $Ausr["CourseIndexes"] . "," . $CourseID;
	$sql = "UPDATE usrs SET CourseIndexes = \"" . $Ausr["CourseIndexes"] . "\" WHERE ID = " . $Ausr["ID"];
	$conn->query($sql);

	$sql = "SELECT * FROM Courses WHERE ID = " . $CourseID;
	$result = $conn->query($sql);
	$courseData = $result->fetch_assoc();
	$users = $courseData["Users"];

	if ($users == "")
		$users = $Ausr["ID"];
	else
		$users = $users . "," . $Ausr["ID"];

	$sql = "UPDATE Courses SET Users = \"" . $users . "\" WHERE ID = " . $CourseID;
	$conn->query($sql);

	echo "{ \"success\": \"True\" }";
	$conn->close();
?>
