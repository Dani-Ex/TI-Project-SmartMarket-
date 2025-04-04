<?php
session_start();
$username = "Daniel";
$password_hash = '$2y$10$7fmPummW3UUV.nDrQ4lREuVF3DYw3uMQ6YN9U316o2pb6/RnoC.Im';


if (isset($_POST['password']) && password_verify($_POST['password'], $password_hash)) {
    echo 'Password correta!';
    $_SESSION["username"]=$_POST['username'];
    header("Location: dashboard.php");
} else {
    echo "Password está errada!";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <form class="AulaForm was-validated" method="post">
                <a href="index.php"><img src="estg_h.png" alt="Estg_H"></a>
                <div class="mb-3">
                    <label for="exampleInputUser1" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="exampleInputUser1" placeholder="Insira o seu username" name="username" required>
                    <div class="valid-feedback">Valid.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Insira a sua password" name="password" required>
                    <div class="valid-feedback">Valid.</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>