<?php
require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        $message = 'El usuario se creo satisfactoriamente.';
    } else {
        $message = 'Disculpe, hubo un error al crear el usuario.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="left-content">
            <h1></h1> <!-- Eliminé el texto del título -->
            
            <div class="slider-img">
            <p>Los mejores por calidad y precio.</p>
            <img src="../imagenes/logo.jpeg" alt="Logo de Avícola El León">
            </div>
        </div>
        <div class="right-content">
            <div class="login-container">
                <?php if (!empty($message)): ?>
                    <p class="message"><?= $message ?></p>
                <?php endif; ?>
                
                <h1>Registrarse</h1>
                <span>or <a href="inicio.php">Inicio de sesión</a></span>
    
                <form action="registro.php" method="POST">
                    <input name="email" type="text" placeholder="Ingrese su correo">
                    <input name="password" type="password" placeholder="Ingrese su contraseña">
                    <input type="submit" value="Registrar">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
