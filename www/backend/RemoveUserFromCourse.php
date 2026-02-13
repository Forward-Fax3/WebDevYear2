<?php
	session_start();
	require_once "./Core.php";
	require "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	if (!isset($_POST["ID"]) || !isset($_POST["CourseID"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

	// Get the user to be removed
	$sql = "SELECT * FROM usrs WHERE ID = " . $_POST["ID"];
	$result = $conn->query($sql);

	$rusr = $result->fetch_assoc();
	$CourseID = $_POST["CourseID"];

	$courseIndexes = $rusr["CourseIndexes"];
	$courseIndexes = str_replace($CourseID, "", $courseIndexes);
	if ($courseIndexes[0] == ",")
		$courseIndexes = substr($courseIndexes, 1);
	else if ($courseIndexes[strlen($courseIndexes) - 1] == ",")
		$courseIndexes = substr($courseIndexes, 0, strlen($courseIndexes) - 1);
	else
		$courseIndexes = str_replace(",,", ",", $courseIndexes);
	$sql = "UPDATE usrs SET CourseIndexes = \"" . $courseIndexes . "\" WHERE ID = \"" . $rusr["ID"] . "\"";
	var_dump($sql);
	$conn->query($sql);

	// update course data
	$sql = "SELECT * FROM Courses WHERE ID = " . $CourseID;
	$result = $conn->query($sql);
	$courseData = $result->fetch_assoc();
	$users = $courseData["Users"];

	// done like this so that if the user has no other courses, the course will be deleted
	$users = str_replace($rusr["ID"], "", $users);
	if ($users[0] == ",")
		$users = substr($users, 1);
	else if ($users[strlen($users) - 1] == ",")
		$users = substr($users, 0, strlen($users) - 1);
	else
		$users = str_replace(",,", ",", $users);

	$sql = "UPDATE Courses SET Users = \"" . $users . "\" WHERE ID = " . $CourseID;
	$conn->query($sql);

	echo "{ \"success\": \"True\" }";
	$conn->close();
?>
