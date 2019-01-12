<?php 
//include de las tres classes (platos, alergenos e ingredientes)
require_once('../classes/Alergenos.php');
require_once('../classes/Ingredientes.php');
require_once('../classes/Platos.php');
require_once('../classes/tools/ApiTools.php');
//leer y comprobar las variables del get (?action=getAlergenos&field=platos&id=2)
if(!isset($_GET["field"])){
	ApiTools::errorMsg("The field 'field' is necessary");
}
if(!isset($_GET["action"])){
	ApiTools::errorMsg("The field 'action' is necessary");
}
if(!isset($_GET["id"])){
	ApiTools::errorMsg("The field 'id' is necessary");
}
$action = $_GET["action"];
$field = $_GET["field"];
$id = $_GET["id"];
//switch para definir a que clase debo atacar
$objToGet = null;
switch ($field) {
	case 'platos':
		$objToGet = new Platos($id);
		break;
	case 'alergenos':
		$objToGet = new Alergenos($id);
		break;
	case 'ingredientes':
		$objToGet = new Ingredientes($id);
		break;
	
	default:
		ApiTools::errorMsg("Field not valid");
		break;
}
//chequeamos la acción es viable
if(method_exists ($objToGet,$action)){
	//si la acción es viable la ejecutamos
	$result = $objToGet->$action();
	ApiTools::okMsg($result);
}else{
	//si la acción no es posible le avisamos via un error
	ApiTools::errorMsg("The action that you call doesn't exists");
}
?>