<?php
	session_start();

	if (!isset($_POST["ID"]) || !isset($_POST["Name"]) || !isset($_POST["Description"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }"); include "./Core.php"; include "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	$sql = "UPDATE Courses SET Name = \"" . $_POST["Name"] . "\", Description = \"" . $_POST["Description"] . "\" WHERE ID = " . $_POST["ID"];
	$conn->query($sql);

	$numberOfElements = $_POST["NumberOfElements"];
	$sql = "SELECT FirstData FROM Courses WHERE ID = " . $_POST["ID"];
	$result = $conn->query($sql);
	$sql = "SELECT * FROM CourseData WHERE ID = " . $result->fetch_assoc()["FirstData"];
	$result = $conn->query($sql);
	$currentElement = $result->fetch_assoc();

	for ($i = 0; $i < $numberOfElements; $i++) {
		if (!isset($_POST["Element" . $i]))
			die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");
		
		if ((int)$currentElement["Type"] == 0)
		{
			$sql = "UPDATE CourseData SET Data = \"" . $_POST["Element" . $i] . "\" WHERE ID = " . $currentElement["ID"];
			$conn->query($sql);
		}

		if ($currentElement["NextID"] == NULL)
			continue; // this should end the loop

		$sql = "SELECT * FROM CourseData WHERE ID = " . $currentElement["NextID"];
		$result = $conn->query($sql);
		$currentElement = $result->fetch_assoc();
	}

	echo "{ \"success\": \"True\" }";
	$conn->close();
?>