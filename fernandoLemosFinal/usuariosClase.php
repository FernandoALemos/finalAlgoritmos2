<?php 
    function condb (){
        $serv="localhost";
        $usr="root";
        $pss="";
        $bd="finalAlgoritmos2_FernandoLemos";
        $c=mysqli_connect($serv, $usr, $pss, $bd);
        return $c;
    }

    #region clase Usuario
    class Usuario {

    #region atributos
        private $id;
        private $nombre;
        private $apellido;
        private $rol; // 1 para administrador 2 para profesor 3 para alumno
        private $contraseña;
        private $email;
        private $dni;
        private $estado; // 1 activo 2 suspendido
    #endregion

    #region constructor
        public function __construct($id,$nombre,$apellido,$rol,$contraseña,$email,$dni,$estado){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->rol = $rol;
            $this->contraseña = $contraseña;
            $this->email = $email;
            $this->dni = $dni;
            $this->estado = $estado;
        }
    #endregion

    #region crearUsuario
        public function crearUsuario(){
            $con = condb();
            $text = "";

            mysqli_query($con,"insert into usuarios (nombre,apellido,rol,contraseña,email,dni,idEstado) values ('$this->nombre','$this->apellido',$this->rol,'$this->contraseña','$this->email',$this->dni,$this->estado);");

            (mysqli_affected_rows($con) > 0) ? $text = "Nuevo usuario agregado al sistema" : $text =" No se pudo generar un nuevo usuario";

            return $text;
        }
    #endregion

    #region modificarUsuario
        public function modificarUsuario(){
            $con = condb();
            $texto = "";

            mysqli_query($con,"update usuarios set nombre = '$this->nombre', apellido = '$this->apellido' , rol = '$this->rol', contraseña = '$this->contraseña', email = '$this->email', dni = $this->dni , idEstado = $this->estado where id = $this->id;");

            (mysqli_affected_rows($con) > 0) ? $texto = 'Usuario modificado correctamente' : $texto = 'No se pudo modificar al usuario correctamente';

            return $texto;
        }
    #endregion

    #region eliminarUsuario
        public static function eliminarUsuario($id){
            $con = condb();
            $text = "" ;

            mysqli_query($con,"delete from usuarios where id = $id");

            (mysqli_affected_rows($con) > 0) ? $text = 'Usuario eliminado permanentemente' : $text = 'No se pudo eliminar al usuario correctamente';

            return $text;
        }
    #endregion

    #region VerificarUsuario
        public static function VerificarUsuario($dni,$contraseña){
            $con = condb();
            
            if ($dni != "" && $contraseña != ""){
                $usu = mysqli_query($con , "select dni from usuarios where dni = $dni");
                if(mysqli_affected_rows($con)>0){
                    $contra = mysqli_query($con, " select contraseña from usuarios where dni = $dni");
                    $contra = mysqli_fetch_assoc($contra);
                    if($contra['contraseña'] == $contraseña){
                        $data = mysqli_query($con,"select * from usuarios where dni = '$dni' ");
                        $info = mysqli_fetch_assoc($data);
                        session_start();
                        $_SESSION['id'] = $info['id'];
                        $_SESSION['nombre'] = $info['nombre'];
                        $_SESSION['apellido'] = $info['apellido'];
                        $_SESSION['rol'] = $info['rol'];
                        $_SESSION['email'] = $info['email'];
                        $_SESSION['dni'] = $dni;
                        $_SESSION['idEstado'] = $info['idEstado'];
                        header("location:vista.php");
                        // echo "<srcipt> window.location.href='fernandoLemosFinal/vista.php';</script>";
                    }else{
                        echo "Contraseña invalida";
                    }
                }else{
                    echo "DNI invalido";
                }
            }
        }
    #endregion

    #region buscarUsuario
        public static function buscarRol($rol){
            $con = condb();
            
            $data = mysqli_query($con, "select * from usuarios where rol = $rol;");

            return $data;
        }
    #endregion

    #region listarUsuarios
        public static function listarUsuarios(){
            $con = condb();

            $data = mysqli_query($con,"select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from usuarios inner join roles on usuarios.rol = roles.id inner join estados on usuarios.idEstado = estados.id order by id;");
            
            while ($info = mysqli_fetch_assoc($data)){ ?>
                <tr>
                    <td><?php echo $info['id']; ?></td>
                    <td><?php echo $info['nombre']; ?></td>
                    <td><?php echo $info['apellido']; ?></td>
                    <td><?php echo $info['dni']; ?></td>
                    <td><?php echo $info['email']; ?></td>
                    <td><?php echo $info['contraseña']; ?></td>
                    <td><?php echo $info['nombreRol']; ?></td>
                    <td><?php echo $info['nombreEstado']; ?></td>
                    <td>
                        <p class="acciones">
                            <a class="modificar" href="vista.php?pan=1 & acc=1 & id=<?php echo $info['id']; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="eliminar" href="vista.php?pan=1 & acc=2 & id=<?php echo $info['id']; ?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </p>
                    </td>
                </tr>
    <?php   }
        }
    #endregion

    #region formModificarUsuario
        public static function formModificarUsuario($id){
            $con = condb();

            $data = mysqli_query($con,"select * from usuarios where id = $id;");

            $info = mysqli_fetch_assoc($data);

            ?>

            <form class="formVista" method="POST" action="vista.php">
                <div class="formVista-inputs">
                    <label for="id">ID<input type="text" class="inputVista corto" name="id"  id="id" readonly value="<?php echo $info['id']; ?>"></label>
                    <label for="nombre">NOMBRE<input type="text" class="inputVista" name="nombre" onkeyup="this.value = this.value();" id="nombre" value="<?php echo $info['nombre']; ?>"></label>
                    <label for="apellido">APELLIDO<input type="text" class="inputVista" name="apellido" onkeyup="this.value = this.value();" id="apellido" value="<?php echo $info['apellido']; ?>"></label>
                    <label for="rol">ROL
                        <select class="inputVista" name="rol" id="rol">
                            <?php switch($info['rol']){
                                case 1: ?>
                                <option value="1">Administrador</option>
                                <option value="2">Profesor</option>
                                <option value="3">Alumno</option>
                                    <?php break;
                                case 2: ?>
                                <option value="2">Profesor</option>
                                <option value="1">Administrador</option>
                                <option value="3">Alumno</option>
                                <?php break;
                                case 3: ?>
                                <option value="3">Alumno</option>
                                <option value="1">Administrador</option>
                                <option value="2">Profesor</option>
                                <?php break;
                            }?>
                            
                        </select>
                    </label>
                    <label for="contraseña">CONTRASEÑA<input type="text" class="inputVista" name="contraseña" id="contraseña" value="<?php echo $info['contraseña']; ?>"></label>
                    <label for="email">EMAIL<input type="text" class="inputVista" name="email" onkeyup="this.value = this.value();" id="email" value="<?php echo $info['email']; ?>"></label>
                    <label for="dni">DNI<input type="text" class="inputVista medio" name="dni" id="dni" value="<?php echo $info['dni']; ?>"></label>
                    <label for="estado">ESTADO
                        <select class="inputVista" name="estado" id="estado"><?php
                        switch($info['idEstado']){
                            case 1: ?>
                            <option value="1">Activo</option>
                            <option value="2">Suspendido</option>
                                <?php break;
                            case 2: ?>
                            <option value="1">Activo</option>
                            <option value="2">Suspendido</option>
                            <?php break;
                            }?>
                        </select>
                    </label>
                </div >
                <div>
                    <label for="confirmar_cambios"><input type="checkbox" name="confirmar" id="confirmar_cambios" value="1" required> Confirmar cambios</label>
                    <input type="hidden" name="pan" value="1"> 
                    <button type="submit" class="btn-ok">Modificar</button>
                    <a href="vista.php#Usuarios" class="btn-no ancora">Cancelar</a>
                </div>
            </form>

        <?php }

        #endregion

    }
    #endregion

?>