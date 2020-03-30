<?php

$profile = '<?xml version="1.0"?><Archivo Id="1185431" Nombre="1-0000000565~~°°à!##$$$%%%&amp;()=¨LÑ;¡[ón  vvvv xxxxxx.pdf"/> ';
$dom = new DOMDocument();


$profile = str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="utf-8"?>', $profile);


$dom->loadXML(mb_convert_encoding($profile, 'utf-8'));
//echo $dom->saveXML();
$dom->save("temp.xml");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Buscador archivos</title>
</head>
<body>
<div class="container" id="main-content">
	<h2>Buscador de archivos</h2>
	<p>Bienvenido</p>
	<form action="enrutador.php" method="post">
		<p>
			<button name='submit' value='buscarArchivos'>Buscar Archivos</button>
		</p>
		<p>
			<button name='submit' value='reporteArchivos'>Reporte Archivos</button>
		</p>
		<p>
			<button name='submit' value='reporteResumen'>Reporte Resumen</button>
		</p>
	</form>
</div>

</body>
</html>