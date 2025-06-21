<?php
session_start();

//Função para aparecer a NavBar
function renderNavBar()
{
    //Assegura que existe um Usuario logged in
    if (!isset($_SESSION["username"])) {
        header("refresh:5;url=index.php");
        die("Acesso restrito");
    }
?>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <i class="bi bi-cart3 me-2"></i> Smart Market
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="bi bi-house-door me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="atividade.php">
                            <i class="bi bi-house-door me-1"></i> Atividade
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sensors me-1"></i> Sensores
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="historico.php?page=temperatura_ambiente">Temperatura Ambiente</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=temperatura_arca"> Temperatura Arca</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=humidade">Humidade</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sensors me-1"></i> Atuadores
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="historico.php?page=luz">Luz</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=ac_ambiente">Ar Condicionado Ambiente</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=ac_arca">Ar Condicionado Arca</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=desumidificador">Desumidificador</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=porta">Porta</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="nav-item dropdown navbar-nav ">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-sensors me-1"></i> User: <?php echo $_SESSION['username'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
<?php
}

//Função para incluir corretamente o conteudo da pagina
function loadPageContent()
{
    $validPages = [
        'dashboard' => 'dashboard.php',
        'temperatura_ambiente' => 'history.php',
        'temperatura_arca' => 'history.php',
        'humidade' => 'history.php',
        'luz' => 'history.php',
        'ac_ambiente' => 'history.php',
        'ac_arca' => 'history.php',
        'desumidificador' => 'history.php',
        'porta' => 'history.php',
    ];

    $page = $_GET['page'] ?? 'dashboard';
    include $validPages[$page] ?? $validPages['dashboard'];
}
?>