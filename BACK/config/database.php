<?php
// config/database.php

class Database {
	
    public static function connectDB() {
        try {
			$dsn = "mysql:host=localhost;port=3307;dbname=biblioteca;";
			$dbUser = "root";
			$dbPass = "";

			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];

			$dbConnection = new PDO($dsn, $dbUser, $dbPass, $options);
			return $dbConnection;
			//echo "Connected successfully!";
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
    }
    
    public static function close(PDO $connection) {
        $connection = null;
    }
}
