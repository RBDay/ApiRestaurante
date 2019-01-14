<?php 

/**
 * 
 */
class ApiTools //extends Tools (si existiera)
{
	
	static function errorMsg($msg){
		echo json_encode(["OK"=>false,"Error"=>$msg]);
		die();
	}

	static function okMsg($valueReturn){
		echo json_encode(["OK"=>true,"Value"=>$valueReturn]);
		die();
	}

	static function okInstID($id){
		echo json_encode(["OK"=>true,"ID"=>$id]);
		die();
	}

	static function checkIDList($ingredientes){
		if(count($ingredientes) === 0 || gettype($ingredientes) !== "array"){
			ApiTools::errorMsg("The id list must be an array not empty.");
		}
		foreach ($ingredientes as $idNow) {
			if(!ctype_digit($idNow)){
				ApiTools::errorMsg("The id '".$idNow."' isn't correct");
			}
		}
	}

}

?>