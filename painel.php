<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1"> <!-- Atualiza a cada 5 segundos -->
    <link rel="stylesheet" href="../gera-senha/css/styles.css">
    <title>Painel de Chamamento de Senhas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: block;
            flex-direction: row;
            align-items: flex-start;
            width: 50%;
            max-width: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;

            .senha-atual{
                position: relative;
                flex: 2;
                padding: 20px;
                border-right: 2px solid #ddd;
                text-align: center;
            }
        }

            .senha-atual h1 {
                font-size: 7em;
                color: #2c3e50;
                margin: 0;
            }
            .senha-atual h2 {
                font-size: 2em;
                color: #2980b9;
                margin: 0;
            }

            .historico-senhas {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
                max-height: 80vh;
                background: #ecf0f1;
            }
            .quadro-senha {
                background: white;
                border-radius: 10px;
                padding: 15px;
                margin-bottom: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            
            .ultimas-senhas h3 {
                margin-top: 0;
                font-size: 1.2em;
                color: #333;
            }       

        /* Espaço para vídeo ou canal de TV */
            .video-container {
                flex: 1;
                padding: 0px;
                display: flex;
                justify-content: right;
                align-items: right;
                background: #ecf0f1;
                border-left: 2px solid #ddd;
                height: 200px;
                width: 200px;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="senha-atual">
            <?php
            include 'conexao.php';

            // Recupera a última senha chamada
            $result = $conn->query("SELECT s.numero, g.numero AS guiche FROM senhas s
                                    JOIN guiches g ON s.guiche_id = g.id
                                    WHERE s.chamado = 1
                                    ORDER BY s.horario DESC LIMIT 1");

            if ($result->num_rows > 0) {
                $senha = $result->fetch_assoc();
                echo "<h1>Senha S-{$senha['numero']}</h1>";
                echo "<h2>Guichê {$senha['guiche']}</h2>";
                
                // Adiciona o ID da senha ao código HTML para verificação no JavaScript
                echo "<div id='senha' data-numero='{$senha['numero']}' data-guiche='{$senha['guiche']}'></div>";
            } else {
                echo "<p>Aguardando chamada...</p>";
            }
            ?>
        </div>

        <div class="historico-senhas">
            <h3>Últimas senhas chamadas:</h3>
            <?php
            // Recupera as últimas cinco senhas chamadas
            $ultimas_senhas = $conn->query("SELECT s.numero, g.numero AS guiche, s.horario FROM senhas s
                                            JOIN guiches g ON s.guiche_id = g.id
                                            WHERE s.chamado = 1
                                            ORDER BY s.horario DESC LIMIT 5");

            if ($ultimas_senhas->num_rows > 0) {
                while ($linha = $ultimas_senhas->fetch_assoc()) {
                    echo "<div class='quadro-senha'>";
                    echo "<strong>Senha S-{$linha['numero']}</strong><br>";
                    echo "Guichê {$linha['guiche']}<br>";
                    echo "Horário: {$linha['horario']}";
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhuma senha chamada ainda.</p>";
            }
            ?>
        </div>

        <div class="video-container">
            <iframe src="https://www.youtube.com/embed/VIDEO_ID" allowfullscreen></iframe>
            <!-- Substitua VIDEO_ID pelo ID do vídeo ou canal desejado -->
        </div>
    </div>

    <!-- JavaScript para tocar o áudio automaticamente quando a senha mudar -->
    <script>
        function falarTexto(texto) {
            const synth = window.speechSynthesis;
            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.lang = 'pt-BR';  // Define o idioma como português do Brasil
            synth.speak(utterance);
        }

        let ultimaSenha = localStorage.getItem("ultimaSenha") || null;

        const senhaAtual = document.getElementById("senha");
        if (senhaAtual) {
            const numeroSenha = senhaAtual.getAttribute("data-numero");
            const guicheSenha = senhaAtual.getAttribute("data-guiche");

            // Verifica se a senha mudou
            if (numeroSenha !== ultimaSenha) {
                // Salva a senha atual no armazenamento local
                localStorage.setItem("ultimaSenha", numeroSenha);

                // Fala a nova senha e guichê
                falarTexto(`Senha S-${numeroSenha}, favor comparecer ao guichê ${guicheSenha}.`);
            }
        }
    </script>
</body>
</html>
