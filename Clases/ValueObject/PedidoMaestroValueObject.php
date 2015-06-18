<?php
/**
 * Description of PedidoMaestroValueObject
 *
 */
class PedidoMaestroValueObject {
    
    private $id, $descripcion, $empleado_id, $cliente_id, $mesa_nro, $cantidad_de_comensales, $fecha_y_hora, $total, $finalizado, $empresa_id, $usuario_id, $ubicacion_id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getEmpleado_id() {
        return $this->empleado_id;
    }

    public function setEmpleado_id($empleado_id) {
        $this->empleado_id = $empleado_id;
    }

    public function getCliente_id() {
        return $this->cliente_id;
    }

    public function setCliente_id($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function getMesa_nro() {
        return $this->mesa_nro;
    }

    public function setMesa_nro($mesa_nro) {
        $this->mesa_nro = $mesa_nro;
    }

    public function getCantidad_de_comensales() {
        return $this->cantidad_de_comensales;
    }

    public function setCantidad_de_comensales($cantidad_de_comensales) {
        $this->cantidad_de_comensales = $cantidad_de_comensales;
    }

    public function getFecha_y_hora() {
        return $this->fecha_y_hora;
    }

    public function setFecha_y_hora($fecha_y_hora) {
        $this->fecha_y_hora = $fecha_y_hora;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function getFinalizado() {
        return $this->finalizado;
    }

    public function setFinalizado($finalizado) {
        $this->finalizado = $finalizado;
    }

    public function getEmpresa_id() {
        return $this->empresa_id;
    }

    public function setEmpresa_id($empresa_id) {
        $this->empresa_id = $empresa_id;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function getUbicacion_id() {
        return $this->ubicacion_id;
    }

    public function setUbicacion_id($ubicacion_id) {
        $this->ubicacion_id = $ubicacion_id;
    }

    function __construct($descripcion='', $empleado_id='', $cliente_id='', $mesa_nro='', $cantidad_de_comensales='', $fecha_y_hora='', $total='', $finalizado='', $empresa_id='', $usuario_id='', $ubicacion_id='') {     
        $this->descripcion = $descripcion;
        $this->empleado_id = $empleado_id;
        $this->cliente_id = $cliente_id;
        $this->mesa_nro = $mesa_nro;
        $this->cantidad_de_comensales = $cantidad_de_comensales;
        $this->fecha_y_hora = $fecha_y_hora;
        $this->total = $total;
        $this->finalizado = $finalizado;
        $this->empresa_id = $empresa_id;
        $this->usuario_id = $usuario_id;
        $this->ubicacion_id = $ubicacion_id;
    }

}

?>
