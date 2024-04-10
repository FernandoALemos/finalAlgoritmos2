<?php
    require_once "carrerasClase.php";
    require_once "materiasClase.php";
    require_once "notasClase.php";
    require_once "usuariosClase.php";

    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['idEstado'] === '0'){
        die("No tenes credenciales para ingresar a este sitio. Intenta <a href='index.php'> registrate</a>.");
    }

    $idSESION = $_SESSION['id'];

    // Admin: No deberia mostrarme las contraseñas de los usuarios!! Si quiero cambiarla puedo usar input type password. (HECHO) CHECK usuariosClase linea 176
    // Los campos para altas deberian ser obligatorios (al menos los necesarios) (HECHO) CHECK
    // campo email deberia validar y no dejar ingresar cualquier cosa. (Verifica que no se duplique un mail) (HECHO)
    // Si intento eliminar alumno asignado me da error fatal (YA POSEE UN MENSAJE PARA ELIMINAR UN ALUMNO O SUSPENDERLO, IDEM PARA PROFESOR)
    // Eliminar solamente la materia asignada al alumno y no todas las que tiene asignadas (VERIFICAR, HECHO EN notasClase LINEA 122)
    // FILTRAR POR USUARIOS ACTIVOS CUANDO QUIERO AGREGAR
    // Profe: No cumple consigna! Me permite cargar final cuando no tiene los parciales aprobados!! (HECHO) CHECK
    // Si intento modificar las notas del parcial uno aparece error fatal. (CHECK)
    // Si no funciona dejar en blanco notas, deben ser campos obligatorios.

    // CORREGIR PARA FEBRERO
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vista.css">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>I.S.F.D. y T. N 24 - "Final"</title>
    <link rel="shortcut icon" type="image/x-icon" href="alumno.ico">
</head>

