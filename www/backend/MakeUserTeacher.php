<?php
	session_start();
	include "./Core.php";
	include "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	if (!isset($_POST["ID"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

	$sql = "SELECT * FROM usrs WHERE ID = " . $_POST["ID"];
	$result = $conn->query($sql);
	$ousr = $result->fetch_assoc();

	$sql = "UPDATE usrs SET IsTeacher = 1 WHERE ID = " . $ousr["ID"];
	$conn->query($sql);

	echo "{ \"success\": \"True\" }";
	$conn->close();
?>
