<?php
$senha = $_GET['senha'] ?? '';
$guiche = $_GET['guiche'] ?? '';
$texto = "Senha $senha, favor comparecer ao guichê $guiche";

header('Content-Type: audio/mpeg');
// Use uma API de TTS para converter texto em áudio. Exemplo com um serviço fictício:
$tts_url = "https://api.text-to-speech.com/generate?text=" . urlencode($texto);
readfile($tts_url);
?>
