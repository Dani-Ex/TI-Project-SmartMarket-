<?php

$validSensors = ['temperatura', 'humidade', 'luz'];
$sensor = isset($_GET['page']) && in_array($_GET['page'], $validSensors) ? $_GET['page'] : '';
$sensor_medida = file_get_contents("Api/files/$sensor/valor.txt");

include_once('NavBar.php');

?>

<head>
    <meta charset="utf-8" http-equiv="refresh" content="5">
    <title>Historico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <?php renderNavBar()?>

    <h2 class='historyTitle'>
        <?php echo ucfirst($sensor); ?>
    </h2>


    <table class="mt-4 table table-striped border-0 border-primary">

        <!-- Table header -->
        <thead>
            <tr>
                <!-- Column headers -->
                <th class="bg-body-tertiary-secondary py-4 mainTextColor" scope="col">#</th>
                <th class="bg-body-tertiary-secondary py-4 mainTextColor" scope="col">Value</th>
                <th class="bg-body-tertiary-secondary py-4 mainTextColor" scope="col">Date</th>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody>
            <?php


            if (!empty($sensor)) {
                // Read sensor logs
                $sensor_logs = file_get_contents("Api/files/$sensor/log.txt");
                // Split log data into arrays
                $sensor_values = explode(PHP_EOL, $sensor_logs);

                // Dividir los datos de los logs en arrays
                $log_lines = explode(PHP_EOL, $sensor_logs);

                // Iterar sobre cada línea de log
                foreach ($log_lines as $log_line) {
                    // Dividir cada línea en "valor" y "hora" usando ":" como separador
                    $log_parts = explode(";", $log_line);
                    $sensor_data[] = $log_parts[0]; // Valor
                    $sensor_times[] = $log_parts[1]; // Hora
                }


                // Loop through each row of the table
                for ($index = 0; $index < count($sensor_values); $index++) {
            ?>
                    <tr>
                        <!-- Row number -->
                        <th class="bg-bg-warning-subtle py-4 mainTextColor" scope="row"><?php echo $index + 1; ?></th>
                        <!-- Sensor value -->
                        <td class="bg-bg-warning-subtle py-4 mainTextColor"><?php echo isset($sensor_data[$index]) ? $sensor_data[$index] . $sensor_medida : ''; ?></td>
                        <!-- Date -->
                        <td class="bg-bg-warning-subtle py-4 mainTextColor"><?php echo isset($sensor_times[$index]) ? $sensor_times[$index] : ''; ?></td>
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