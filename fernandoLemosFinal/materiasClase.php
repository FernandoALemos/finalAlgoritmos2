<?php
    require "usuariosClase.php";

    #region clase Materia
    class Materia{

        #region atributos
        private $id;
        private $materia;
        private $profesor;
        private $carrera;
        #endregion

        #region constructor
        public function __construct($id,$materia,$profesor,$carrera){
            $this->id = $id;
            $this->materia = $materia;
            $this->profesor = $profesor;
            $this->carrera = $carrera;
        }
        #endregion

        #region crearMateria
        public function crearMateria(){
            $con = condb();
            $text = "";

            mysqli_query($con, "insert into materias (materia,profesor,carrera) values ('$this->materia', $this->profesor, $this->carrera)");

            (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada al sistema" : $text =" No se pudo generar una nueva materia";

            return $text;
        }
        #endregion

        #region modificarMateria
        public function modificarMateria(){
            $con = condb();
            $texto = "";
            mysqli_query($con, "update materias set materia = '$this->materia', profesor = $this->profesor, carrera = $this->carrera where id = $this->id");

            (mysqli_affected_rows($con) > 0) ? $texto = "Materia modificada correctamente" : $texto = "No se pudo modificar la materia";

            return $texto;
        }
        #endregion

        #region eliminarMateria
        public static function eliminarMateria($id){
            $con = condb();
            $text = "";

            mysqli_query($con, "delete from materias where id = $id;");

            (mysqli_affected_rows($con) > 0) ? $text = "Materia eliminada correctamente" : $text = "No se pudo eliminar la materia";

            return $text;
        }
        #endregion

        #region listarMaterias
        public static function listarMaterias(){
            $con = condb();

            $data = mysqli_query($con,"select materias.id, materias.materia, usuarios.nombre, usuarios.apellido, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id);");
            
            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td><?php echo $info['id']; ?></td>
                        <td><?php echo $info['materia']; ?></td>
                        <td><?php echo $info['nombre'] ." " .$info['apellido']; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="vista.php?pan=1 & acc=5 & id=<?php echo $info['id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="eliminar" href="vista.php?pan=1 & acc=6 & id=<?php echo $info['id']; ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region buscarMateria
        public static function buscarMateria($id){
            $con = condb();
            
            $info = mysqli_query($con, "select materias.id, materias.materia, materias.profesor, materias.carrera, usuarios.nombre, usuarios.apellido, usuarios.dni, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id) where materias.id = $id;");

            $data = mysqli_fetch_assoc($info);

            return $data;
        }
        #endregion

    }
    #endregion

?>