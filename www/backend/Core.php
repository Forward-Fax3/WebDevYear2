<?php
    if (isset($conn))
		return;

    define('DB_SERVER', 'mysql-container');
    define('DB_USERNAME', 'test');
    define('DB_PASSWORD', 'testp');
    define('DB_NAME', 'db');

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // check for users table
    try {
        $sql = "SELECT 1 FROM usrs LIMIT 1";
        $result = $conn->query($sql);
		$sql = "SELECT 1 FROM Courses LIMIT 1";
		$result = $conn->query($sql);
		$sql = "SELECT 1 FROM CourseData LIMIT 1";
		$result = $conn->query($sql);
    } catch (Exception $e) {
        try
        {
            $sql = "CREATE TABLE IF NOT EXISTS usrs (
                ID int UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
                Email varchar(255) NOT NULL,
                Psw varchar(255) NOT NULL,
                Fname varchar(255) NOT NULL,
                Surname varchar(255) NOT NULL,
                Phone varchar(63) NOT NULL,
                DOB date NOT NULL,
                Gender varchar(15) NOT NULL,
                Pronouns varchar(63) NOT NULL,
                IsTeacher boolean NOT NULL DEFAULT 0,
                CourseIndexes text NOT NULL
            );";
            $conn->query($sql);

            $sql = "CREATE TABLE IF NOT EXISTS Courses (
                ID int UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
                Name varchar(255) NOT NULL,
                Description text NOT NULL,
    			Users text NOT NULL,
    			FirstData int DEFAULT NULL
            );";
            $conn->query($sql);

			$sql = "CREATE TABLE IF NOT EXISTS CourseData (
    			ID int UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
    			Type int NOT NULL,
    			Name varchar(255) NOT NULL,
    			Data text NOT NULL,
    			NextID int DEFAULT NULL
    		);";
			$conn->query($sql);
        } catch (Exception $e) {
            die( sprintf("{ \"success\": \"False\", \"error\": \"%s\" }", $e->getMessage()) );
        }
    }
?>