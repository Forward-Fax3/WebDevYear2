<?php
    session_start();
    if (!isset($_SESSION["ID"])) {
    	header("Location: http://localhost:80/backend/Logout.php?reson=Invalid%20Session.<br>Please%20login%20again.");
    }

    if (!isset($_COOKIE["ID"])) {
    	header("Location: http://localhost:80/backend/Logout.php?reson=Automaticly%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    require "./backend/Core.php";
    require "./Backend/GetUser.php";

    if (!isset($_GET["CourseID"])) {
    	header("Location: http://localhost:80/HomePage.php");
    }

    $usrCourses = explode(",", $usr["CourseIndexes"]);
    $usrCourses = array_filter($usrCourses, "is_numeric");

    // check if the user has access to the course
    if (!in_array($_GET["CourseID"], $usrCourses)) {
    	header("Location: http://localhost:80/HomePage.php");
    }

    require "./backend/Core.php";
    require "./Backend/GetUser.php";
    
    if ($usr["IsTeacher"] == 0) {
    	header("Location: http://localhost:80/HomePage.php");
    }
?>

<!Doctype html>
<html lang="en">
	<head>
		<title>Ace Training</title>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
	        .w3-sidebar a {font-family: "Roboto", sans-serif}
	        body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
		</style>
		<script src="./backend/JS/SideBar.js"></script>
		<script src="./JS/AddFileToCourse.js"></script>
	</head>
	<body class="w3-content w3-light-grey">
		<?php include "./Backend/SideBar.php"; ?>
		<p class="w3-container w3-text-red" id="error" hidden>
		</p>
		<form action="javascript:AddNewFileSection()" method="post">
			<div class="w3-section w3-left-align w3-margin-left w3-margin-right">
				<label for="Name">New Section Name (this can not be changed)</label>
				<input class="w3-input w3-border w3-padding" type="text" id="Name" name="Name" required>
			</div>
			<div class="w3-section w3-left-align w3-margin-left w3-margin-right" style="width: 100%">
				<label for="File">File</label>
                <input class="w3-border" type="file" id="File" name="File" required>
			</div>
			<input class="w3-button w3-light-grey" type="submit" value="Add Section">
		</form>
	</body>
</html>
