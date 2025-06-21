<?php
session_start();
if (!isset($_SESSION["username"])) {
  header("refresh:5;url=index.php");
  die("Acesso restrito");
}
include_once('NavBar.php');

//Função para ler os valores dos ficheiros
function readLogData($valueFile, $timeFile, $nameFile)
{
  if(!file_exists($valueFile) || !file_exists($timeFile) || !file_exists($nameFile)) {
    die("Erro ao carregar os ficheiros: $valueFile, $timeFile, $nameFile");
}
  $values = file($valueFile, FILE_IGNORE_NEW_LINES);
  $times = file($timeFile, FILE_IGNORE_NEW_LINES);
  $name = file($nameFile, FILE_IGNORE_NEW_LINES);
  return [$values, $times, $name];
}

// Lista dos valores de cada .txt para os sensores e atuadores
list($valores_tempGeral, $horas_tempGeral, $nome_temperaturaGeral) = readLogData("api/files/temperatura_ambiente/valor.txt", "api/files/temperatura_ambiente/hora.txt", "api/files/temperatura_ambiente/nome.txt");
list($valores_tempArca, $horas_tempArca, $nome_temperaturaArca) = readLogData("api/files/temperatura_arca/valor.txt", "api/files/temperatura_arca/hora.txt", "api/files/temperatura_arca/nome.txt");
list($valores_humidade, $horas_humidade, $nome_humidade) = readLogData("api/files/humidade/valor.txt", "api/files/humidade/hora.txt", "api/files/humidade/nome.txt");
list($valores_luz, $horas_luz, $nome_luz) = readLogData("api/files/luz/valor.txt", "api/files/luz/hora.txt", "api/files/luz/nome.txt");
list($valores_acGeral, $horas_acGeral, $nome_acGeral) = readLogData("api/files/ac_ambiente/valor.txt", "api/files/ac_ambiente/hora.txt", "api/files/ac_ambiente/nome.txt");
list($valores_acArca, $horas_acArca, $nome_acArca) = readLogData("api/files/ac_arca/valor.txt", "api/files/ac_arca/hora.txt", "api/files/ac_arca/nome.txt");
list($valores_desumidificador, $horas_desumidificador, $nome_desumidificador) = readLogData("api/files/desumidificador/valor.txt", "api/files/desumidificador/hora.txt", "api/files/desumidificador/nome.txt");
list($valores_porta, $horas_porta, $nome_porta) = readLogData("api/files/porta/valor.txt", "api/files/porta/hora.txt", "api/files/porta/nome.txt");

?>

