<?php
	session_start();

	if (!isset($_POST["ID"]) || !isset($_POST["Name"]) || !isset($_POST["Description"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }"); include "./Core.php"; include "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	$sql = "UPDATE Courses SET Name = \"" . $_POST["Name"] . "\", Description = \"" . $_POST["Description"] . "\" WHERE ID = " . $_POST["ID"];
	$conn->query($sql);

	$numberOfElements = $_POST["NumberOfElements"];
	$sql = "SELECT * FROM Courses WHERE ID = " . $_POST["ID"];
	$result = $conn->query($sql);

	$currentID = $result->fetch_assoc()["FirstData"];

	for ($i = 0; $i < $numberOfElements; $i++) {
		if (!isset($_POST["Element" . $i]))
			die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

		$sql = "UPDATE CourseData SET Data = \"" . $_POST["Element" . $i] . "\" WHERE ID = " . $currentID;
		$conn->query($sql);

		$sql = "SELECT * FROM CourseData WHERE ID = " . $currentID;
		$result = $conn->query($sql);
		$currentID = $result->fetch_assoc()["NextID"];
	}

	echo "{ \"success\": \"True\" }";
	$conn->close();
?>