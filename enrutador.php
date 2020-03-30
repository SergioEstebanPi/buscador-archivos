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
				$strsql = "
					truncate table tipos;
					truncate table archivos;
				";
				$strsql .= $clientesoap->obtenerInsertQuery();
				//echo $strsql;
				$result0 = $db->multi_query($strsql) or die('Error querying database.');
				echo $result0;
				if($result0){
					echo '<script type="text/javascript">
							alert("Registros descargados con éxito");
							window.location.href = "index.php";
						</script>';
				} else {
					echo '<script type="text/javascript">
							alert("No se obtuvieron registros para mostrar");
						</script>'; 
				}
				break;
				mysqli_close($db);
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
				$result1 = mysqli_query($db, $strsql) or die('Error querying database.');

				$dom = new DOMDocument('1.0', 'utf-8');
				$root = $dom->createElement('archivos');
				while ($row1 = mysqli_fetch_array($result1)) {
					$archivo = $dom->createElement('archivo');
					$id = $dom->createElement('id', $row1['id']);
					$codigo = $dom->createElement('codigo', $row1['codigo']); 
					$nombre = $dom->createElement('nombre', $row1['nombre']); 
					$extension = $dom->createElement('extension', $row1['extension']); 

					$archivo->appendChild($id);
					$archivo->appendChild($codigo);
					$archivo->appendChild($nombre);
					$archivo->appendChild($extension);
					$root->appendChild($archivo);

				 	//echo $row2['id'] . ' ' . $row2['codigo'] . $row2['nombre'] . $row2['extension'] . '<br />';
				}
				$dom->appendChild($root);

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
				$strsql = "
					SELECT nvl(ti.nombre, 'NO tiene') nombre,
				    	count(*) cantidad
				    from archivos ar
				    left join tipos ti
				    on ar.id_tipo = ti.id
				    group by ti.nombre
				    ;
				";
				// resultado de la consulta
				$result2 = mysqli_query($db, $strsql) or die('Error querying database.');

				$dom = new DOMDocument('1.0', 'utf-8');
				$root = $dom->createElement('resumenarchivos');
				while ($row2 = mysqli_fetch_array($result2)) {
					$tipo = $dom->createElement('tipo');
					$nombre = $dom->createElement('nombre', $row2['nombre']); 
					$cantidad = $dom->createElement('cantidad', $row2['cantidad']); 

					$tipo->appendChild($nombre);
					$tipo->appendChild($cantidad);
					$root->appendChild($tipo);

				 	//echo $row2['id'] . ' ' . $row2['codigo'] . $row2['nombre'] . $row2['extension'] . '<br />';
				}
				$dom->appendChild($root);
				//echo "salida" . html_entity_decode($dom->save("reportearchivos.xml"));

				//$datosreporte = $dom->saveXML();

				$plantillaReporteR = new DOMDocument();
				$plantillaReporteR->load("ReporteResumen.xsl");

				$procesaReporteR = new XSLTProcessor();
				$procesaReporteR->importStylesheet($plantillaReporteR);
				$reporteGen = $procesaReporteR->transformToXML($dom);

				echo $reporteGen;
				// cierre de la conexion
				mysqli_close($db);
				break;
			default:
				//echo "opción incorrecta";
				echo '<script type="text/javascript">alert("Debe elegir una opción válida")</script>';
				break;
		}
	}
?>