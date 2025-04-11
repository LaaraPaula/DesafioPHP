<?php
require_once '../banco/conexao.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(["erro" => "Dados inválidos."]);
    exit;
}

$id = $data['id'];
$nome = $data['nome'];
$email = $data['email'];
$genero = $data['genero'];
$cidade = $data['cidade'];
$pais = $data['pais'];

$sql = "UPDATE usuarios SET nome = ?, email = ?, genero = ?, cidade = ?, pais = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nome, $email, $genero, $cidade, $pais, $id]);

echo json_encode(["mensagem" => "Usuário atualizado com sucesso."]);
