<?php
session_start();
if (!isset($_SESSION["username"])) {
  header("refresh:5;url=index.php");
  die("Acesso restrito");
}
include_once('NavBar.php');
?>


<?php
$valor_temperatura = file_get_contents("Api/files/temperatura/valor.txt");
$hora_temperatura = file_get_contents("Api/files/temperatura/hora.txt");
$nome_temperatura = file_get_contents("Api/files/temperatura/nome.txt");
$valor_humidade = file_get_contents("Api/files/humidade/valor.txt");
$hora_humidade = file_get_contents("Api/files/humidade/hora.txt");
$nome_humidade = file_get_contents("Api/files/humidade/nome.txt");
$valor_luz = file_get_contents("Api/files/luz/valor.txt");
$hora_luz = file_get_contents("Api/files/luz/hora.txt");
$nome_luz = file_get_contents("Api/files/luz/nome.txt");

// echo("$nome_temperatura: $valor_temperatura $hora_temperatura");

?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8" http-equiv="refresh" content="5">
  <title>Plataforma IoT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  


</head>

<body class="backgroundDashboard">
  <?php renderNavBar(); ?>


  <div class="container d-flex justify-content-around align-items-center">
    <div id="tittle-header">
      <h1>Smart Market</h1>
      <h6>user: <?php echo $_SESSION['username']?></h6>
    </div>
    <img src="Imagens\estg.png" width="300">
  </div>


  
  <div class="container" >
    <div class="row">
      <div class="col-sm-4">
        <div class="card text-center">
          <div class="card-header sensor subtitle">Temperatura: <?php echo $valor_temperatura; ?></div>
          <div class="card-body"><img src="Imagens\temperature-high.png" alt="Temperatura"></div>
          <div class="card-footer">
            <span class = "subtitle">Atualização:</span>
            <a><?php echo $hora_temperatura ?></a>
            <a href="temperatura.php" class="card-link">Histórico</a>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card text-center">
          <div class="card-header sensor substitle"> Humidade: <?php echo $valor_humidade; ?></div>
          <div class="card-body"><img src="Imagens\humidity-high.png"></div>
          <div class="card-footer">
            <span class="subtitle">Atualização:</span>
            <a href=”humidade.php” class="card-link">Histórico</a>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card text-center">
          <div class="card-header atuador">Led Arduino: Ligado</div>
          <div class="card-body"><img src="Imagens\light-on.png"></div>
          <div class="card-footer">
            <span class="subtitle">Atualização:</span>
            <a><?php echo $hora_luz; ?></a>
            <a href=”luz.php” class="card-link">Histórico</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" class="subtitles">Tabela de Sensores</div>
    <div class="card-body">
      <table class="table">
        <thead class="subtitles">
          <tr>
            <th scope="col">Tipo de Dispositivo IoT</th>
            <th scope="col">Valor</th>
            <th scope="col">Data de Atualização</th>
            <th scope="col">Estado Alertas</th>
          </tr>
        <tbody>
          <tr>
            <td><?php echo $nome_temperatura; ?></td>
            <td><?php echo $valor_temperatura; ?>º</td>
            <td><?php echo $hora_temperatura; ?></td>
            <td class="badge rounded-pill text-bg-danger" style="margin-top: 6px;">Elevada</td>
          </tr>
          <tr>
            <td>Humidade</td>
            <td>70%</td>
            <td>2024/03/10 14:31</td>
            <td class="badge rounded-pill text-bg-primary" style="margin-top: 6px;">Normal</td>
          </tr>
          <tr>
            <td>Led Arduino</td>
            <td>Ligado</td>
            <td>2024/03/10 14:31</td>
            <td class="badge rounded-pill text-bg-success" style="margin-top: 6px;">Ativo</td>
          </tr>
        </tbody>
        </thead>
      </table>
    </div>
  </div>
  



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  
  

</body>

</html>