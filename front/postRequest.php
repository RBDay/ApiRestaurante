<?php 
//las variables "invisibles" (Post)
$post = [
    'name' => 'Alergeno especial de la api',
    //'descripcion' => 'Esto es una descripción interesante sobre el plato que sin duda ha sido insertado por la api.',
    //'ingredientes'   => [7,8,13] // 'alergenos' => [2,5]//
];
//las variables que se pasan por url (Get)
$action = "addNew";
$field = "alergenos";//"platos"; //"ingredientes"
//generamos la llamada y recogemos el resultado
$ch = curl_init('http://localhost/testPlatos/back/consultas/post.php?action='.$action.'&field='.$field);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

$response = curl_exec($ch);

curl_close($ch);
//imprimimos el resultado para ver que ha salido
echo $response;

?>