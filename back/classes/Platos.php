<?php

require_once('tools/DataBase.php');

/**
 * 
 */
class Platos
{
	
	/**
	* ID del plato.
	*/
	private $idPlato;
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
			$this->idPlato = $id;
		}
		//declaro la db
		$this->dbClass = new DataBaseToolsApi();
		$this->db = $this->dbClass->getConnection();
	}

	/**
	* Devuelve los alergenos de un plato en función del id
	* de la clase.
	*/
	public function getAlergenos(){
		$query = "SELECT alergenos.ID_alergeno,alergenos.Nombre_alergeno FROM `platos`
		RIGHT JOIN platosingredientes ON platos.ID_plato = platosingredientes.ID_plato
		RIGHT JOIN ingredientes ON platosingredientes.ID_ingrediente = ingredientes.ID_ingrediente
		RIGHT JOIN ingredientesalergenos ON ingredientes.ID_ingrediente = ingredientesalergenos.ID_ingrediente
		RIGHT JOIN alergenos ON ingredientesalergenos.ID_alergeno = alergenos.ID_alergeno
		WHERE platos.ID_plato = ".$this->idPlato;
		//ejecutamos llamando al metodo doSelect del $this->db
		$result = $this->dbClass->doSelect($query);
		// leemos el resultado de doSelect y lo devolvemos
		return $result;
	}
	/**
	* Inserta el plato en la BD con su nombre, descripción y un
	* listado de los id's de ingredientes.
	* @return int ID del plato
	*/
	public function addNew($nombre,$descripcion,$ingredientes){
		//preparamos los strings para evitar que rompan la query
		$nombre = mysqli_real_escape_string($this->db,$nombre);
		$descripcion = mysqli_real_escape_string($this->db,$descripcion);
		//comprobamos los id's a insertar
		ApiTools::checkIDList($ingredientes);
		//empezamos el transact
		$this->dbClass->doStartTransaction();
		//realizar un insert en la tabla plato con los datos $nombre y $descripcion
		$query = "INSERT INTO platos (Nombre_plato, Descripcion)
		VALUES ('".$nombre."', '".$descripcion."');";
		$this->idPlato = $this->dbClass->doInsert($query);
		//una vez recogido su id se realiza un insert en la tabla platosingredientes con los id's
		//del array $ingredientes y el id recien insertado en la tabla platos
		$query = "INSERT INTO platosingredientes (ID_plato, ID_ingrediente) VALUES ";
		foreach ($ingredientes as $idNow) {
			if(ctype_digit($idNow)){
				$query .= "(".$this->idPlato.",".$idNow."),";
			}
		}
		$query = rtrim($query,",").";";
		$this->dbClass->doInsert($query);
		//hacemos el CI en la DB
		$this->dbClass->doCommit();
		//retornamos el id del nuevo plato
		return $this->idPlato;
	}
	/**
	* Actualiza los ingredientes de un plato en función de su ID proporcionado.
	*/
	public function changeIngredientesPlato($ingredientes){
		//esta operación no se puede ejecutar sin un id existente
		if($this->idPlato === null){
			ApiTools::errorMsg("The field 'id' is necessary");
		}
		//comprobamos los id's a insertar
		ApiTools::checkIDList($ingredientes);
		//empezamos el transact
		$this->dbClass->doStartTransaction();
		//limpiar las referencias al $this->idPlato en la tabla platosingredientes
		$deleteQuery = "DELETE FROM platosingredientes WHERE ID_plato = ".$this->idPlato;
		//insertar las nuevas referencias
		$query = "INSERT INTO platosingredientes (ID_plato, ID_ingrediente) VALUES ";
		foreach ($ingredientes as $idNow) {
			if(ctype_digit($idNow)){
				$query .= "(".$this->idPlato.",".$idNow."),";
			}
		}
		$query = rtrim($query,",").";";
		$this->dbClass->doDelete($deleteQuery);
		$this->dbClass->doInsert($query);
		//hacemos el CI en la DB
		$this->dbClass->doCommit();
		//retornar el id del plato
		return $this->idPlato;
	}
}

?>