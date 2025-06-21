<?php
session_start();
if (!isset($_SESSION["username"])) {
    die("Acesso não autorizado");
}

$atuador = $_POST['nome'] ?? '';
$valor = $_POST['valor'] ?? '';

// Validação básica
if (!in_array($atuador, ['ac_ambiente', 'ac_arca', 'luz', 'porta', 'desumidificador']) || !in_array($valor, ['0', '1'])) {
    die("Parâmetros inválidos");
}

// Atualiza o arquivo de valor correspondente
$arquivo_valor = "api/files/{$atuador}/valor.txt";
if (file_exists($arquivo_valor)) {
    file_put_contents($arquivo_valor, $valor . PHP_EOL, FILE_APPEND);
    
    // Atualiza também o arquivo de hora
    $arquivo_hora = "api/files/{$atuador}/hora.txt";
    $hora_atual = date('Y-m-d H:i:s');
    file_put_contents($arquivo_hora, $hora_atual . PHP_EOL, FILE_APPEND);
    
    echo "Atuador {$atuador} atualizado para {$valor}";
} else {
    echo "Erro: Atuador não encontrado";
}
?>