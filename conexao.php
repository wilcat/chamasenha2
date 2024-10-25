<?php
// conexao.php
$host = "localhost";
$usuario = "root"; // Altere para o usuário do seu banco de dados
$senha = ""; // Altere para a senha do seu banco de dados
$banco = "chamamento_senhas";

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>
