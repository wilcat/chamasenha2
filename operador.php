<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_id = $_POST['senha_id'];
    $conn->query("UPDATE senhas SET chamado = 1 WHERE id = $senha_id");
}

$senhas = $conn->query("SELECT s.id, s.numero, servicos.nome AS servico, guiches.numero AS guiche 
                        FROM senhas s 
                        JOIN servicos ON s.servico_id = servicos.id
                        JOIN guiches ON s.guiche_id = guiches.id
                        WHERE s.chamado = 0 
                        ORDER BY s.horario ASC 
                        LIMIT 1");

if ($senhas->num_rows > 0) {
    $senha = $senhas->fetch_assoc();
    echo "<h2>Próxima senha: S-{$senha['numero']}</h2>";
    echo "<p>Serviço: {$senha['servico']}</p>";
    echo "<p>Guichê: {$senha['guiche']}</p>";
    echo "<form method='post'><button type='submit' name='senha_id' value='{$senha['id']}'>Chamar Senha</button></form>";
} else {
    echo "<p>Nenhuma senha na fila.</p>";
}
?>
