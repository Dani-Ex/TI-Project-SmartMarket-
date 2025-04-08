<?php
session_start();

if (!isset($_SESSION['username'])) {
    include 'index.php';
    exit();
} else {
    $current_user = $_SESSION["username"];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermercado Inteligente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-fluid">
        <!-- NavBar -->
        <nav class="navbar navbar-expand-sm border-bottom border-body bg-body-secondary align-items-center" data-bs-theme="dark">
            <div>
                <a class="navbar-brand subtitle" href="?page=dashboard"> Supermercado Inteligente </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav nav-pills me-auto ">
                        <li class="nav-item">
                            <a class="nav-link px-0 d-flex align-items-center active" aria-current="page" href="?page=dashboard">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropsown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sensores</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?page=temperature">Temperatura</a></li>
                                <li><a class="dropdown-item" href="?page=humidity">Humidade</a></li>
                                <li><a class="dropdown-item" href="?page=led">Luz</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <form>
                    <a href="logout.php"><button class="btn btn-default" type="button">Logout</button></a>
                </form>
            </div>
        </nav>
        <!-- Main -->
        <div>
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

            switch ($page) {
                case 'dashboard':
                    include 'dashboard.php';
                    break;
                case 'temperature':
                    include 'historico.php';
                    break;
                case 'humidity':
                    include 'historico.php';
                    break;
                case 'led':
                    include 'historico.php';
                    break;
                default:
                    include 'dashboard.php';
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>