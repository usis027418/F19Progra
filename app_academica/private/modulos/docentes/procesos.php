<?php

include('../../Config/config.php');
$docentes= new docentes($conexion);

$proceso='';

if(isset($_GET['proceso']) && strlen($_GET['proceso'])>0){
    $proceso=$_GET['proceso'];
}

$docentes->$proceso($_GET['docente']);
print_r(json_encode($docentes->respuesta));

class docentes{
    private $datos=array(),$bd;
    public $respuesta=['msg'=>'correcto'];

    public function __construct($bd){
        $this->bd=$bd;
    }

    public function recibirDatos($docentes){
        $this->datos=json_decode($docentes, true);
        $this->validar_datos();
    }

    private function validar_datos(){
        if(empty($this->datos['codigo'])){
            $this->respuesta['msg']='Por Favor Ingrese el codigo del Docente';
        
        }
        if(empty($this->datos['nombre'])){
            $this->respuesta['msg']='Por Favor Ingrese el nombre del Docente';

        }
        if(empty($this->datos['direccion'])){
            $this->respuesta['msg']='Por Favor Ingrese la direccion del Docente';

        }
        $this->almacenar_docente();
    }

    private function almacenar_docente(){
        if($this->respuesta['msg']==='correcto'){
            if($this->datos['accion']==="nuevo"){
                $this->bd->consultas('
                INSERT INTO docentes (codigo,nombre,direccion,dui,telefono) VALUES(
                    "'. $this->datos['codigo'] .'",
                    "'. $this->datos['nombre'] .'",
                    "'. $this->datos['direccion'] .'",
                    "'. $this->datos['dui'] .'",
                    "'. $this->datos['telefono'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE docentes SET 
                codigo= "'. $this->datos['codigo'].'",
                nombre= "'. $this->datos['nombre'].'",
                direccion= "'. $this->datos['direccion'].'",
                dui= "'. $this->datos['dui'].'",
                telefono= "'.$this->datos['telefono'].'"
                WHERE id_docente="'. $this->datos['id_docente'].'"
                ');
                $this->respuesta['msg']='Registro Actualizado con Exito';
            }
        }
    }

    public function buscarDocente($valor=''){
        $this->bd->consultas('
        SELECT docentes.id_docente, docentes.codigo, docentes.nombre, docentes.direccion,docentes.dui, docentes.telefono
        FROM docentes
        WHERE docentes.codigo LIKE "%'.$valor.'%" OR docentes.nombre LIKE "%'.$valor.'%" OR docentes.dui LIKE "%'.$valor.'%"
        ');
        return $this->respuesta=$this->bd->obtener_datos();
    }

    public function eliminarDocente($id_docente=''){
        $this->bd->consultas('
        DELETE docentes
        FROM docentes
        WHERE docentes.id_docente="'.$id_docente.'"
        ');
        $this->respuesta['msg']="Registro Eliminado con Exito";
    }
}

?>