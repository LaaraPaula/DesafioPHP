<?php
require_once '../banco/conexao.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$nome = $data['nome'] ?? null;
$email = $data['email'] ?? null;
$genero = $data['genero'] ?? null;
$cidade = $data['cidade'] ?? null;
$pais = $data['pais'] ?? null;

if (!$nome || !$email) {
    echo json_encode(["erro" => "Nome e email são obrigatórios."]);
    exit;
}

$sql = "INSERT INTO usuarios (nome, email, genero, cidade, pais) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nome, $email, $genero, $cidade, $pais]);

echo json_encode(["mensagem" => "Usuário cadastrado com sucesso."]);
