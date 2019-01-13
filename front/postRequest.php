<?php 
//las variables "invisibles" (Post)
$post = [
    'name' => 'Alergeno especial de la api',
    //'descripcion' => 'Esto es una descripción interesante sobre el plato que sin duda ha sido insertado por la api.',
    //'ingredientes'   => [1,7,9] // 'alergenos' => [2,5]//
];
//las variables que se pasan por url (Get)
$action = "addNew";
$field = "alergenos";//"alergenos";//"platos"; //"ingredientes"
$id = null;//3; //null;
//generamos la llamada y recogemos el resultado
if($id === null){
	$ch = curl_init('http://localhost/testPlatos/back/consultas/post.php?action='.$action.'&field='.$field);
}else{
	$ch = curl_init('http://localhost/testPlatos/back/consultas/post.php?action='.$action.'&field='.$field."&id=".$id);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

$response = curl_exec($ch);

curl_close($ch);
//imprimimos el resultado para ver que ha salido
echo $response;

?>