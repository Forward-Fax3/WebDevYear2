<?php
    if (!isset($conn))
    {
        define('DB_SERVER', 'mysql-container');
        define('DB_USERNAME', 'test');
        define('DB_PASSWORD', 'testp');
        define('DB_NAME', 'db');
    
        try {
            $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        }
        catch (Exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
?>