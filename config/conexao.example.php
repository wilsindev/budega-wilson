<?php 
$pdo = new PDO(
    "mysql:host=mysql;dbname=" . getenv('MYSQL_DATABASE') . ";charset=utf8mb4",
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD'),
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]
);
?>