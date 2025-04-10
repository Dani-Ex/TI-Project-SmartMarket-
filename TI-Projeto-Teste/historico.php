<?php
//Altera o Valor da variavel Sensor para o da pagina selecionada
$validSensors = ['temperatura_ambiente', 'temperatura_arca', 'humidade', 'luz', 'ac', 'porta'];
$sensor = isset($_GET['page']) && in_array($_GET['page'], $validSensors) ? $_GET['page'] : '';

$nomeFile = "Api/files/$sensor/nome.txt";
if (!file_exists($nomeFile)) {
    die("File $nomeFile not found.");
}
$nome = file_get_contents($nomeFile);

include_once('NavBar.php');

?>

<html>

<head>
    <meta charset="utf-8" http-equiv="refresh" content="5">
    <title>Historico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">


</head>

<body class="backgroundDashboard">
    
    <!-- Função da Navbar -->
    <?php renderNavBar() ?>

    <h2 class='historyTitle'>
        <?php echo ucfirst($nome); ?>
    </h2>

    <!-- Tabela dos Valores do Historico -->
    <table class="mt-4 table table-striped border-0 border-color: #6c72933d">

        <!-- Table header -->
        <thead>
            <tr>
                <!-- Column headers -->
                <th class="bg-body-tertiary-secondary py-4" scope="col">#</th>
                <th class="bg-body-tertiary-secondary py-4" scope="col">Value</th>
                <th class="bg-body-tertiary-secondary py-4" scope="col">Date</th>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody>
            <?php


            if (!empty($sensor)) {
                $sensor_data = [];
                $sensor_times = [];
                // Le os valores do Log do sensor selecionado
                $logFile = "Api/files/$sensor/log.txt";
                if (!file_exists($logFile)) {
                    die("File $logFile not found.");
                }
                $sensor_logs = file_get_contents($logFile);

                // Separa os Valores do Log em Vetores
                $sensor_values = explode(PHP_EOL, $sensor_logs);

                // DIgual para Verificação Futura
                $log_lines = explode(PHP_EOL, $sensor_logs);

                foreach ($log_lines as $log_line) {
                    // Dividir cada linha usando ";" como separador
                    $log_parts = explode(";", $log_line);
                    $sensor_hora[] = $log_parts[0]; // Hora
                    $sensor_valor[] = $log_parts[1]; // Valor
                }


                // Loop por cada linha do vetor
                for ($index = 0; $index < count($sensor_values); $index++) {
            ?>
                    <tr>
                        <!-- Nº da Linha -->
                        <th class="bg-bg-warning-subtle py-4" scope="row"><?php echo $index + 1; ?></th>
                        <!-- Valor do Sensor -->
                        <td class="bg-bg-warning-subtle py-4"><?php echo isset($sensor_valor[$index]) ? $sensor_valor[$index] : ''; ?></td>
                        <!-- Horario -->
                        <td class="bg-bg-warning-subtle py-4"><?php echo isset($sensor_hora[$index]) ? $sensor_hora[$index] : ''; ?></td>
                    </tr>
            <?php
                }
            } else {
                echo "Sensor no especificado.";
            }
            ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>