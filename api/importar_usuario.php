<?php
require_once '../banco/conexao.php';

$url = 'https://randomuser.me/api/?results=10';
$resposta = file_get_contents($url);
$dados = json_decode($resposta, true);

foreach ($dados['results'] as $usuario) {
    $nome = $usuario['name']['first'] . ' ' . $usuario['name']['last'];
    $email = $usuario['email'];
    $genero = $usuario['gender'];
    $cidade = $usuario['location']['city'];
    $pais = $usuario['location']['country'];

    $sql = "INSERT INTO usuarios (nome, email, genero, cidade, pais) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $genero, $cidade, $pais, $foto]);
}

echo "Usuários importados com sucesso!";
?>
