<?php
// Se requiere de la clase ActiveRecordAbstractFactory
require_once 'ActiveRecordAbstractFactory.php';

/**
* Clase que nos permite conectar al motor MySQL y crear objetos
* de tipo Active Record para cada una de tablas del sistema.
*
* Clase que nos permite conectar al motor MySQL y crear objetos
* de tipo Active Record para cada una de tablas del sistema.
*
* @license    http://www.gnu.org/licenses/   GPL License
* @version    1.0
* @since      Class available since Release 1.0
*/
class MysqlActiveRecordAbstractFactory extends ActiveRecordAbstractFactory
{
    
    public static function getActiveRecordFactory($motor = self::MYSQL) {
        return parent::getActiveRecordFactory($motor);
    }

   const HOST = 'localhost';
   const USER = 'root';
   const PASS = '';
   const DB = 'bonappetit';

   /**
   * Nos permite conectar al motor MySQL con los datos de
   * conexi�n especificados como constantes. Luego se hace
   * la selecci�n de la base de datos.
   */
   public function conectar()
   {
      mysql_connect(self::HOST, self::USER, self::PASS);
      mysql_select_db(self::DB);
   }
     
      /**
   * Nos permite obtener un objeto de tipo
   * MysqlPedidoMaestroActiveRecord
   * 
   * @return MysqlPedidoMaestroActiveRecord
   */
   public function getPedidoMaestroActiveRecord() {              
      return new MysqlPedidoMaestroActiveRecord();
   }  
    
    /**
   * Nos permite obtener un objeto de tipo
   * MysqlEmpleadosActiveRecord
   * 
   * @return MysqlEmpleadosActiveRecord
   */
   public function getEmpleadosActiveRecord() {              
      return new MysqlEmpleadosActiveRecord();
   }  
}
?>