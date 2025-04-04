<?php
  session_start();
  if (!isset($_SESSION["username"])) {
      header("refresh:5;url=index.php");
      die("Acesso restrito");
  }
?>

<?php
  $valor_temperatura = file_get_contents("api/files/temperatura/valor.txt");
  $hora_temperatura = file_get_contents("api/files/temperatura/hora.txt");
  $nome_temperatura = file_get_contents("api/files/temperatura/nome.txt");

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
  <body>
    <div class="container d-flex justify-content-around align-items-center">
      <div id="tittle-header">
        <h1>Servidor IoT</h1>
        <h6>user: Alexandre Lopes</h6>
      </div>
      <img src="estg.png" width="300">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <div class="card text-center">
            <div class="card-header sensor">Temperatura: <?php echo $valor_temperatura; ?></div>
            <div class="card-body"><img src="temperature-high.png"></div>
            <div class="card-footer">
              <a style="font-weight: bold;">Atualização:</a>
              <a><?php echo $hora_temperatura ?></a>
              <a href=”#” class="card-link">Histórico</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card text-center">
            <div class="card-header sensor">Humidade: 70%</div>
            <div class="card-body"><img src="humidity-high.png"></div>
            <div class="card-footer">
              <a style="font-weight: bold;">Atualização:</a>
              <a>2024/03/10 14:31</a>
              <a href=”#” class="card-link">Histórico</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card text-center">
            <div class="card-header atuador">Led Arduino: Ligado</div>
            <div class="card-body"><img src="light-on.png"></div>
            <div class="card-footer">
              <a style="font-weight: bold;">Atualização:</a>
              <a>2024/03/10 14:31</a>
              <a href=”#” class="card-link">Histórico</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header" style="font-weight: bold;">Tabela de Sensores</div>
      <div class="card-body">
        <table class="table">
          <thead style="font-weight: bold;">
            <tr>
              <th scope="col">Tipo de Dispositivo IoT</th>
              <th scope="col">Valor</th>
              <th scope="col">Data de Atualização</th>
              <th scope="col">Estado Alertas</th>
            </tr>
            <tbody>
              <tr>
                <td><?php echo $nome_temperatura;?></td>
                <td><?php echo $valor_temperatura;?>º</td>
                <td><?php echo $hora_temperatura;?></td>
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

    <div>
      <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">
          <span class="navbar-text" style="font-weight: bold;">Dashboard EI-TI</span>
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Histórico</a>
            </li>
          </ul>
          <form>
            <a href="logout.php"><button class="btn btn-default" type="button">Logout</button></a>
          </form>
        </div>
      </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>