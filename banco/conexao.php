<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=desafio;charset=utf8", "root", "0000");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
