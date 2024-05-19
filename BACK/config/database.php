<?php
// config/database.php

class Database {
	
    public static function connectDB() {
        try {
            $dbHost = "localhost";
            $dbName = "username"; // cambiar
            $dbUser = "root"; // cambiar
            $dbPass = "pass"; // cambiar

            $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        } catch (PDOException $e) {
            // Si ocurre un error durante la conexión, lanzamos una excepción
            throw new Exception("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
    
    public static function close(PDO $connection) {
        $connection = null;
    }
}
