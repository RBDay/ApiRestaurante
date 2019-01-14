<?php 

require_once('tools/DataBase.php');

/**
 * 
 */
class Alergenos
{
	
	/**
	* ID del alergeno insertado.
	*/
	private $idAlergeno;

	private $db;
	private $dbClass;

	/**
	* Se almacena el id si no fuera null.
	* @see Como no he tenido mucho tiempo el $id carece de comprobación pero
	* en un ejemplo mejor acudiríamos a una function estatica para comprobarlo. 
	* (Posiblemente alojada en la clase Tools o similar.)
	*/
	function __construct($id = null)
	{
		//aqui se sobreescribe el id si fuera necesario
		if($id !== null){
			$this->idAlergeno = $id;
		}
		//declaro la db
		$this->dbClass = new DataBaseToolsApi();
		$this->db = $this->dbClass->getConnection();
	}
	/**
	* Inserta un alergeno en base al nombre proporcionado
	* 
	* @return int ID del alergeno
	*/
	function addNew($nombreAlergeno){
		//le escapo el nombre
		$nombre = mysqli_real_escape_string($this->db,$nombreAlergeno);
		//comprobamos que no exista
		if($this->dbClass->checkValueNoExist($nombre,"Nombre_alergeno","alergenos")){
			ApiTools::errorMsg("This name (".$nombre.") already exists");
		}
		//le hago el insert
		$query = "INSERT INTO alergenos (Nombre_alergeno)
		VALUES ('".$nombre."');";
		//devolvemos su id para que lo puedan leer desde el json.
		return $this->dbClass->doInsert($query);

	}

	/**
	* Me devuelve el nombre del alergeno en función del id de
	* la clase.
	* 
	* @return String Nomvre del alergeno.
	*/
	function getNameAlergeno(){
		$query = "SELECT alergenos.Nombre_alergeno FROM `alergenos` 
		WHERE alergenos.ID_alergeno = ".$this->idAlergeno;
		//ejecutamos llamando al metodo doSelect del $this->db
		$result = $this->dbClass->doSelect($query);
		// leemos el resultado de doSelect y lo devolvemos
		return $result[0][0];
	}
}

?>