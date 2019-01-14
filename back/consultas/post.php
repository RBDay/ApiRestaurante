<?php 
//include de las tres classes (platos, alergenos e ingredientes)
require_once('../classes/Alergenos.php');
require_once('../classes/Ingredientes.php');
require_once('../classes/Platos.php');
require_once('../classes/tools/ApiTools.php');
//leer las variables del get
if(!isset($_GET["field"])){
	ApiTools::errorMsg("The field 'field' is necessary");
}
if(!isset($_GET["action"])){
	ApiTools::errorMsg("The field 'action' is necessary");
}
//id ya no es necesario en todos los casos --> si no existe en el get lo pasamos a null
if(isset($_GET["id"])){
	$id = $_GET["id"];
}else{
	//al pasarle null a id lo interpreta el constructor de las clases como que no debe sobreescribirl el id interno de la clase
	$id = null;
}
$action = $_GET["action"];
$field = $_GET["field"];
//switch para definir a que clase debo atacar
$objToPost = null;
switch ($field) {
	case 'platos':
		$objToPost = new Platos($id);
		break;
	case 'alergenos':
		$objToPost = new Alergenos($id);
		break;
	case 'ingredientes':
		$objToPost = new Ingredientes($id);
		break;
	default:
		ApiTools::errorMsg("Field not valid");
		break;
}
//comprobar que la acción existe 
	//--> así me ahorro tener que entrar en el switch si no existe
	//--> También me previene de que por ejemplo pueda llamar a una action que no este contemplada en la case
if(!method_exists ($objToPost,$action)){
	//si la acción no es posible le avisamos via un error
	ApiTools::errorMsg("The action that you call doesn't exists");
}
//switch para definir que acción debo realizar
//recoger los datos pertinentes para cada acción en su case
switch ($action) {
	//-- platos ------------------------------
	case 'changeIngredientesPlato':
		if(!isset($_POST["ingredientes"])){ ApiTools::errorMsg("The data 'ingredientes' it's obligatory"); }
		if(gettype($_POST["ingredientes"]) !== "array"){ ApiTools::errorMsg("The data 'ingredientes' must be an array"); }
		$id_result_insert = $objToPost->changeIngredientesPlato($_POST["ingredientes"]);
		ApiTools::okInstID($id_result_insert);
		break;
	//-- (comunes) ingredientes, alergenos, platos -------------------------
	case 'addNew':
		$name = $_POST["name"];
		if($field === "platos"){
			if(!isset($_POST["descripcion"])){ ApiTools::errorMsg("The data 'descripcion' it's obligatory"); }
			if(!isset($_POST["ingredientes"])){ ApiTools::errorMsg("The data 'ingredientes' it's obligatory"); }
			if(gettype($_POST["ingredientes"]) !== "array"){ ApiTools::errorMsg("The data 'ingredientes' must be an array"); }
			$id_result_insert = $objToPost->addNew($name,$_POST["descripcion"],$_POST["ingredientes"]);
			ApiTools::okInstID($id_result_insert);
		}
		if($field === "ingredientes"){
			if(!isset($_POST["alergenos"])){ ApiTools::errorMsg("The data 'alergenos' it's obligatory"); }
			if(gettype($_POST["alergenos"]) !== "array"){ ApiTools::errorMsg("The data 'alergenos' must be an array"); }
			$id_result_insert = $objToPost->addNew($name,$_POST["alergenos"]);
			ApiTools::okInstID($id_result_insert);
		}
		$id_result_insert = $objToPost->addNew($name);
		ApiTools::okInstID($id_result_insert);
		break;
	default:
		ApiTools::errorMsg("The action that you call doesn't exists");
		break;
}
?>