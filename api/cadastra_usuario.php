<?php
require_once '../banco/conexao.php';

header('Content-Type: application/json');

$nome = $_POST['nome'] ?? null;
$email = $_POST['email'] ?? null;
$genero = $_POST['genero'] ?? null;
$cidade = $_POST['cidade'] ?? null;
$pais = $_POST['pais'] ?? null;

if (!$nome || !$email) {
    echo json_encode(["erro" => "Nome e email são obrigatórios."]);
    exit;
}

$fotoPath = null ;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../fotos/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nomeArquivo = uniqid() . '.' . $extensao;
    $caminhoFinal = $uploadDir . $nomeArquivo;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoFinal)) {
        $fotoPath = 'fotos/' . $nomeArquivo;
    }
}elseif (!empty($_POST['foto_url'])) {
    $fotoPath = $_POST['foto_url'];
}

$sql = "INSERT INTO usuarios (nome, email, genero, cidade, pais, foto) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nome, $email, $genero, $cidade, $pais, $fotoPath]);

echo json_encode(["mensagem" => "Usuário cadastrado com sucesso."]);
