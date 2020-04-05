<?php

include('../../Config/config.php');
$materia= new materia($conexion);

$proceso='';

if(isset($_GET['proceso']) && strlen($_GET['proceso'])>0){
    $proceso=$_GET['proceso'];
}

$materia->$proceso($_GET['materia']);
print_r(json_encode($materia->respuesta));

class materia{
    private $datos=array(),$bd;
    public $respuesta=['msg'=>'correcto'];

    public function __construct($bd){
        $this->bd=$bd;
    }

    public function recibirDatos($materia){
        $this->datos=json_decode($materia, true);
        $this->validar_datos();
    }

    private function validar_datos(){
        if(empty($this->datos['codigo'])){
            $this->respuesta['msg']='Por Favor Ingrese el codigo de la materia';
        
        }
        if(empty($this->datos['nombre'])){
            $this->respuesta['msg']='Por Favor Ingrese el nombre de la materia';

        }
        if(empty($this->datos['carrera'])){
            $this->respuesta['msg']='Por Favor Ingrese la carrera a la que pertenece la materia';

        }
        $this->almacenar_materia();
    }

    private function almacenar_materia(){
        if($this->respuesta['msg']==='correcto'){
            if($this->datos['accion']==="nuevo"){
                $this->bd->consultas('
                INSERT INTO materias (codigo,nombre,carrera,ciclo) VALUES(
                    "'. $this->datos['codigo'] .'",
                    "'. $this->datos['nombre'] .'",
                    "'. $this->datos['carrera'] .'",
                    "'. $this->datos['ciclo'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE materias SET 
                codigo= "'. $this->datos['codigo'].'",
                nombre= "'. $this->datos['nombre'].'",
                carrera= "'. $this->datos['carrera'].'",
                ciclo= "'.$this->datos['ciclo'].'"
                WHERE idMateria="'. $this->datos['idMateria'].'"
                ');
                $this->respuesta['msg']='Registro Actualizado con Exito';
            }
        }
    }

    public function buscarMateria($valor=''){
        $this->bd->consultas('
        SELECT materias.idMateria, materias.codigo, materias.nombre, materias.carrera, materias.ciclo
        FROM materias
        WHERE materias.codigo LIKE "%'.$valor.'%" OR materias.nombre LIKE "%'.$valor.'%" OR materias.carrera LIKE "%'.$valor.'%"
        ');
        return $this->respuesta=$this->bd->obtener_datos();
    }

    public function eliminarMateria($idMateria=''){
        $this->bd->consultas('
        DELETE materias 
        FROM materias
        WHERE materias.idMateria="'.$idMateria.'"
        ');
        $this->respuesta['msg']="Registro Eliminado con Exito";
    }
}

?>