<body>
    <header>
            <div class="header-div">
                <nav class="header_div-nav">
                    <div class="header_div-nav-box">
                        <a href="vista.php" class="header_div_nav-item">Inicio</a>
                        <?php
                            switch($_SESSION['rol']){
                                case 1: // admin?>
                                    <a href="#Usuarios" class="header_div_nav-item">Usuarios</a>
                                    <a href="#Carreras" class="header_div_nav-item">Carreras</a>
                                    <a href="#Materias" class="header_div_nav-item">Materias</a>
                                    <a href="#inscribir" class="header_div_nav-item">Asignaturas</a>
                                <?php
                                    break;
                                case 2: // profe ?>
                                    <a href="#" class="header_div_nav-item">Notas</a>
                                <?php
                                    break;
                                case 3: //alumno ?>
                                    <a href="#" class="header_div_nav-item">Notas</a>
                                <?php
                                    break;
                            }
                        ?>
                    </div>
                    <div class="header_div-nav-box"><a href="index.php?close=true" class="header_div_nav-item">Salir</a></div>
                </nav>
            </div>
    </header>
    <main class="Vista">

        <?php
        switch($_SESSION['rol']){
            case 1: // admin

                #region Usuarios
                ?>
                <section id="Usuarios" class="divUsuarios">
                    <div class="divUsuarios-cabecera">
                        <p class="titulos" >Administración de usuarios</p>
                        <a href="vista.php?pan=1&acc=3#Usuarios" class="btn-ok ancora">Agregar nuevo usuario</a>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>DNI</th>
                    <th>EMAIL</th>
                    <th>CONTRASEÑA</th>
                    <th>ROL</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Usuario::listarUsuarios();
                    ?>
                    </tbody>
                    </table>
                </section>
                <?php
                #endregion

                #region Carreras
                ?>
                <section id="Carreras" class="divCarreras">
                    <div class="divCarreras-cabecera">
                        <p class="titulos" >Administración de carreras</p>
                        <a href="vista.php?pan=1&acc=7#Carreras" class="btn-ok ancora">Agregar nueva carrera</a>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>CARRERA</th>
                    <th>DÍAS</th>
                    <th>TURNO</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Carrera::listarCarreras();
                    ?>
                    </tbody>
                    </table>
                </section>
                <?php
                #endregion

                #region Materias
                ?>
                <section id="Materias" class="divMaterias">
                    <div class="divMaterias-cabecera">
                        <p class="titulos" >Administración de materias</p>
                        <a href="vista.php?pan=1&acc=4#Matrequirederias" class="btn-ok ancora">Agregar nueva materia</a>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>MATERIA</th>
                    <th>PROFESOR</th>
                    <th>CARRERA</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Materia::listarMaterias();
                    ?>
                    </tbody>
                    </table>
                </section>
            <?php
                #endregion

                #region Inscripciones
                ?>
                <section id="inscribir" class="divMaterias">
                    <div class="divMaterias-cabecera">
                        <p class="titulos" >Asignaturas</p>
                        <a href="vista.php?pan=1&acc=10#inscribir" class="btn-ok ancora">Inscribir alumno</a>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ALUMNO</th>
                    <th>MATERIA</th>
                    <th>CARRERA</th>
                    <th>PARCIAL 1</th>
                    <th>PARCIAL 2</th>
                    <th>FINAL</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Notas::listarNotas();
                    ?>
                    </tbody>
                    </table>
                </section>
                <?php break;
            #endregion

            case 2: // profe

                #region Administrar notas
                ?>
                <section id="Notas" class="divNotas">
                    <div class="divNotas-cabecera">
                        <p class="titulos" >Administración de notas de alumnos</p>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ALUMNO</th>
                    <th>CARRERA</th>
                    <th>MATERIA</th>
                    <th>1er PARCIAL</th>
                    <th>2do PARCIAL</th>
                    <th>FINAL</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Notas::listarNotasEditables($_SESSION['id']);
                    ?>
                    </tbody>
                    </table>
                </section>
                <?php
                break;
                #endregion

            case 3: //alumno
            ?>
            <section id="inscribir" class="divMaterias">
                    <div class="divMaterias-cabecera">
                        <p class="titulos" >Materias y carreras encontradas para <?php echo $_SESSION['nombre'] ." " .$_SESSION['apellido'] ?></p>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>DOCENTE</th>
                    <th>MATERIA</th>
                    <th>CARRERA</th>
                    <th>PARCIAL 1</th>
                    <th>PARCIAL 2</th>
                    <th>FINAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Notas::listarNotasAlumno($_SESSION['id']);
                    ?>
                    </tbody>
                    </table>
                </section>
            <?php
                break;
        }

        if(isset($_GET['pan']) && $_GET['pan'] == '1' || isset($_POST['pan']) && $_POST['pan'] == '1'){
        ?>
        <section class="cajaSpot">
            <a class="cajaSpot-cierre" href="vista.php"></a>
                <?php if(isset($_GET['acc'])){
                    switch($_GET['acc']){

                        #region modificarUsuario
                        case 1: ?>
                            <div class="cajaSpot_cierre-modificar altura">
                                <p class="titulos">Modificar usuario</p> <?php
                                $id = $_GET['id'];
                                Usuario::formModificarUsuario($id); ?>
                            </div> <?php
                        break;
                        #endregion

                        #region eliminarUsuario
                        case 2: ?>
                            <div class="cajaSpot_cierre-eliminar altura"> <?php
                                $id = $_GET['id'];
                                $con = condb();
                                $info = mysqli_query($con, " select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contrasenia, usuarios.email, usuarios.dni, estados.nombreEstado from (( usuarios inner join roles on usuarios.rol = roles.id) inner join estados on usuarios.idEstado = estados.id) where usuarios.id = $id;");
                                $data = mysqli_fetch_assoc($info); ?>
                                <p>Esta a punto de <b class="bold red">ELIMINAR</b> de forma <b class="bold red">PERMANENTE</b> al siguiente usuario.</p>
                                    <div class="cajaSpot_cierre_eliminar-info">
                                        <div class="cajaSpot_cierre_eliminar_info-usuario">
                                            <p><b class="bold">Nombre: </b><?php echo $data['nombre'];?></p>
                                            <p><b class="bold">Apellido: </b><?php echo $data['apellido'];?></p>
                                            <p><b class="bold">DNI: </b><?php echo $data['dni'];?></p>
                                            <p><b class="bold">Email: </b><?php echo $data['email'];?></p>
                                            <p><b class="bold">Rol: </b><?php echo $data['nombreRol'];?></p>
                                            <p><b class="bold">Estado: </b><?php echo $data['nombreEstado'];?></p>
                                        </div>
                                        <div class="cajaSpot_cierre_eliminar_info-mensaje">
                                            <p>¿Está seguro que desea eliminar de forma permanente a <b class="bold"><?php echo $data['nombre']?></b> ?</p>
                                            <p>Tenga en cuenta que puede cancelar el acceso al usuario cambiando el estado del usuario por <b class="bold red">suspendido</b>.</p>
                                            <p>Para <b class="bold red">ELIMINAR</b> a este usuario asegurese de haber limpiado su historial, eliminando sus notas en caso de ser alumno, o eliminando sus materias asignadas en caso de ser profesor.</p>
                                        </div>
                                    </div>
                                    <form class="cajaSpot_cierre_eliminar_info-opciones" method="POST" action="vista.php">
                                        <label for="confirmar">
                                            <input type="checkbox" name="confirmar" id="confirmar" value="2" required>
                                            Confirmar
                                        </label>
                                        <input type="hidden" name="pan" value="1">
                                        <input type="hidden" name="id" value ="<?php echo $data['id'] ?>">
                                        <div>
                                            <button type="submit" class="btn-no">Eliminar Permanentemente</button>
                                            <a href="vista.php#Usuarios" class="btn-ok ancora">Cancelar</a>
                                        </div>
                                    </form>
                            </div><?php
                        break;
                        #endregion

                        #region crearusuario
                        case 3: ?>
                            <div class="cajaSpot_cierre-crearUsuario altura">
                                <p class="titulos">Agregar nuevo usuario</p>
                                <form class="formVista" method="POST" action="vista.php">
                                    <div class="formVista-inputs">
                                        <label for="nombre">NOMBRE<input type="text" class="inputVista" name="nombre" onkeyup="this.value = this.value();" id="nombre" required></label>
                                        <label for="apellido">APELLIDO<input type="text" class="inputVista" onkeyup="this.value = this.value();" name="apellido" id="apellido" required></label>
                                        <label for="dni">DNI<input type="text" class="inputVista medio" name="dni" id="dni" required></label>
                                        <label for="rol">ROL
                                            <select class="inputVista" name="rol" id="rol">
                                                    <option value="3">Alumno</option>
                                                    <option value="2">Profesor</option>
                                                    <option value="1">Administrador</option>
                                            </select>
                                        </label>
                                        <label for="contrasenia">CONTRASEÑA<input type="text" class="inputVista" name="contrasenia" id="contrasenia" required></label>
                                        <label for="email">EMAIL<input type="text" class="inputVista" onkeyup="this.value = this.value();" name="email" id="email" required></label>
                                        <label for="estado">ESTADO
                                            <select class="inputVista" name="estado" id="estado">
                                                <option value="1">Activo</option>
                                                <option value="2">Suspendido</option>
                                            </select>
                                        </label>
                                    </div >
                                    <div>
                                        <label for="agregar"><input type="checkbox" name="confirmar" id="agregar" value="3" required> Confirmar </label>
                                        <input type="hidden" name="pan" value="1">
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="vista.php#Usuarios" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php break;
                        #endregion

                        #region crearMateria
                        case 4:
                            $info = Usuario::buscarRol(2);
                            $info2 = Carrera::buscarCarreras();
                        ?>
                            <div class="cajaSpot-cierre-crearMateria altura">
                                <p class="titulos">Agregar nueva materia</p>
                                <form class="formVista" method="POST" action="vista.php">
                                    <div class="formVista-inputs">
                                        <label for="materia">MATERIA<input type="text" class="inputVista" name="materia" onkeyup="this.value = this.value();" id="materia" required></label>
                                        <label for="profesor" required>PROFESOR
                                            <select class="inputVista" name="profesor" id="profesor">
                                                <?php
                                                    while($data = mysqli_fetch_assoc($info)){ ?>
                                                    <option value="<?php echo $data['id'];?>"><?php echo $data['nombre'] ." " .$data['apellido'] ." DNI: " .$data['dni'];?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </label>
                                        <label for="carrera" required>CARRERA
                                            <select class="inputVista" name="carrera" id="carrera" required>
                                                <?php
                                                    while($data2 = mysqli_fetch_assoc($info2)){ ?>
                                                    <option value="<?php echo $data2['id'];?>"><?php echo $data2['nombreCarrera']?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </label>
                                    </div >
                                    <div>
                                        <label for="agregar"><input type="checkbox" name="confirmar" id="agregar" value="4" required> Confirmar</label>
                                        <input type="hidden" name="pan" value="1">
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="vista.php#Materias" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php break;
                        #endregion

                        #region modificarMateria
                        case 5: // vista modificar materia
                            $idMat = $_GET['id'];
                            $data = Materia::buscarMateria($idMat);
                            $info = Usuario::buscarRol(2);
                            $info2 = Carrera::buscarCarreras();
                            ?>
                            <div class="cajaSpot-cierre-crearMateria altura">
                                <p class="titulos">Modificar materia</p>
                                <form class="formVista" method="POST" action="vista.php">
                                    <div class="formVista-inputs">
                                        <label for="materia">MATERIA<input type="text" class="inputVista" name="materia" onkeyup="this.value = this.value();" id="materia" value="<?php echo $data['materia'] ?>"></label>
                                        <label for="profesor" required>PROFESOR
                                            <select class="inputVista" name="profesor" id="profesor">
                                                <option value="<?php echo $data['profesor'] ?>">
                                                    <?php echo $data['nombre'] ." " .$data['apellido'] ." DNI: " .$data['dni'];?>
                                                </option>
                                                <?php
                                                    while($opciones = mysqli_fetch_assoc($info)){
                                                        if($opciones['id'] != $data['profesor']){?>
                                                    <option value="<?php echo $opciones['id'];?>">
                                                        <?php echo $opciones['nombre'] ." " .$opciones['apellido'] ." DNI: " .$opciones['dni'];?>
                                                    </option>
                                                    <?php }
                                                    }
                                                ?>
                                            </select>
                                        </label>
                                        <label for="carrera" required>CARRERA
                                            <select class="inputVista" name="carrera" id="carrera" required>
                                                <option value="<?php echo $data['carrera'] ?>">
                                                    <?php echo $data['nombreCarrera'];?>
                                                </option>
                                                <?php
                                                    while($data2 = mysqli_fetch_assoc($info2)){
                                                        if($data2['id'] != $data['carrera']){?>
                                                    <option value="<?php echo $data2['id'];?>">
                                                        <?php echo $data2['nombreCarrera']?>
                                                    </option>
                                                    <?php }
                                                    }
                                                ?>
                                            </select>
                                        </label>
                                    </div >
                                    <div>
                                        <label for="modificar"><input type="checkbox" name="confirmar" id="modificar" value="5" required> Confirmar</label>
                                        <input type="hidden" name="pan" value="1">
                                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                                        <button type="submit" class="btn-ok">Modificar</button>
                                        <a href="vista.php#Materias" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php
                        break;
                        #endregion

                        #region eliminarMateria
                        case 6: // vista eliminar materia ?>
                            <div class="cajaSpot_cierre-eliminar altura"> <?php
                                $id = $_GET['id'];
                                $con = condb();
                                $info = mysqli_query($con, "select materias.id, materias.materia, usuarios.nombre, usuarios.apellido, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id) where materias.id = $id;");
                                $data = mysqli_fetch_assoc($info); ?>
                                <p>Esta a punto de <b class="bold red">ELIMINAR</b> de forma <b class="bold red">PERMANENTE</b> la siguiente materia.</p>
                                    <div class="cajaSpot_cierre_eliminar-info">
                                        <div class="cajaSpot_cierre_eliminar_info-usuario">
                                            <p><b class="bold">MATERIA: </b><?php echo $data['materia'];?></p>
                                            <p><b class="bold">PROFESOR: </b><?php echo $data['nombre'] ." " .$data['apellido'];?></p>
                                            <p><b class="bold">CARRERA: </b><?php echo $data['nombreCarrera'];?></p>
                                        </div>
                                        <div class="cajaSpot_cierre_eliminar_info-mensaje">
                                            <p></p>
                                        </div>
                                    </div>
                                    <form class="cajaSpot_cierre_eliminar_info-opciones" method="POST" action="vista.php">
                                        <label for="confirmar">
                                            <input type="checkbox" name="confirmar" id="confirmar" value="6" required>
                                            Confirmar
                                        </label>
                                        <input type="hidden" name="pan" value="1">
                                        <input type="hidden" name="id" value ="<?php echo $data['id'] ?>">
                                        <div>
                                            <button type="submit" class="btn-no">Eliminar Permanentemente</button>
                                            <a href="vista.php#Materias" class="btn-ok ancora">Cancelar</a>
                                        </div>
                                    </form>
                            </div><?php
                        break;
                        #endregion

                        #region crearCarrera
                        case 7:
                        ?>
                        <div class="cajaSpot-cierre-crearCarrera altura">
                                <p class="titulos">Agregar nueva carrera</p>
                                <form class="formVista" method="POST" action="vista.php">
                                    <div class="formVista-inputs">
                                        <label for="carrera">CARRERA<input type="text" class="inputVista" name="carrera" onkeyup="this.value = this.value();" id="carrera" required></label>
                                        <label for="dias">DÍAS<input type="text" class="inputVista" name="dias" onkeyup="this.value = this.value();" id="dias" placeholder="Lunes a Viernes - Lunes ,Miercoles ,Viernes" required></label>
                                        <label for="turno">TURNO<input type="text" class="inputVista" name="turno" onkeyup="this.value = this.value();" id="turno" placeholder="Mañana ,Tarde ,Vespertino" required></label>
                                    </div >
                                    <div>
                                        <label for="agregar"><input type="checkbox" name="confirmar" id="agregar" value="7" required> Confirmar</label>
                                        <input type="hidden" name="pan" value="1">
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="vista.php#Carreras" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php
                        break;
                        #endregion

                        #region modificarCarrera
                        case 8: // vista modificar carrera
                            $info = Carrera::buscarCarrera($_GET['id']);
                            $data = mysqli_fetch_assoc($info);
                            ?>
                            <div class="cajaSpot-cierre-crearCarrera altura">
                                <p class="titulos">Modificar carrera</p>
                                <form class="formVista" method="POST" action="vista.php#Carreras">
                                    <div class="formVista-inputs">
                                        <label for="carrera">CARRERA<input type="text" class="inputVista" name="carrera" onkeyup="this.value = this.value();" id="carrera" value="<?php echo $data['nombreCarrera'] ?>"></label>
                                        <label for="dias">DÍAS<input type="text" class="inputVista" name="dias" onkeyup="this.value = this.value();" id="dias"  value="<?php echo $data['diasCursada'] ?>"></label>
                                        <label for="turno">TURNO<input type="text" class="inputVista" name="turno" onkeyup="this.value = this.value();" id="turno" value="<?php echo $data['turno'] ?>"></label>
                                    </div >
                                    <div>
                                        <label for="modificar"><input type="checkbox" name="confirmar" id="modificar" value="8" required> Confirmar</label>
                                        <input type="hidden" name="pan" value="1">
                                        <input type="hidden" name="id" value="<?php echo $data['id']?>">
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="vista.php#Carreras" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                            <?php
                        break;
                        #endregion

                        #region eliminarCarreara
                        case 9: //vista eliminar carrera ?>
                            <div class="cajaSpot_cierre-eliminar altura"> <?php
                                $id = $_GET['id'];
                                $con = condb();
                                $info = mysqli_query($con, "select * from carreras where id = $id;");
                                $data = mysqli_fetch_assoc($info); ?>
                                <p>Esta a punto de <b class="bold red">ELIMINAR</b> de forma <b class="bold red">PERMANENTE</b> la siguiente carrera.</p>
                                    <div class="cajaSpot_cierre_eliminar-info">
                                        <div class="cajaSpot_cierre_eliminar_info-usuario">
                                            <p><b class="bold">CARRERA: </b><?php echo $data['nombreCarrera'];?></p>
                                            <p><b class="bold">DIAS DE CURSADA: </b><?php echo $data['diasCursada'];?></p>
                                            <p><b class="bold">TURNO: </b><?php echo $data['turno'];?></p>
                                        </div>
                                        <div class="cajaSpot_cierre_eliminar_info-mensaje">
                                            <p>Para poder <b class="bold red">ELIMINAR</b> permanentemente esta carrera en primer lugar debe eliminar todas las materias que esta tenga asignada.</p>
                                        </div>
                                    </div>
                                    <form class="cajaSpot_cierre_eliminar_info-opciones" method="POST" action="vista.php">
                                        <label for="confirmar">
                                            <input type="checkbox" name="confirmar" id="confirmar" value="9" required>
                                            Confirmar
                                        </label>
                                        <input type="hidden" name="pan" value="1">
                                        <input type="hidden" name="id" value ="<?php echo $data['id'] ?>">
                                        <div>
                                            <button type="submit" class="btn-no">Eliminar Permanentemente</button>
                                            <a href="vista.php#Carreras" class="btn-ok ancora">Cancelar</a>
                                        </div>
                                    </form>
                            </div><?php
                        break;
                        #endregion

                        #region inscribirAlumno
                        // VER COMO CONCATENAR BUSCARROL(3) CON BUSCARESTADO(1) PARA QUE SOLAMENTE ME DEJE INSCRIBIR ALUMNOS ACTIVOS (IDEM PARA PROFES)
                        case 10:
                            $info = Usuario::buscarRol(3);
                            $info2 = Carrera::buscarCarreras();
                        ?>
                        <div class="cajaSpot-cierre-crearMateria altura">
                                <p class="titulos">Inscribir alumno</p>
                                <form class="formVista" method="POST" action="vista.php">
                                    <div class="formVista-inputs">
                                        <label for="alumno" required>ALUMNO
                                            <select class="inputVista" name="alumno" id="alumno">
                                                <?php
                                                    while($data = mysqli_fetch_assoc($info)){ ?>
                                                    <option value="<?php echo $data['id'];?>"><?php echo $data['nombre'] ." " .$data['apellido'] ." DNI: " .$data['dni'];?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </label>
                                        <label for="carrera" required>CARRERA
                                            <select class="inputVista" name="carrera" id="carrera" required>
                                                <?php
                                                    while($data2 = mysqli_fetch_assoc($info2)){ ?>
                                                    <option value="<?php echo $data2['id'];?>"><?php echo $data2['nombreCarrera']?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </label>
                                    </div >
                                    <div>
                                        <label for="agregar"><input type="checkbox" name="confirmar" id="agregar" value="10" required> Confirmar</label>
                                        <input type="hidden" name="pan" value="1">
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="vista.php#inscribir" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php
                        break;
                        #endregion

                        #region eliminarInscripcion
                            // REVISAR PARA QUE SE ELEMINE LA MATERIA Y NO TODA LA CARRERA
                        case 11: ?>
                        <div class="cajaSpot_cierre-eliminar altura"> <?php
                                $idU = $_GET['idU'];
                                $nombre = $_GET['alumno'];
                                $carrera = $_GET['carrera'];
                                // $materia = $_GET['materia'];?>
                                <p>Esta a punto de <b class="bold red">ELIMINAR</b> de forma <b class="bold red">PERMANENTE</b> la siguiente carrera asignada</p>
                                    <div class="cajaSpot_cierre_eliminar-info">
                                        <div class="cajaSpot_cierre_eliminar_info-usuario">
                                            <p>ALUMNO: <b class="bold"><?php echo $_GET['alumno'];?></b></p>
                                            <p>CARREA: <b class="bold"><?php echo $_GET['carrera'];?></b></p>
                                            <!-- <p>Materia: <b class="bold"><?php // echo $_GET['materia'];?></b></p> -->
                                        </div>
                                        <div class="cajaSpot_cierre_eliminar_info-mensaje">
                                        <!-- permanentemente esta materia dado que no cumplio con las notas para aprobar la cursada -->
                                            <p>Si <b class="bold red">ELIMINA</b> permanentemente esta asignatura se perderan las notas asignadas a las materias correspondientes entre el alumno y la carrera</p>
                                        </div>
                                    </div>
                                    <form class="cajaSpot_cierre_eliminar_info-opciones" method="POST" action="vista.php">
                                        <label for="confirmar">
                                            <input type="checkbox" name="confirmar" id="confirmar" value="11" required>
                                            Confirmar
                                        </label>
                                        <input type="hidden" name="pan" value="1">
                                        <input type="hidden" name="id" value ="<?php echo $_GET['idU'] ?>">
                                        <div>
                                            <button type="submit" class="btn-no">Eliminar asignatura</button>
                                            <a href="vista.php#inscribir" class="btn-ok ancora">Cancelar</a>
                                        </div>
                                    </form>
                            </div><?php
                        break;
                        #endregion

                        #region modificarNota
                            // MODIFICAR NOTA PARA QUE LAS NOTAS SE APRUEBEN CON 4-10 PARA QUE PUEDA APROBAR LA OTRA INSTANCIA
                            // agregar validacion para que pueda poner solamente un numero del 1 al 10 (puede ser float)
                            // PROBAR CREO QUE ESTA
                        case 12:
                        ?>
                        <div class="cajaSpot_cierre-eliminar altura"> <?php
                                $idU = $_GET['alumno'];
                                $idM = $_GET['idmateria'];
                                $nom = $_GET['nombre'];
                                $mat = $_GET['materia'];
                                $con = condb();
                                $info = mysqli_query($con, "select * from notas where idUsuario = $idU and idMateria = $idM;");
                                $data = mysqli_fetch_assoc($info); ?>
                                <p>Esta modificando las notas del alumno <b class="bold modificar"><?php echo "$nom" ?></b>.</p>
                                    <div class="cajaSpot_cierre_eliminar-info">
                                        <div class="cajaSpot_cierre_eliminar_info-usuario">
                                        <form class="cajaSpot_cierre_eliminar_info-opciones" method="POST" action="vista.php">
                                            <p>MATERIA <b class="bold"><?php echo $mat; ?></b></p>
                                            <label for="parcial1">PARCIAL 1
                                                <input type="number" maxlength="2" class="inputVista medio" name="parcial1" id="parcial1" value="<?php echo $data['notaParcial1']; ?>" min="1" max="10" required>
                                            </label>
                                            <?php if($data['notaParcial1'] != null){?>

                                            <label for="parcial2">PARCIAL 2
                                                <input type="number" class="inputVista medio" name="parcial2" id="parcial2" value="<?php echo $data['notaParcial2']; ?>" min="1" max="10" required>
                                            </label>
                                            <?php } else { ?>
                                                <input type="hidden" name="parcial2" value="null">
                                            <?php }
                                            if(($data['notaParcial2'] >= 4 && $data['notaParcial2'] <= 10)&& $data['notaParcial2'] != null && ($data['notaParcial1'] >= 4 && $data['notaParcial1'] <= 10) && $data['notaParcial1'] != null){?>
                                            <label for="final">FINAL
                                                <input type="number" class="inputVista medio" name="final" id="final" value="<?php echo $data['notaFinal']; ?>" min="1" max="10" required>
                                            </label>
                                            <?php } else { ?>
                                                <input type="hidden" name="final" value="null">
                                            <?php } ?>
                                        </div>
                                        <div class="cajaSpot_cierre_eliminar_info-mensaje">
                                            <p>Para poder <b class="bold modificar">MODIFICAR</b> la nota PARCIAL 2, debe haber cargado previamente la nota PARCIAL 1, y PARCIAL 2 para poder cargar FINAL.</p>
                                        </div>
                                    </div>
                                        <label for="confirmar">
                                            <input type="checkbox" name="confirmar" id="confirmar" value="12" required>
                                            Confirmar
                                        </label>
                                        <input type="hidden" name="pan" value="1">
                                        <input type="hidden" name="alumno" value ="<?php echo $idU ?>">
                                        <input type="hidden" name="materia" value ="<?php echo $idM ?>">
                                        <div>
                                            <button type="submit" class="btn-ok">Cargar notas</button>
                                            <a href="vista.php#inscribir" class="btn-no ancora">Cancelar</a>
                                        </div>
                                    </form>
                            </div><?php
                        break;
                        #endregion


                    }
                }
                if(isset($_POST['confirmar'])){ ?>
                <div class="cajaSpot_cierre-notif"><?php
                        switch($_POST['confirmar']){

                            case 1: // modificar usuario
                                $mods = new Usuario($_POST['id'],$_POST['nombre'],$_POST['apellido'],$_POST['rol'],$_POST['contrasenia'],$_POST['email'],$_POST['dni'],$_POST['estado'],);
                                $texto = $mods->modificarUsuario();
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 2: // eliminar usuario
                                $id = $_POST['id'];
                                if($id == "1"){
                                    echo "<b class='bold red'>¡¡ATENCIÓN!!</b> No se puede eliminar a este usuario del sistema";
                                    echo "<a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                                }else{
                                    $texto = Usuario::eliminarUsuario($id);
                                    echo $texto;
                                    echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                                }
                            break;
                            case 3: // agregar usuario
                                $nuevoUsuario = new Usuario(null,$_POST['nombre'],$_POST['apellido'],$_POST['rol'],$_POST['contrasenia'],$_POST['email'],$_POST['dni'],$_POST['estado']);
                                $dni = $_POST['dni'];
                                $email = $_POST['email'];
                                $con = condb();

                                //verificacion de informacion con base de datos
                                mysqli_query($con,"select * from usuarios where dni = $dni;");
                                if(mysqli_affected_rows($con) == 0){
                                        mysqli_query($con,"select * from usuarios where email = '$email';");
                                        if(mysqli_affected_rows($con) == 0){
                                            $texto = $nuevoUsuario->crearUsuario();
                                            echo $texto;
                                            echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                                        }else{
                                            echo "<b class='bold red'>¡Error al crear usuario!<b > El <b class='bold red'>EMAIL<b > ya esta en el sistema";
                                            echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                                        }
                                }else{
                                    echo "<b class='bold red'>¡Error al crear usuario!<b > El <b class='bold red'>DNI<b > ya esta en el sistema";
                                    echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                                }
                            break;
                            case 4: // agregar materia
                                $materia = new Materia(null,$_POST['materia'],$_POST['profesor'],$_POST['carrera']);
                                $texto = $materia-> crearMateria();
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 5: // modificar materia
                                $materias = new Materia($_POST['id'],$_POST['materia'],$_POST['profesor'],$_POST['carrera']);
                                $texto = $materias->modificarMateria();
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 6: // eliminar materia
                                $con = condb();
                                $texto = Materia::eliminarMateria($_POST['id']);
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 7: // agregar carrera
                                $carrera = new Carrera(null,$_POST['carrera'],$_POST['dias'],$_POST['turno']);
                                $texto = $carrera -> crearCarrera();
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 8: // modificar carrera
                                $carrera = new Carrera($_POST['id'], $_POST['carrera'],$_POST['dias'],$_POST['turno']);
                                $texto = $carrera -> modificarCarrera();
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 9: // eliminar carrera
                                $texto = Carrera::eliminarCarrera($_POST['id']);
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 10: // inscribir alumno
                                $nota = new Notas($_POST['alumno'],$_POST['carrera']);
                                $texto = $nota->asignarCarrera();
                                echo $texto; ?>
                                <a href='vista.php' class='btn-ok ancora'>Cerrar</a>
                                <?php
                            break;
                            case 11: // desasignar carrera VER PARA QUE SOLAMENTE SE LE DESASIGNE LA MATERIA probar con $texto = Notas::eliminarNota($_POST['id']);
                                $nota = new Notas($_POST['id'],null);
                                $texto = $nota->eliminarNotas();
                                echo $texto; ?>
                                <a href='vista.php' class='btn-ok ancora'>Cerrar</a>
                                <?php
                            break;
                            case 12: // modificar nota VER BIEN PARA QUE SE APRUEBE CON 4-10 SOLAMENTE

                                $modificacion = new Notas($_POST['alumno'],$_POST['materia']);
                                $modificacion->setNotas($_POST['parcial1'],$_POST['parcial2'],$_POST['final']);
                                $texto = $modificacion->modificarNotas();
                                echo $texto;
                                echo " <a href='vista.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                        }?>
                </div>
                <?php } ?>
        </section>
        <?php } ?>
    </main>
    <footer>
        <font-size="5"><h4><p class="titulos blanco" ><font-size="5">Pasaje Crámer 471 – Bernal – Buenos Aires.</p><br>
        <p class="titulos blanco">Contactanos Tel: 4444-1234, Email: institofalso@gmail.com</p></h4></font-size>
    </footer>
</body>

</html>

<?php

?>