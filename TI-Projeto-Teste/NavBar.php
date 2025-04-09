<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION["username"])) {
    header("Location: /index.php");
    exit();
}

/**
 * Function to render the navigation bar
 */
function renderNavBar()
{
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sensors me-1"></i> Sensores
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="historico.php?page=temperatura">Temperatura</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=humidade">Humidade</a></li>
                            <li><a class="dropdown-item" href="historico.php?page=luz">Luz</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <?php
}

/**
 * Function to include the correct page content
 */
function loadPageContent()
{
    $validPages = [
        'dashboard' => 'dashboard.php',
        'temperatura' => 'history.php',
        'humidade' => 'history.php',
        'luz' => 'history.php',
    ];
    
    $page = $_GET['page'] ?? 'dashboard';
    include $validPages[$page] ?? $validPages['dashboard'];
}
?>
