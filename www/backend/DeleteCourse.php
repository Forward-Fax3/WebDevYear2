<?php
	session_start();
	if (!isset($_SESSION["ID"])) {
		header("Location: http://localhost:80/backend/Logout.php?reson=Invalid%20Session.<br>Please%20login%20again.");
	}

	if (!isset($_COOKIE["ID"])) {
		header("Location: http://localhost:80/backend/Logout.php?reson=Automatically%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
	}

	require "./Core.php";
	require "./GetUser.php";

	if (!isset($_GET["CourseID"])) {
		header("Location: http://localhost:80/HomePage.php");
	}
	$sql = "SELECT * FROM Courses WHERE ID = " . (int)$_GET["CourseID"];
	$result = $conn->query($sql);
	if ($result->num_rows == 0) {
		$conn->close();
		die("no course found");
	}
	$data = $result->fetch_assoc();

	$sql = "DELETE FROM Courses WHERE ID = " . (int)$_GET["CourseID"];
	$conn->query($sql);

	$nextDataID = $data["FirstData"];

	while ($nextDataID != NULL) {
		$sql = "SELECT * FROM CourseData WHERE ID = " . (int)$nextDataID;
		$result = $conn->query($sql);
		$data = $result->fetch_assoc();
		$nextDataID = $data["NextID"];

		if ($data["Type"] == 1) {
			$fileData = json_decode($data["Data"]);
			unlink("../" . $fileData->FilePath);
		}

		$sql = "DELETE FROM CourseData WHERE ID = " . (int)$data["ID"];
		$conn->query($sql);
	}

	header("Location: http://localhost:80/HomePage.php");
?>
