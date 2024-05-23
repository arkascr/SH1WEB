<?php
try {
    $dsn = "mysql:host=localhost;port=3307;dbname=biblioteca;charset=utf8mb4";
    $dbUser = "root";
    $dbPass = "";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $dbConnection = new PDO($dsn, $dbUser, $dbPass, $options);
    echo "Connected successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}