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

	if (!isset($_GET["FileID"])) {
		header("Location: http://localhost:80/HomePage.php");
	}
	$sql = "SELECT * FROM CourseData WHERE ID = " . (int)$_GET["FileID"];
	$result = $conn->query($sql);
	if ($result->num_rows == 0) {
		$conn->close();
		die("no file found");
	}
	$fileData = json_decode($result->fetch_assoc()["Data"]);

	header("Content-Disposition: attachment; filename=\"" . $fileData->Name . "\"");
	header("Content-Length: " . $fileData->Size);
	readfile("../" . $fileData->FilePath);
	$conn->close();
?>