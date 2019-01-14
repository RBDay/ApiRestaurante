<?php 

require_once('tools/DataBase.php');

/**
 * 
 */
class Ingredientes
{
	/**
	* ID del ingrediente insertado.
	*/
	private $idIngrediente;

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
			$this->idIngrediente = $id;
		}
		//declaro la db
		$this->dbClass = new DataBaseToolsApi();
		$this->db = $this->dbClass->getConnection();
	}

	/**
	* Inserta un ingrediente en base al nombre proporcionado
	* y un array de alergenos con los que le vamos a relacionar.
	* 
	* @return int ID del ingrediente
	*/
	function addNew($nombreIngrediente,$alergenos){
		//le escapo el nombre
		$nombre = mysqli_real_escape_string($this->db,$nombreIngrediente);
		//comprobamos que el nombre no exista
		if($this->dbClass->checkValueNoExist($nombre,"Nombre_ingrediente","ingredientes")){
			ApiTools::errorMsg("This name (".$nombre.") already exists");
		}
		//comprobamos los id's a insertar
		ApiTools::checkIDList($alergenos);
		//le hago el insert
		$query = "INSERT INTO ingredientes (Nombre_ingrediente)
		VALUES ('".$nombre."');";
		$this->idIngrediente = $this->dbClass->doInsert($query);
		//una vez recogido su id se realiza un insert en la tabla ingredientesalergenos con los id's
		//del array $alergenos y el id recien insertado en la tabla ingredientes
		$query = "INSERT INTO ingredientesalergenos (ID_ingrediente, ID_alergeno) VALUES ";
		foreach ($alergenos as $idNow) {
			if(ctype_digit($idNow)){
				$query .= "(".$this->idIngrediente.",".$idNow."),";
			}else{
				ApiTools::errorMsg("The id '".$idNow."' isn't correct");
			}
		}
		$query = rtrim($query,",").";";
		$this->dbClass->doInsert($query);
		//retornamos el id del nuevo plato
		return $this->idIngrediente;
	}

	/**
	* Devuelve los alergenos de un ingrediente en función del id
	* de la clase.
	*/
	function getAlergenos(){
		$query = "SELECT alergenos.ID_alergeno,alergenos.Nombre_alergeno FROM `ingredientes`
		RIGHT JOIN ingredientesalergenos ON ingredientes.ID_ingrediente = ingredientesalergenos.ID_ingrediente
		RIGHT JOIN alergenos ON ingredientesalergenos.ID_alergeno = alergenos.ID_alergeno
		WHERE ingredientes.ID_ingrediente = ".$this->idIngrediente;
		//ejecutamos llamando al metodo doSelect del $this->db
		$result = $this->dbClass->doSelect($query);
		// leemos el resultado de doSelect y lo devolvemos
		return $result;
	}
}

?>