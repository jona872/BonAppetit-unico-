<?php
/**
 * Description of EmpleadosValueObject
 *
 */
class EmpleadosValueObject {
    
   private $dni, $nombre, $apellido, $id, $tipo_empleado_id;
   
   public function getDni() {
       return $this->dni;
   }

   public function setDni($dni) {
       $this->dni = $dni;
   }

   public function getNombre() {
       return $this->nombre;
   }

   public function setNombre($nombre) {
       $this->nombre = $nombre;
   }

   public function getApellido() {
       return $this->apellido;
   }

   public function setApellido($apellido) {
       $this->apellido = $apellido;
   }

   public function getId() {
       return $this->id;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function getTipo_empleado_id() {
       return $this->tipo_empleado_id;
   }

   public function setTipo_empleado_id($tipo_empleado_id) {
       $this->tipo_empleado_id = $tipo_empleado_id;
   }


 }
?>