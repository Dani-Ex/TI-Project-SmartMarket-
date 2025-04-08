<?php 
// Retrieve sensor data from respective files
$valor_sensor_Temperatura = file_get_contents("../../api/files/Temperatura/valor.txt");
$date_sensor_temperatura = file_get_contents("../../api/files/sensors_actuators/temperature/hora.txt");
$valor_sensor_humidity = file_get_contents("../../api/files/humidity/valor.txt");
$date_sensor_humidity = file_get_contents("../../api/files/humidity/hora.txt");
?>






