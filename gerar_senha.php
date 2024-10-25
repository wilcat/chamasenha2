<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servico_id = $_POST['servico_id'];
    $guiche_id = rand(1, 5); // Guichê aleatório para este exemplo

    // Gera o próximo número de senha
    $result = $conn->query("SELECT COALESCE(MAX(numero), 0) + 1 AS proximo_numero FROM senhas");
    $senha_numero = $result->fetch_assoc()['proximo_numero'];

    // Insere a senha no banco
    $stmt = $conn->prepare("INSERT INTO senhas (numero, servico_id, guiche_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $senha_numero, $servico_id, $guiche_id);
    $stmt->execute();

    echo "<h2>Sua senha é: S-$senha_numero</h2>";
    echo "<p>Guichê: $guiche_id</p>";
    echo "<p>Horário: " . date('H:i:s') . "</p>";
}
?>

<!DOCTYPE html>
<html>
    <Head>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../gera-senha/css/styles.css">
    </Head>
<body>
    <form method="post">
    <div class="main">
            <h1>Selecione o Serviço</h1>
            <form action="gerar_senha.php" method="post">
                <button type="submit" name="servico" value="1">Serviço 1</button>
                <button type="submit" name="servico" value="2">Serviço 2</button>
                <button type="submit" name="servico" value="3">Serviço 3</button>
                <button type="submit" name="servico" value="4">Serviço 4</button>
                <button type="submit" name="servico" value="5">Serviço 5</button>
            </form>
        </div>

        <!-- Barra Lateral para Informações Adicionais ou Vídeos -->
        <div class="sidebar">
            <h1>Informações</h1>
            <p>Bem-vindo ao sistema de senhas. Selecione um serviço para obter sua senha.</p>
        </div>
    </div>
        <label>Escolha o Serviço:</label><br>
        <?php
        $result = $conn->query("SELECT * FROM servicos");
        while ($servico = $result->fetch_assoc()) {
            echo "<button type='submit' name='servico_id' value='{$servico['id']}'>{$servico['nome']}</button><br>";
        }
        ?>
    </form>
</body>
</html>
