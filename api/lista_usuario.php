<?php
require_once '../banco/conexao.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM usuarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($usuarios);
?>
