<!DOCTYPE html>
<html>
<body>

<h1>My first PHP page</h1>
<p>
    <?php
        $servername = 'mysql-container';
        $username = 'test';
        $password = "testp";
        $dbname = "db";

        $conn = new mysqli($servername, $username, $password);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS db";
        if ($conn->query($sql) === TRUE) {
          echo "Database created successfully";
        } else {
          echo "Error creating database: " . $conn->error;
        }

        $conn->close();
    ?>
</p>
</body>
</html>
