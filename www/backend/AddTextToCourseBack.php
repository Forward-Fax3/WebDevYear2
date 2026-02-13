<?php
	session_start();
	include "./Core.php";
	include "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	if (!isset($_POST["Name"]) || !isset($_POST["Text"]) || !isset($_POST["CourseID"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

	$sql = "SELECT * FROM Courses WHERE ID = " . $_POST["CourseID"];
	$result = $conn->query($sql);
	$courseData = $result->fetch_assoc();
	$currentID = $courseData["FirstData"];

	if ($currentID == NULL) {
		$sql = "INSERT INTO CourseData (Type, Name, Data) VALUES (0, \"" . $_POST["Name"] . "\", \"" . $_POST["Text"] . "\")";
		$conn->query($sql);
		$currentID = $conn->insert_id;
		$sql = "UPDATE Courses SET FirstData = " . $currentID . " WHERE ID = " . $_POST["CourseID"];
		$conn->query($sql);
		echo "{ \"success\": \"True\" }";
	} else {
		while (true) {
			$sql = "SELECT * FROM CourseData WHERE ID = " . $currentID;
			$result = $conn->query($sql);
			$data = $result->fetch_assoc();

			if ($data["NextID"] == NULL)
				break;

			$currentID = $data["NextID"];
		}
		$sql = "INSERT INTO CourseData (Type, Name, Data) VALUES (0, \"" . $_POST["Name"] . "\", \"" . $_POST["Text"] . "\")";
		$conn->query($sql);

		$newID = $conn->insert_id;
		$sql = "UPDATE CourseData SET NextID = " . $newID . " WHERE ID = " . $data["ID"];
		$conn->query($sql);
		echo "{ \"success\": \"True\" }";
	}

	$conn->close();
?>