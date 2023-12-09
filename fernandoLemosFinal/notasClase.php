<?php
    require_once "carrerasClase.php";

    #region clase Notas
    class Notas{

        #region atributos
        private $usuario;
        private $carrera;
        private $nota = "null";
        private $parcial1;
        private $parcial2;
        private $final;
        #endregion

        #region constructor
        public function __construct($usu,$car){
            $this->usuario = $usu;
            $this->carrera = $car;
        }
        #endregion

        #region setNotas
        public function setNotas($p1,$p2,$f){
            $this->parcial1 = $p1;
            $this->parcial2 = $p2;
            $this->final = $f;
        }
        #endregion

        #region crearNota
        public function asignarCarrera(){
            $con = condb();
            $text = "";
            $a = mysqli_fetch_assoc(mysqli_query($con,"select count(id) from materias where carrera = $this->carrera;"));
            $totalMaterias = $a['count(id)'];
            $contador = 0;
            $agregar = array();

            $materias = mysqli_query($con,"select id from materias where carrera = $this->carrera");

            while($cargar = mysqli_fetch_assoc($materias)){
                if($contador == $totalMaterias - 1){
                    $dato = "(" .$this->usuario ."," .$cargar['id'] ."," .$this->nota ."," .$this->nota ."," .$this->nota .")";
                    array_push($agregar,$dato);
                }else {
                    $dato = "(" .$this->usuario ."," .$cargar['id'] ."," .$this->nota ."," .$this->nota ."," .$this->nota ."),";
                    array_push($agregar,$dato);
                }
                $contador ++;
            }

            $valores = implode($agregar);

            mysqli_query($con,"insert into notas (idUsuario,idMateria,notaParcial1,notaParcial2,notaFinal) values $valores");

            (mysqli_affected_rows($con) >0) ? $text = "Carrera asignada correctamente" : $text = "No se pudo asignar la carrera correctamente";

            return $text;
        }
        #endregion

        #region listarNotas
        public static function listarNotas(){
            $con = condb();


            $data = mysqli_query($con,"select notas.idUsuario,notas.idMateria, usuarios.nombre, usuarios.apellido, materias.materia, carreras.nombreCarrera ,notas.notaParcial1,notas.notaParcial2,notas.notaFinal from (((usuarios inner join notas on usuarios.id = notas.idUsuario) inner join materias on notas.idMateria = materias.id) inner join carreras on carreras.id = materias.carrera );");

            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay asignaturas registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ 
                    $nombre = $info['nombre'] ." " .$info['apellido'];?>
                    <tr>
                        <td><?php echo $nombre ?></td>
                        <td><?php echo $info['materia']; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td><?php echo $info['notaParcial1']?></td>
                        <td><?php echo $info['notaParcial2']?></td>
                        <td><?php echo $info['notaFinal']?></td>
                        <td>
                            <p class="acciones">
                                <a class="eliminar" href="vista.php?pan=1 & acc=11 & idU=<?php echo $info['idUsuario']; ?> & alumno=<?php echo $nombre ?> & carrera=<?php echo $info['nombreCarrera']; ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

    #region listarNotasAlumno
        public static function listarNotasAlumno($id){
            $con = condb();


            $data = mysqli_query($con,"select notas.idMateria,notas.notaParcial1,notas.notaParcial2,notas.notaFinal, materias.materia,materias.profesor,materias.carrera,usuarios.nombre,usuarios.apellido, carreras.nombreCarrera from (((notas inner join materias on notas.idMateria = materias.id) inner join usuarios on usuarios.id = materias.profesor) inner join carreras on carreras.id = materias.carrera) where notas.idUsuario = $id;");

            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay asignaturas registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ 
                    $nombre = $info['nombre'] ." " .$info['apellido'];?>
                    <tr>
                        <td><?php echo $nombre ?></td>
                        <td><?php echo $info['materia']; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td><?php echo $info['notaParcial1']?></td>
                        <td><?php echo $info['notaParcial2']?></td>
                        <td><?php echo $info['notaFinal']?></td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region eliminarNotas
        public function eliminarNotas(){
            $con = condb();
            $text = "";

            mysqli_query($con,"delete from notas where idUsuario = $this->usuario");

            (mysqli_affected_rows($con) >0) ? $text = "Asignatura eliminada correctamente." : $text = "No se pudo eliminar la asignatura correctamente.";

            return $text;
        }
        #endregion

        #region listarNotasEditables
        public static function listarNotasEditables($id){
            $con = condb();

            $data = mysqli_query($con,"select notas.idUsuario,notas.idMateria, usuarios.nombre, usuarios.apellido, materias.materia, carreras.nombreCarrera ,notas.notaParcial1,notas.notaParcial2,notas.notaFinal from (((usuarios inner join notas on usuarios.id = notas.idUsuario) inner join materias on notas.idMateria = materias.id) inner join carreras on carreras.id = materias.carrera) where materias.profesor = $id;");

            

            if(mysqli_affected_rows($con) == 0){
                echo "<tr><td><b class='bold red'>No hay carreras registradas en el sistema</b></tr></td>";
            }else{
                while ($info = mysqli_fetch_assoc($data)){ 
                    $nombre = $info['nombre'] ." " .$info['apellido']?>
                    <tr>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $info['nombreCarrera']; ?></td>
                        <td><?php echo $info['materia']; ?></td>
                        <td><?php echo $info['notaParcial1']; ?></td>
                        <td><?php echo $info['notaParcial2']; ?></td>
                        <td><?php echo $info['notaFinal']; ?></td>
                        <td>
                            <p class="acciones">
                                <a class="modificar" href="vista.php?pan=1 & acc=12 & alumno=<?php echo $info['idUsuario']; ?> & idmateria=<?php echo $info['idMateria']; ?> & nombre=<?php echo $nombre; ?> & materia=<?php echo $info['materia'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php   }
            }
        }
        #endregion

        #region modificarNotas
        public function modificarNotas(){
            $con = condb();
            $text = "";

            mysqli_query($con,"update notas set notaParcial1 = $this->parcial1, notaParcial2 = $this->parcial2 , notaFinal = $this->final where idUsuario = $this->usuario and idMateria = $this->carrera;");

            (mysqli_affected_rows($con) >0) ? $text = "Nota/s modificadas correctamente" : $text = "No se pudo modificar las notas correctamente";

            return $text;
        }
        #endregion

    }
    #endregion

?>