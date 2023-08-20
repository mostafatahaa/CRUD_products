<?php

$dsn = 'mysql:host=localhost;dbname=new_products';
$user_name = 'root';
$pass = '';
$pdo = new PDO($dsn, $user_name, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location:index.php');
    exit;
} else {
}

$stat = $pdo->prepare('DELETE FROM products WHERE id = :id');
$stat->bindValue(':id', $id);
$stat->execute();
header('Location: index.php');
