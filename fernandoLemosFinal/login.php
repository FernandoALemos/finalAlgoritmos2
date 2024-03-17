<?php 
    require_once "carrerasClase.php";
    require_once "materiasClase.php";
    require_once "notasClase.php";
    require_once "usuariosClase.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>I.S.F.D. y T. N 24 - "Final"</title>
    <link rel="shortcut icon" type="image/x-icon" href="alumno.ico">
</head>

<body>
    <header>
        <div class="header-div">
            <nav class="header_div-nav">
                <div class="header_div-nav-box">
                <a href="index.php" class="header_div_nav-item">Inicio</a>
                <div class="header_div-nav-box">
            </nav>
        </div>
    </header>
    <main class="imagen">
        <div class="contenedorLogin">
            <form class="contenedorLogin-form" method="POST">
                <label class="contenedorLogin_form-label" for="dni">
                    Ingrese su dni
                    <input class="contenedorLogin_form_label-input" type="number" name="dni" id="dni" placeholder="00000000" maxlength="8" required>
                </label>
                <label class="contenedorLogin_form-label" for="contra">
                    Ingrese su contraseña
                    <input class="contenedorLogin_form_label-input" type="password" name="contrasenia" id="contra" placeholder="***********" required>
                </label>
                <div class="contenedorLogin_form-cajaBtn">
                    <button class="btn-ok" type="submit">Acceder</button>
                </div>
            </form>
            <div class="contenedorLogin-cajaMensaje">
                <p class="contenedorLogin_cajaMensaje-Texto">
                    <?php 
                        if( isset($_POST['dni']) )
                            Usuario::VerificarUsuario($_POST['dni'],$_POST['contrasenia'])
                    ?>
                </p>
            </div>
        </div>
    </main>
    <footer>
        <font-size="5"><h4><p class="titulos blanco" ><font-size="5">Pasaje Crámer 471 – Bernal – Buenos Aires.</p><br>
        <p class="titulos blanco">Contactanos Tel: 4444-1234, Email: institofalso@gmail.com</p></h4></font-size>
    </footer>
</body>

</html>