<?php
session_start();
$servername = "localhost";
$username = "joanac_baloja"; // seu usuário
$password = "140bvGoDJ_"; // sua senha
$dbname = "joanac_baloja"; // nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


?>