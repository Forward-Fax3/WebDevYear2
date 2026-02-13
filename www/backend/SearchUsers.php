<?php
	session_start();
	require "./Core.php";
	require "./GetUser.php";

	if (!$usr["IsTeacher"])
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	if (!isset($_POST["Fname"]) || !isset($_POST["Surname"]) || !isset($_POST["Email"]) || !isset($_POST["UsrID"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

	$sql = "SELECT * FROM usrs WHERE FName LIKE \"%" . $_POST["Fname"] . "%\" AND Surname LIKE \"%" . $_POST["Surname"] . "%\" AND Email LIKE \"%" . $_POST["Email"] . "%\" AND ID LIKE \"%" . $_POST["UsrID"] . "%\"";
	$result = $conn->query($sql);

	$users = array();
	while ($row = $result->fetch_assoc()) {
		// Don't show the current user'
		if ($row["ID"] == $_SESSION["ID"])
			continue;

		unset($row["Psw"]);
		unset($row["CourseIndexes"]);
		unset($row["IsTeacher"]);
		unset($row["Phone"]);
		$users[] = $row;
	}
	echo json_encode($users);
?>