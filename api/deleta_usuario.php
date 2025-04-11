<?php
require_once '../banco/conexao.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(["erro" => "ID não informado."]);
    exit;
}

$id = $data['id'];

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

echo json_encode(["mensagem" => "Usuário excluído com sucesso."]);
