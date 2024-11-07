<?php
//database_connect.php

$connect = new PDO('mysql:host=localhost;dbname=afriquetec', 'root', '',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$connect->exec('SET NAMES utf8');

// session_start();
