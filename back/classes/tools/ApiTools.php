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

}

?>