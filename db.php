<?php
	// conexion a la bd
	$db = mysqli_connect('localhost','root','','buscar-archivos')
	or die('Error connecting to MySQL server.');

	// consulta con inserciones
	//$query = "SELECT * FROM tipos";
	//mysqli_query($db, $query) or die('Error querying database.');

	// resultado de la consulta
	//$result = mysqli_query($db, $query);
	//$row = mysqli_fetch_array($result);

	//while ($row = mysqli_fetch_array($result)) {
	// 	echo $row['id'] . ' ' . $row['nombre'] .'<br />';
	//}
	// cierre de la conexion
	//mysqli_close($db);	
?>