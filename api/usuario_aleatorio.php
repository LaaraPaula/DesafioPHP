<?php
header('Content-Type: application/json');

$url = 'https://randomuser.me/api/';
$resposta = file_get_contents($url);
$dados = json_decode($resposta, true);

$usuario = $dados['results'][0];

$retorno = [
    "nome" => $usuario['name']['first'] . ' ' . $usuario['name']['last'],
    "email" => $usuario['email'],
    "genero" => $usuario['gender'],
    "cidade" => $usuario['location']['city'],
    "pais" => $usuario['location']['country'],
    "foto" => $usuario['picture']['medium']
];

echo json_encode($retorno);
