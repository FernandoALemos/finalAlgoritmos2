<?php 

    session_start();
    
    (isset($_GET['close']) && $_GET['close'] === 'true') ? session_destroy() : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
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
                    </div>
                    <div class="header_div-nav-box">
                        <a href="login.php" class="header_div_nav-item">Ingresar</a>
                    </div>
                </nav>
            </div>
    </header>
    <main>
        <div class="imagen">
        <section class="presentacion">
            <p>Sistema de gestion de alumnos para el final de Algoritmos y estructura de datos 2 I.S.F.D y T N° 24 DR. Bernardo Houssay | Bernal.</p>
            <p>CONSIGNA:</p>
            <p>- Crear un sistema para una institución educativa que me permita ver, cargar y modificar las notas de los alumnos, y me permita cargar la nota final solamente cuando el alumno tenga los dos parciales aprobados. </p>
            <p>- Debe tener altas bajas y modificaciones de alumnos, ademas de las notas..</p> 
            <p>- Puede haber una o más materias (plus si tengo ABM materias).</p> 
            <p>- Usuario profesor (ABM notas) y administrador (ABM alumnos, materias)</p> 
            <p>- Pueden usar POO o programación estructurada, lo que les resulte más cómodo.</p>
            <p class="titulos">Ingreso al sistema como admin ó profesor <br>Usuario: 9999 Contraseña: admin123 <br>Usuario: 26456127 Contraseña: eboirek</p>
        </section>
        </div>
    </main>
    <footer>
        <font-size="5"><h4><p class="titulos blanco" ><font-size="5">Pasaje Crámer 471 – Bernal – Buenos Aires.</p><br>
        <p class="titulos blanco">Contactanos Tel: 4444-1234, Email: instituofalso@gmail.com</p></h4></font-size>
    </footer>
</body>

</html>