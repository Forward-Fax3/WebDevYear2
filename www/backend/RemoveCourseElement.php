<?php
	session_start();
	include "./Core.php";
	include "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	if (!isset($_POST["CourseID"]) || !isset($_POST["ElementPosition"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

	$sql = "SELECT * FROM Courses WHERE ID = " . $_POST["CourseID"];
	$result = $conn->query($sql);
	$courseData = $result->fetch_assoc();
	$previousID = NULL;
	$currentID = $courseData["FirstData"];

	for ($i = 0; $i < $_POST["ElementPosition"]; $i++) {
		$sql = "SELECT * FROM CourseData WHERE ID = " . $currentID;
		$result = $conn->query($sql);
		$data = $result->fetch_assoc();

		if ($data["NextID"] == NULL)
			die("{ \"success\": \"False\", \"error\": \"Invalid input. NextID is NULL!\" }");
		$previousID = $currentID;
		$currentID = $data["NextID"];
	}

	$sql = "SELECT * FROM CourseData WHERE ID = " . $currentID;
	$result = $conn->query($sql);
	$data = $result->fetch_assoc();

	if ($data["NextID"] == NULL) {
		if ($previousID == NULL) {
			$sql = "UPDATE Courses SET FirstData = NULL WHERE ID = " . $_POST["CourseID"];
			$conn->query($sql);
		} else {
			$sql = "UPDATE CourseData SET NextID = NULL WHERE ID = " . $previousID;
			$conn->query($sql);
		}
	} else {
		if ($previousID == NULL) {
			$sql = "UPDATE Courses SET FirstData = " . $data["NextID"] . " WHERE ID = " . $_POST["CourseID"];
			$conn->query($sql);
		} else {
			$sql = "UPDATE CourseData SET NextID = " . $data["NextID"] . " WHERE ID = " . $previousID;
			$conn->query($sql);
		}
	}

	$sql = "DELETE FROM CourseData WHERE ID = " . $currentID;
	$conn->query($sql);

	if ($data["Type"] == 1) {
		$data = json_decode($data["Data"]);
		if (file_exists("../" . $data->FilePath))
			unlink("../" . $data->FilePath);
	}

	echo "{ \"success\": \"True\" }";
	$conn->close();
?>