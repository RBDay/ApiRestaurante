<?php 

require_once('ApiTools.php');

/**
 * Clase que llama a la DB
 * @see Como no tengo una configuración a la que acogerme esta con la basica del XAMPP
 */
class DataBaseToolsApi
{
	
	private $_connection;
	private static $_instance; //The single instance
	private $_host = "localhost";
	private $_username = "root";
	private $_password = "";
	private $_database = "platostest";

	/**
	* Constructor
	*/
	function __construct() {
		$this->_connection = new mysqli($this->_host, $this->_username, 
			$this->_password, $this->_database);
	
		// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
			ApiTools::errorMsg("Internal connection error. Try latter or call to support");
		}
	}
	/**
	* Consigue la conexión de la bd y la retorna
	*/
	public function getConnection() {
		return $this->_connection;
	}

	/**
	* Ejecuta la query y devuelve el resultado del select
	*/
	public function doSelect($selectQuery) {
		try{
			$result = mysqli_query($this->_connection,$selectQuery);
			//comprobamos que no hayan errores
			if(mysqli_error ($this->_connection)){
				ApiTools::errorMsg("Internal select error. Try latter or call to support");
			}
			//devolvemos las lineas de la busqueda
			$result =$result->fetch_all();
			return $result;
		}catch(Exception $e){
			ApiTools::errorMsg("Wrong search: ".$e->getMessage());
		}
	}

	/**
	* Ejecuta la query y devuelve true si se ha realizado
	*/
	public function doUpdate($updateQuery) {
		// TODO: añadir todas las querys en un TRANSACTION para que pueda hacer un rollback si algo sale mal. Debería ser una functión propia de esta clase que reciba un array de querys devuelva el TRANSACTION.
		try{
			mysqli_query($this->_connection,$updateQuery);
			//comprobamos qe no hayan habido errores
			if(mysqli_error($this->_connection)){
				ApiTools::errorMsg("Internal insert error. Try latter or call to support");
			}else{
				return true;
			}
		}catch(Exception $e){
			ApiTools::errorMsg("Wrong insert: ".$e->getMessage());
		}
	}

	/**
	* Ejecuta la query y devuelve true si se ha realizado
	*/
	public function doDelete($deleteQuery) {
		// TODO: añadir todas las querys en un TRANSACTION para que pueda hacer un rollback si algo sale mal. Debería ser una functión propia de esta clase que reciba un array de querys devuelva el TRANSACTION.
		try{
			mysqli_query($this->_connection,$deleteQuery);
			//comprobamos qe no hayan habido errores
			if(mysqli_error($this->_connection)){
				ApiTools::errorMsg("Internal insert error. Try latter or call to support");
			}else{
				return true;
			}
		}catch(Exception $e){
			ApiTools::errorMsg("Wrong insert: ".$e->getMessage());
		}
	}

	/**
	* Ejecuta la query y devuelve el id del valor insertado
	*/
	public function doInsert($insertQuery) {
		// TODO: añadir todas las querys en un TRANSACTION para que pueda hacer un rollback si algo sale mal. Debería ser una functión propia de esta clase que reciba un array de querys devuelva el TRANSACTION.
		try{
			//ejecutamos la query
			mysqli_query($this->_connection,$insertQuery);
			//comprobamos qe no hayan habido errores
			if(mysqli_error($this->_connection)){
				ApiTools::errorMsg("Internal insert error. Try latter or call to support");
			}
			//retornamos el ultimo id insertado
			$lastIdInserted = mysqli_insert_id($this->_connection);
			return $lastIdInserted;
		}catch(Exception $e){
			ApiTools::errorMsg("Wrong insert: ".$e->getMessage());
		}
	}
}

?>