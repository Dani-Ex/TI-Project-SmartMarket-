<?php

    header('Content-Type: text/html; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo 'recebi um POST';
        print_r($_POST);
        if (isset($_POST['valor']) && isset($_POST['nome']) && isset($_POST['hora'])) {
            $nome = basename($_POST['nome']);
            $dir = 'Files/'.$nome.'/';
            file_put_contents($dir.'valor.txt', $_POST['valor']);
            file_put_contents($dir.'hora.txt', $_POST['hora']);
            
            // Le o Log File atual
            $log_file = $dir.'log.txt';
            $log_lines = file_exists($log_file) ? file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
            
            // Adiciona novos valores
            $new_entry = $_POST['hora'].';'.$_POST['valor'];
            array_unshift($log_lines, $new_entry); // Add new entry at beginning
            
            // Mantem apenas os ultimos 50 valores
            $log_lines = array_slice($log_lines, 0, 50);
            
            // Escreve de novo para o Ficheiro
            file_put_contents($log_file, implode(PHP_EOL, $log_lines) . PHP_EOL);
        }

    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo ('recebi um GET ');
        if (isset($_GET['nome'])) {
            $nome = basename($_GET['nome']);
            echo file_get_contents('Files/'.$_GET["nome"].'/valor.txt');
        } else {
            echo 'faltam parametros no GET';
        }
    } else {
        echo 'metodo nao premitido';
        http:http_response_code(405);
        exit();
    }
?>