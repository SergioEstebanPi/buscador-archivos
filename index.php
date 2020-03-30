<!DOCTYPE html>
<html>
<head>
	<title>Buscador archivos</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
</head>
<body>
<div class="container" id="main-content" >
	<div class="row" style="display: block; text-align: center">
		<div class="form-group" style="padding: 10px 0px">
			<h2>Buscador de archivos</h2>
			<img src="documents-1920461_960_720.png" width="15%" />
			<p>Para iniciar selecciona una de las opciones</p>
		</div>
		<form class="form-group" style="padding: 100px; padding-top: 0px" action="enrutador.php" method="post">
		<p>
			<button class="btn btn-primary btn-lg btn-block" name='submit' value='buscarArchivos'>Buscar Archivos</button>
		</p>
		<p>
			<button class="btn btn-success btn-lg btn-block" name='submit' value='reporteArchivos'>Reporte Archivos</button>
		</p>
		<p>
			<button class="btn btn-success btn-lg btn-block" name='submit' value='reporteResumen'>Reporte Resumen</button>
		</p>
		</form>
	</div>
</div>

</body>
</html>