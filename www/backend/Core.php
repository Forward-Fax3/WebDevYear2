<?php
    if (!isset($conn))
    {
        define('DB_SERVER', 'mysql-container');
        define('DB_USERNAME', 'test');
        define('DB_PASSWORD', 'testp');
        define('DB_NAME', 'db');
    
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // check for users table
        try {
            $sql = "SELECT 1 FROM usrs LIMIT 1";
            $result = $conn->query($sql);
        } catch (Exception $e) {
            try
            {
                $sql = "CREATE TABLE IF NOT EXISTS usrs (
                    ID int(11) UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
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
                )";
                $conn->query($sql);

                $sql = "CREATE TABLE IF NOT EXISTS Courses (
                    ID int(11) UNIQUE NOT NULL AUTO_INCREMENT,
                    Name varchar(255) NOT NULL,
                    CourseLayout text NOT NULL,
                    Description text NOT NULL,
                    CourseData JSON NOT NULL,
                    PRIMARY KEY (ID)
                );";
                $conn->query($sql);
            } catch (Exception $e) {
                die( sprintf("{ \"success\": \"False\", \"error\": \"%s\" }", $e->getMessage()) );
            }
        }
    }
?>