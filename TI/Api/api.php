<?php

    header('Content-Type: text/html; charset=utf-8');
    //echo $_SERVER['REQUEST_METHOD']

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo'recebi um POST';
        print_r ( $_POST );
        if (isset($_POST['valor']) && isset( $_POST['nome']) && isset($_POST['hora'])) {
            file_put_contents('Files\Temperatura\valor.txt', $_POST['valor']);
            file_put_contents('Files\Temperatura\hora.txt', $_POST['hora']);
            file_put_contents('Files\Temperatura\log.txt', $_POST['hora'].';'.$_POST['valor'] . PHP_EOL , FILE_APPEND);
        }

    }elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo ('recebi um GET ');
        if (isset($_GET['nome'])) {
            echo file_get_contents('Files\Temperatura\valor.txt');
        }else{
            echo 'faltam parametros no GET';
        }
    }else {
        echo 'metodo nao premitido';
        
    if (http_response_code() == 400){
            echo 'pedido mal feito ( bad request)';
        }
        if (http_response_code() == 403){
            echo 'pedido proibido ( forbidden)';
        }
    }
?>
