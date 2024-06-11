<?php
session_start();

require 'database.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT Id, email, password FROM usuarios WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if ($results && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['usuario_Id'] = $results['Id'];
        header("Location: ../Crud_productos/index2.php");
        exit;
    } else {
        $message = 'Las credenciales no coinciden';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Hotjar Tracking Code for http://localhost/Paginaweb/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:5019364,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>
<body>
    <div class="container">
        <div class="left-content">
            <h1></h1>
            
            <div class="eslogan-image">
                <p>Los mejores por calidad y precio.</p>
                <img src="../imagenes/logo.jpeg" alt="Logo de Avícola El León">
            </div>
        </div>
        <div class="right-content">
            <div class="login-container">
                <?php if(!empty($message)): ?>
                    <p class="message"><?= $message ?></p>
                <?php endif; ?>
                
                <h1>Inicio de sesión</h1>
                <span>or <a href="registro.php">Registrarse</a></span>
    
                <form action="inicio.php" method="post">
                    <input name="email" type="text" placeholder="Ingrese su correo">
                    <input name="password" type="password" placeholder="Ingrese su contraseña">
                    <input type="submit" value="Iniciar sesión">
                </form>
               
            </div>
        </div>
    </div>
</body>
</html>
