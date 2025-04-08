<?php 

    $sensor = isset($_GET['page']) ? $_GET['page'] : '';
    $sensor_medida = file_get_contents("../../api/files/$sensor/valor.txt");

?>


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
        $sensor_logs = file_get_contents("../../api/files//$sensor/log.txt");
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
                <th class="bg-body-tertiary-secondary py-4 mainTextColor" scope="row"><?php echo $index + 1; ?></th>
                <!-- Sensor value -->
                <td class="bg-body-tertiary-secondary py-4 mainTextColor"><?php echo isset($sensor_data[$index]) ? $sensor_data[$index] . $sensor_medida : ''; ?></td>
                <!-- Date -->
                <td class="bg-body-tertiary-secondary py-4 mainTextColor"><?php echo isset($sensor_times[$index]) ? $sensor_times[$index] : ''; ?></td>
            </tr>
            <?php
        }
        
    } 
    else {
        echo "Sensor no especificado.";
    }
    ?>
    </tbody>
</table>