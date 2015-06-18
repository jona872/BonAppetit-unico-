<?php
require_once '../Clases/ValueObject/EmpleadosValueObject.php';

/**
 * Description of MysqlEmpleadosActiveRecord
 *
 */
class MysqlEmpleadosActiveRecord {
 
    /**
    *
    * @param EmpleadosValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      if (is_numeric($oValueObject->getDni())){
            $sql = "SELECT * FROM empleados WHERE dni= " . $oValueObject->getDni() . ";";                
            $resultado = mysql_query($sql);
            if($resultado){
                if(mysql_num_rows($resultado)>0) {
                    $fila = mysql_fetch_object($resultado);
                    $oValueObject->setDni($fila->dni);
                    $oValueObject->setNombre($fila->nombre);
                    $oValueObject->setApellido($fila->apellido);
                    $oValueObject->setId($fila->id);
                    $oValueObject->setTipo_empleado_id($fila->tipo_empleado_id);                    
                    return $oValueObject;
                } else {
                    return false;
                }           
            } else {
                return false;
            }
        } else {
            $sql = "SELECT * FROM empleados WHERE CONCAT(nombre,' ',apellido) like '%" . $oValueObject->getDni() . "%' order by apellido, nombre;";                   
            $resultado = mysql_query($sql);
            if($resultado){
                $aEmpleado = array();
                while ($fila = mysql_fetch_object($resultado)) {
                    $oEmpleado = new EmpleadosValueObject();
                    $oEmpleado->setDni($fila->dni);
                    $oEmpleado->setNombre($fila->nombre);
                    $oEmpleado->setApellido($fila->apellido);
                    $oEmpleado->setId($fila->id);
                    $oEmpleado->setTipo_empleado_id($fila->tipo_empleado_id);         
                    $aEmpleado[] = $oEmpleado;
                    unset ($oEmpleado);
                }     return $aEmpleado;                       
            } else {
                return false;
            }
        }
    }
   

    /**
    * Busca todos lo datos de la tabla Agentes que se encuentra en la base de datos.
    * @param AgentesValueObject $oValueObject
    * @return boolean 
    */
   public function findAll($oValueObject) {
      $sql = "SELECT dni, CONCAT(apellido,', ',nombre) AS apellido from agentes WHERE  ";     
      if($oValueObject->getApellido())
          $sql.=" CONCAT(apellido,', ',nombre) like '%".$oValueObject->getApellido()."%' ";
      $resultado = mysql_query($sql);
      if($resultado){
         $oAgente = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oAgente = new AgentesValueObject();
            $oAgente->setDni($fila->dni);
            $oAgente->setApellido($fila->apellido);            
            $aAgente[] = $oAgente;
            unset ($oAgente);
         }
         return $aAgente;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param AgentesValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO agentes (dni, nombre, apellido, direccion, coddpto, codloc, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getDni() . ", ";
      $sql .= "'".$oValueObject->getNombre() . "', ";
      $sql .= "'".$oValueObject->getApellido() . "', ";
      $sql .= "'".$oValueObject->getDireccion() . "', ";
      $sql .= "10,10, ";
      $sql .= $oValueObject->getusuarioAlta().");";           
      if (mysql_query($sql)) {
           return true;
      } else { return false; }      
   }
   
   /**
    *
    * @param AgentesValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE agentes SET nombre= '" . $oValueObject->getNombre()."', ";
      $sql.= " apellido = '".$oValueObject->getApellido()."', direccion = '".$oValueObject->getDireccion();
      $sql.="' WHERE dni = ".$oValueObject->getDni().";";             
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>