<?php

/**
 * Descripcion de Fecha
 */
class CFecha {
    private $fecha;
    private $_dia;
    private $_ndia;
    private $_mes;
    private $_anio;
    
    public function get_ndia() {
        return $this->_ndia;
    }

    public function set_ndia($_ndia) {
        $this->_ndia = $_ndia;
    }

        public function get_anio() {
        return $this->_anio;
    }

    public function set_anio($_anio) {
        $this->_anio = $_anio;
    }

    public function get_dia() {
        return $this->_dia;
    }

    public function set_dia($_dia) {
        $this->_dia = $_dia;
    }

    public function get_mes() {
        return $this->_mes;
    }

    public function set_mes($_mes) {
        $this->_mes = $_mes;
    }
    
    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    /**
     * Convierte una fecha del formato aaaa-mm-dd o aaaa/mm/dd
     * al formato dd/mm/aaaa
     * @param type $fechi
     * @return string
     */
    function convierto_normal()
    {
        if(preg_match('#/#', $this->fecha)){
            $miFecha = explode("/", $this->fecha);            
        } else {
            $miFecha = explode("-", $this->fecha);            
        }
        $this->fecha=$miFecha[2]."/".$miFecha[1]."/".$miFecha[0];
        //echo $this->fecha;
    }

    /**
     * Convierte una fecha que contiene guion o barra al contrario
     * @param type $fechi
     * @return string
     */
    function convierto_guionbarra()
    {
        if(preg_match('#/#', $this->fecha)){
            $miFecha = explode("/", $this->fecha);
            $this->fecha=$miFecha[0]."-".$miFecha[1]."-".$miFecha[2];
        } else {
            $miFecha = explode("-", $this->fecha);
            $this->fecha=$miFecha[0]."/".$miFecha[1]."/".$miFecha[2];
        }
    }

    /**
     * Devuelve el mes y el año.
     * @param type $fechi
     * @return string 
     */
    function convierto_mesAnio($fechi)
    {
        if(preg_match('#/#', $this->fecha)){
            $miFecha = explode("/", $this->fecha);
        } else {
            $miFecha = explode("-", $this->fecha);
        }
        $fecha=$miFecha[2]."/".$miFecha[1];
        return $fecha;
    }

    /**
     * Convierte fecha del formato dd-mm-aaaa o dd/mm/aaaa al formato
     * aaaa-mm-dd usado por mysql
     * @param type $fechi
     * @return string
     */
    function convierto_mysql()
    {
        if(preg_match('#/#', $this->fecha)){
            $miFecha = explode("/", $this->fecha);
        } else {
            $miFecha = explode("-", $this->fecha);
        }
        $this->fecha=$miFecha[2]."-".$miFecha[1]."-".$miFecha[0];
    }

    function diaMes()
    {
        $this->_dia = date(l);
        $this->_mes = date(n);
        switch($this->_mes)
        {
            case 1:
                $this->_mes='Enero';
                break;
            case 2:
                $this->_mes='Febrero';
                break;
            case 3:
                $this->_mes='Marzo';
                break;
            case 4:
                $this->_mes='Abril';
                break;
            case 5:
                $this->_mes='Mayo';
                break;
            case 6:
                $this->_mes='Junio';
                break;
            case 7:
                $this->_mes='Julio';
                break;
            case 8:
                $this->_mes='Agosto';
                break;
            case 9:
                $this->_mes='Septiembre';
                break;
            case 10:
                $this->_mes='Octubre';
                break;
            case 11:
                $this->_mes='Noviembre';
                break;
            case 12:
                $this->_mes='Diciembre';
                break;
        }
        switch($this->_dia)
        {
            case 'Monday':
                $this->_dia='Lunes';
                break;
            case 'Tuesday':
                $this->_dia='Martes';
                break;
            case 'Wednesday':
                $this->_dia='Miercoles';
                break;
            case 'Thursday':
                $this->_dia='Jueves';
                break;
            case 'Friday':
                $this->_dia='Viernes';
                break;
            case 'Saturday':
                $this->_dia='Sabado';
                break;
            case 'Sunday':
                $this->_dia='Domingo';
                break;
        }
        $this->_anio = date(Y);
        $this->_ndia = date(j);

    }
    
    
    /** suma o resta ndias a una fecha */
    public function suma()   {        
        $this->convierto_normal();
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$this->fecha))            
                list($dia,$mes,$año)=explode("/", $this->fecha);

        if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$this->fecha))            
                list($dia,$mes,$año)=explode("-", $this->fecha);
        
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $this->_ndia * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
        $this->fecha = $nuevafecha;
        $this->convierto_mysql();
        return ($this->fecha);             
    }
    
}
?>