<?php
session_start();

$host = "localhost";
$db = "abdollah_builder";
$user = "root";
$pass = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    exit("Database connection failed.");
}

function loggedIn() {
    return isset($_SESSION["user_id"]);
}

function requireLogin() {
    if (!loggedIn()) {
        header("Location: login.php");
        exit;
    }
}
