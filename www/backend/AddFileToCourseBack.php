<?php
	session_start();
	include "./Core.php";
	include "./GetUser.php";

	if ($usr["IsTeacher"] == 0)
		die("{ \"success\": \"False\", \"error\": \"You are not authorized to access this page.\" }");

	if (!isset($_POST["Name"]) || !isset($_FILES["File"]) || !isset($_POST["CourseID"]))
		die("{ \"success\": \"False\", \"error\": \"Invalid input.\" }");

	$sql = "SELECT * FROM Courses WHERE ID = " . $_POST["CourseID"];
	$result = $conn->query($sql);
	$courseData = $result->fetch_assoc();
	$currentID = $courseData["FirstData"];

	$allowedTypes = ["pdf", "docx", "xlsx", "pptx", "txt", "zip", "rar", "7z", "jpg", "jpeg", "png", "gif", "bmp", "svg", "mp4", "avi", "mkv", "mp3", "wav", "ogg"];
	$fileType = pathinfo($_FILES["File"]["name"], PATHINFO_EXTENSION);

	if (!in_array($fileType, $allowedTypes))
		die("{ \"success\": \"False\", \"error\": \"Invalid file type.\" }");

	$newFileName = time() . $_FILES["File"]["name"];
	$filePath = "files/" . $_POST["CourseID"] . "/";
	if (!file_exists("../" . $filePath))
		mkdir("../" . $filePath, 0777, true);
	$filePath .= "/" . $newFileName;

	// setup json
	$JSON = new stdClass();
	$JSON->Name = $_FILES["File"]["name"];
	$JSON->Size = $_FILES["File"]["size"];
	$JSON->FilePath = $filePath;
	$JSON = json_encode($JSON);

	if ($currentID == NULL) {
		$sql = "INSERT INTO CourseData (Type, Name, Data) VALUES (1, \"" . $_POST["Name"] . "\", \"" . $conn->real_escape_string($JSON) . "\")";
		$conn->query($sql);
		$currentID = $conn->insert_id;
		$sql = "UPDATE Courses SET FirstData = " . $currentID . " WHERE ID = " . $_POST["CourseID"];
		$conn->query($sql);
		move_uploaded_file($_FILES["File"]["tmp_name"], "../" . $filePath);
	} else {
		while (true) {
			$sql = "SELECT * FROM CourseData WHERE ID = " . $currentID;
			$result = $conn->query($sql);
			$data = $result->fetch_assoc();

			if ($data["NextID"] == NULL)
				break;

			$currentID = $data["NextID"];
		}
		$sql = "INSERT INTO CourseData (Type, Name, Data) VALUES (1, \"" . $_POST["Name"] . "\", \"" . $conn->real_escape_string($JSON) . "\")";
		$conn->query($sql);
		$newID = $conn->insert_id;
		$sql = "UPDATE CourseData SET NextID = " . $newID . " WHERE ID = " . $data["ID"];
		$conn->query($sql);
		move_uploaded_file($_FILES["File"]["tmp_name"], "../" . $filePath);
	}

	echo "{ \"success\": \"True\" }";
	$conn->close();
?>