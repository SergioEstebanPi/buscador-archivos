<?php
	include('db.php');
	include('clientesoap.php');
	
	$accion = $_POST['submit'];
	if(isset($accion)){
		switch ($accion) {
			case 'buscarArchivos':
				//echo "buscarArchivos " . $accion;
				$clientesoap = new ClienteSoap();
				$clientesoap->consumirSoap();
				//echo "insertar " . $clientesoap->obtenerInsertQuery();
				$strsql = $clientesoap->obtenerInsertQuery();
				echo $strsql;
				$result0 = $db->multi_query($strsql) or die('Error querying database.');
				echo $result0;
				echo '<script type="text/javascript">alert("Registros descargados con éxito");</script>';
				break;
			case 'reporteArchivos':
				//echo "reporteArchivos " . $accion;
				$strsql = "
					SELECT ar.id, 
						ar.codigo, 
						ar.nombre, 
						ti.nombre extension
					FROM archivos ar
					LEFT JOIN tipos ti
					ON ar.id_tipo = ti.id
					;
				";
				// resultado de la consulta
				$result2 = mysqli_query($db, $strsql) or die('Error querying database.');;
				$row2 = mysqli_fetch_array($result2);

				/*
				while ($row2 = mysqli_fetch_array($result2)) {
				 	echo $row2['id'] . ' ' . $row2['codigo'] . $row2['nombre'] . $row2['extension'] . '<br />';
				}
				*/

				$dom = new DOMDocument('1.0', 'utf-8');
				$root = $dom->createElement('archivos');
				while ($row2 = mysqli_fetch_array($result2)) {
					$archivo = $dom->createElement('archivo');
					$id = $dom->createElement('id', $row2['id']);
					$codigo = $dom->createElement('codigo', $row2['codigo']); 
					$nombre = $dom->createElement('nombre', $row2['nombre']); 
					$extension = $dom->createElement('extension', $row2['extension']); 

					$archivo->appendChild($id);
					$archivo->appendChild($codigo);
					$archivo->appendChild($nombre);
					$archivo->appendChild($extension);
					$root->appendChild($archivo);

				 	//echo $row2['id'] . ' ' . $row2['codigo'] . $row2['nombre'] . $row2['extension'] . '<br />';
				}
				$dom->appendChild($root);
				//echo "salida" . html_entity_decode($dom->save("reportearchivos.xml"));

				//$datosreporte = $dom->saveXML();

				$plantillaReporteA = new DOMDocument();
				$plantillaReporteA->load("ReporteArchivos.xsl");

				$procesaReporteA = new XSLTProcessor();
				$procesaReporteA->importStylesheet($plantillaReporteA);
				$reporteGen = $procesaReporteA->transformToXML($dom);

				echo $reporteGen;
				// cierre de la conexion
				mysqli_close($db);
				break;
			case 'reporteResumen':
				//echo "reporteResumen " . $accion;
				$strsql = "SELECT * FROM tipos";
				break;
			default:
				//echo "opción incorrecta";
				alert('debe elegir una opción válida');
				break;
		}
	}
?>