<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="5">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body class="backgroundDashboard">

  <!-- Funçao da Navbar -->
  <?php renderNavBar(); ?>

  <div class="container d-flex justify-content-around align-items-center">
    <div id="tittle-header">
      <h1>Smart Market</h1>
    </div>
  </div>

  <div class="container">
    <div class="row">

      <!-- CARDS SENSORES -->

      <!-- Temperatura Geral Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor da Temperatura do Ambiente -->
          <div class="card-header sensor subtitle">Temperatura: <?php echo end($valores_tempGeral) ?> ºC</div>
          <!-- Alteraçao da imagem dependendo do valor da Temperatura do Ambiente -->
          <div class="card-body"><?php if (end($valores_tempGeral) <= 16) {
                                    echo '<img src="imagens/frio.png" alt="Temperatura Fria">';
                                  } else {
                                    echo '<img src="imagens/calor.png" alt="Temperatura Quente">';
                                  } ?></div>
          <!-- Última Atualização e historico da Temperatura do Ambiente -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_tempGeral) ?></span>
            <a href="historico.php?page=temperatura_ambiente" class="card-link">Histórico</a>
          </div>
        </div>
      </div>

      <!-- Temperatura Arca Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor da Temperatura da Arca -->
          <div class="card-header sensor subtitle">Temperatura: <?php echo end($valores_tempArca) ?> ºC</div>
          <!-- Alteraçao da imagem dependendo do valor da Temperatura da Arca -->
          <div class="card-body"><?php if (end($valores_tempArca) >= 6) {
                                    echo '<img src="imagens/calor.png" alt="Temperatura Quente">';
                                  } else {
                                    echo '<img src="imagens/frio.png" alt="Temperatura Fria">';
                                  } ?></div>
          <!-- Última Atualização e historico da Temperatura da arca -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_tempArca) ?></span>
            <a href="historico.php?page=temperatura_arca" class="card-link">Histórico</a>
          </div>
        </div>
      </div>

      <!-- Humidade Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor da Humidade -->
          <div class="card-header sensor subtitle"> Humidade: <?php echo end($valores_humidade) ?></div>
          <div class="card-body"><img src="imagens/humidity-high.png" alt="humidity"></div>
          <!-- Última Atualização e historico da Humidade -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_humidade) ?></span>
            <a href="historico.php?page=humidade" class="card-link">Histórico</a>
          </div>
        </div>
      </div>

      <!-- CARDS Atuadores -->

      <!-- Luz Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor Led -->
          <!-- Estado Led -->
          <div class="card-header atuador">Led Arduino: <?php if (end($valores_luz) == '1') {
                                                          echo 'Ligado';
                                                        } else {
                                                          echo 'Desligado';
                                                        } ?></div>
          <!-- Alteraçao da imagem dependendo do estada do Led -->
          <div class="card-body"><?php if (end($valores_luz) == '1') {
                                    echo '<img src="imagens/light-on.png" alt="Luz Ligada">';
                                  } else {
                                    echo '<img src="imagens/light-off.png" alt="Luz Desligada">';
                                  } ?></div>
          <!-- Última Atualização e historico do Led -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_luz); ?></span>
            <a href="historico.php?page=luz" class="card-link">Histórico</a>
          </div>
        </div>
      </div>

      <!-- AC Ambiente Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor AC -->
          <!-- Estado AC -->
          <div class="card-header atuador">AC Ambiente Arduino: <?php if (end($valores_acGeral) == '1') {
                                                          echo 'Ligado';
                                                        } else {
                                                          echo 'Desligado';
                                                        } ?></div>
          <div class="card-body">
            <img src="imagens/ac.png" alt="ac_ambiente">
            <div class="btn-group mt-2" role="group">
                <button type="button" 
                        class="btn btn-success <?php echo (end($valores_acGeral) == '1') ? 'active' : ''; ?>"
                        onclick="controlarAtuador('ac_ambiente', '1')">
                    Ligar
                </button>
                <button type="button" 
                        class="btn btn-danger <?php echo (end($valores_acGeral) == '0') ? 'active' : ''; ?>"
                        onclick="controlarAtuador('ac_ambiente', '0')">
                    Desligar
                </button>
            </div>
          </div>
          <!-- Última Atualização e historico do AC -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_acGeral); ?></span>
            <a href="historico.php?page=ac_ambiente" class="card-link">Histórico</a>
          </div>
        </div>
      </div>

      <!-- AC Arca Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor AC -->
          <!-- Estado AC -->
          <div class="card-header atuador">AC Arca Arduino: <?php if (end($valores_acArca) == '1') {
                                                          echo 'Ligado';
                                                        } else {
                                                          echo 'Desligado';
                                                        } ?></div>
          <div class="card-body"><img src="imagens/ac.png" alt="ac_arca"></div>
          <!-- Última Atualização e historico do AC -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_acArca); ?></span>
            <a href="historico.php?page=ac_arca" class="card-link">Histórico</a>
          </div>
        </div>
      </div>

     <!-- Desumidificador Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor Desumidificador -->
          <!-- Estado Desumidificador -->
          <div class="card-header atuador">Desumidificador Arduino: <?php if (end($valores_desumidificador) == '1') {
                                                          echo 'Ligado';
                                                        } else {
                                                          echo 'Desligado';
                                                        } ?></div>
          <div class="card-body"><img src="imagens/humidity-high.png" alt="desumidificador"></div>
          <!-- Última Atualização e historico do Desumidificador -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_desumidificador); ?></span>
            <a href="historico.php?page=desumidificador" class="card-link">Histórico</a>
          </div>
        </div>
      </div>

      <!-- Porta Card -->
      <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor Porta -->
          <!-- Estado Porta -->
          <div class="card-header atuador">Porta Arduino: <?php if (end($valores_porta) == '1') {
                                                            echo 'Aberta';
                                                          } else {
                                                            echo 'Fechada';
                                                          } ?></div>
          <!-- Alteraçao da imagem dependendo do estada da Porta -->
          <div class="card-body"><?php if (end($valores_porta) == '1') {
                                    echo '<img src="imagens/aberta.png" alt="Porta Aberta">';
                                  } else {
                                    echo '<img src="imagens/fechada.png" alt="Porta Fechada">';
                                  } ?></div>
          <!-- Última Atualização e historico da Porta -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_porta); ?></span>
            <a href="historico.php?page=porta" class="card-link">Histórico</a>
          </div>
        </div>
      </div>
            <!-- Imagem Card -->
            <div class="col-sm-4">
        <div class="card text-center">
          <!-- Verificaçao Valor Led -->
          <!-- Estado Led -->
          <div class="card-header atuador">Imagem: <?php if (end($valores_luz) == '1') {
                                                          echo 'Ligado';
                                                        } else {
                                                          echo 'Desligado';
                                                        } ?></div>
          <!-- Alteraçao da imagem dependendo do estada do Led -->
          <div class="card-body"><?php echo "<img src='api/images/webcam.jpg?id=".time()."' style='width:100%'>"; ?></div>
          <!-- Última Atualização e historico do Led -->
          <div class="card-footer">
            <span class="subtitle">Última Atualização:</span>
            <span><?php echo end($horas_luz); ?></span>
            <a href="historico.php?page=luz" class="card-link">Histórico</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    // Função para controlar atuadores via AJAX
    function controlarAtuador(atuador, estado) {
      fetch('controlar_atuador.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
            body: `nome=${atuador}&valor=${estado}`
        })
      .then(response => response.text())
      .then(data => {
          console.log(data);
          // Atualiza a página após 1 segundo para mostrar o novo estado
          setTimeout(() => location.reload(), 1000);
      })
      .catch(error => console.error('Erro:', error));
    }
  </script>
                                                      

</body>

</html>