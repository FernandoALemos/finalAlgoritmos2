<?php
    require "materiasClase.php";

    #region clase Carrera
    class Carrera{

        #region atributos
        private $id;
        private $carrera;
        private $dias;
        private $turno;
        #endregion

        #region constructor
        public function __construct($id,$carrera,$dias,$turno){
            $this->id = $id;
            $this->carrera = $carrera;
            $this->dias = $dias;
            $this->turno = $turno;
        }
        #endregion
        
        #region crearCarrera
        public function crearCarrera(){
            $con = condb();
            $text = "";

            mysqli_query($con, "insert into carreras (nombreCarrera,diasCursada,turno) values ('$this->carrera','$this->dias','$this->turno');");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva carrera agregada al sistema" : $text = "No se pudo agregar una nueva carrera al sistema";

            return $text;
        }
        #endregion

        #region modificarCarrera
        public function modificarCarrera(){
            $con = condb();
            $text = "";

            mysqli_query($con, "update carreras set nombreCarrera = '$this->carrera', diasCursada = '$this->dias', turno = '$this->turno' where id = $this->id;");
            
            (mysqli_affected_rows($con) > 0) ? $text = "Carrera modificada correctamente" : $text = "No se pudo modificar la carrera";

            return $text;
        }
        #endregion

        #region eliminarCarrera
        public static function eliminarCarrera($id){
            $con = condb();
            $text = "" ;

            mysqli_query($con,"delete from carreras where id = $id");

            (mysqli_affected_rows($con) > 0) ? $text = "Carrera Eliminada permanentemente" : $text = "No se pudo eliminar la carrera. Por favor corrobore que esta carrera no tenga materias asignadas.";  

            return $text;
        }
        #endregion

        #region listarCarreras
        public static function listarCarreras(){
            $con = condb();

            $data = mysqli_query($con,"select * from carreras;");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay carreras registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['id']; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td><?php echo $info['diasCursada']; ?></td>
                        <td><?php echo $info['turno']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="vista.php?pan=1 & acc=8 & id=<?php echo $info['id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="eliminar" href="vista.php?pan=1 & acc=9 & id=<?php echo $info['id']; ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region buscarCarreras
        public static function buscarCarreras(){
            $con = condb();

            $data = mysqli_query($con, "select * from carreras;");

            return $data;
        }
        #endregion

        #region buscarCarrera
        public static function buscarCarrera($id){
            $con = condb();

            $data = mysqli_query($con, "select * from carreras where id = $id");

            return $data;
        }
        #endregion

    }
    #endregion

?>