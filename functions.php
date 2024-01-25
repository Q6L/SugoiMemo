<?php

function connectDB() {
    $pdo = new PDO("mysql:host=localhost;dbname=memo", "memo", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $pdo;
}
