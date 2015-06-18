<?php
/**
 * Clase que se encarga de seleccionar la base de datos y ejecutar las consultas y devolver resultados
 * @version    1.0
 * @since      File available since Release 1.0
*/

include_once ('Conexion.php');

class ConsultaBD   // se declara una clase para poder ejecutar las consultas, esta clase llama a la clase conexion
{

    private $conexion;  // conexion a la base de datos
    private $bd; // base de datos
    private $consulta;  // consulta en la base de datos

    // seteo de la base de datos
    private function setBaseDatos($baseDatos){
        $this->bd=$baseDatos;
    }

    // selecciona la base de datos
    public function Conectar($base='bonappetit') {
        $this->setBaseDatos($base);
        $this->conexion= new Conexion();
        if (!mysql_select_db($this->bd,$this->conexion->getConexion()))
        {
            echo "<div class=error style='text-align: center'>Error seleccionando la base de datos</div>";
            exit();
        }
    }

    // metodo que ejecuta una consulta y la guarda en el atributo $consulta
    public function executeQuery($cons)  {        
        $this->consulta= mysql_query($cons,$this->conexion->getConexion());
        return $this->consulta;
    }

    // metodo que ejecuta una consulta y la guarda en el atributo $consulta y devuelve true o false
    public function executeQueryControl($cons)  {
        $this->consulta= mysql_query($cons,$this->conexion->getConexion());
        if ($this->consulta){ return true;}
        else { return false;}
    }

    // retorna la consulta en forma de result
    public function getResults()   {
        return $this->consulta;
    }
    
    // cierra la conexion
    public function Close() {
        $this->conexion->Close();
    }
    
    // libera la consulta
    public function Clean() {
        mysql_free_result($this->consulta);
    }
        
    // devuelve el nro de filas en el conjunto de resultados
    public function getNumRows() {
        return mysql_num_rows($this->getResults()) ;
    }

    // devuelve el valor de filas afectadas en un array
    public function getFetchArray() {
        return mysql_fetch_array($this->getResults()) ;
    }
    
    // devuelve la cantidad de registros encontrados
    public function getFetchRow() {
        return mysql_fetch_row($this->getResults()) ;
    }

    // devuelve los registros afectados en objetos
    public function getFetchObject() {        
        return mysql_fetch_object($this->getResults()) ;
    }
    
    // devuelve el ultimo id insertado
    public function ultimoId() {
        return mysql_insert_id();
    }

}
