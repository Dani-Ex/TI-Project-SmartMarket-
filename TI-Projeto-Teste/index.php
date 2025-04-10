<?php
session_start();
include("Credenciais/Logins");

$formFoiSubmetido = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'])) {
        if ($_POST['username'] == $username1 && password_verify($_POST['password'], $password_hash1)) {
            $_SESSION['username'] = $username1;
            header("Location: dashboard.php");
            exit;
        } elseif ($_POST['username'] == $username2 && password_verify($_POST['password'], $password_hash2)) {
            $_SESSION['username'] = $username2;
            header("Location: dashboard.php");
            exit;
        } else {
            $erroLogin = "Username ou password está errada!";
        }
    } else {
        $erroLogin = "Por favor, preencha todos os campos!";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="backgroundindex">
        <div class="container">
            <div class="row justify-content-center">
                <form class="AulaForm was-validated" method="post">
                    <h1 class="container d-flex justify-content-around align-items-center" style="font-family: Verdana; font-weight: bold; color: #FFD14B">
                        Login
                    </h1>
                    <div class="mb-3">
                        <label for="exampleInputUser1" class="form-label"></label>
                        <input type="text" id="exampleInputUser1" placeholder="Username" name="username" required>
                    </div iv>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label"></label>
                        <input type="password" id="exampleInputPassword1" placeholder="Password" name="password" required>
                        <?php if (!empty($erroLogin)): ?>
                            <div class="text-danger mt-2"><?= $erroLogin ?></div>
                        <?php endif; ?>
                        <p></p>
                        <button type="submit" class="button">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>