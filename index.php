<?php 

	// parametros SOAP
	$wsdl = "http://test.analitica.com.co/AZDigital_Pruebas/WebServices/ServiciosAZDigital.wsdl";
	$endpoint = "http://test.analitica.com.co/AZDigital_Pruebas/WebServices/SOAP/index.php";
	// instancia SoapClient
	$soapClient = new SoapClient($wsdl, array('trace' => 1));
	$soapClient->__setLocation($endpoint);
	// parametros operacion BuscarArchivo
	$params = array(
	  "Condiciones" => array(
	  		"Condicion" => array(
		  		"Tipo" => "FechaInicial",
		  		"Expresion" => "2019-07-01 00:00:00"
			)
	  	)
	);
	// consumo del servicio SOAP
	try {
		//var_dump($soapClient->__getFunctions());
		//var_dump($soapClient->__getTypes());
		$rtaBuscarArchivo = $soapClient->BuscarArchivo($params);
		//echo "RESPONSE:\n" . htmlentities($soapClient->__getLastResponse()) . "\n";
	} catch(Exception $e){
		echo $e->getMessage();
	}
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
	<p>
		<?php
			echo "inicio";
			// cargar plantillas			
			$plantillaSOAP = new DOMDocument();
			$plantillaSOAP->load("BuscarArchivo.xsl");
			$plantillaTransformacion = new DOMDocument();
			$plantillaTransformacion->load("Ordenado.xsl");
			// cargar procesadores XSLT
			$procesaSOAP = new XSLTProcessor();
			$procesaSOAP->importStylesheet($plantillaSOAP);
			$procesadoInsert = new XSLTProcessor();
			$procesadoInsert->importStylesheet($plantillaTransformacion);

			// cargar respuesta soap
			$dataSOAP = new DOMDocument();

			$mensajeSOAP = html_entity_decode($soapClient->__getLastResponse());
			//$mensajeSOAP = $soapClient->__getLastResponse();
			str_replace('<?xml version="1.0" encoding="utf-8"?>', '<?xml version="1.0" encoding="utf-8"?><?xml-stylesheet href="BuscarArchivo.xsl" type="text/xsl"?>', $mensajeSOAP);
			echo "mensajeSOAP " . $mensajeSOAP;

			$dataSOAP->loadXML($soapClient->__getLastResponse());
			//$dataSOAP->save("BuscarArchivo.xml");

			// cargar archivo soap transformado
			$nuevoXML = new DOMDocument();
			//$nuevoXML->load("BuscarArchivo.xml");
			$nuevoXML->loadXML($dataSOAP->saveXML());
			// transformar respuesta soap
			$strSOAP = $procesaSOAP->transformToXML($nuevoXML);
			//echo "strSOAP " . $strSOAP;

			// cargar respuesta soap transformada y guardar en Ordenado.xml
			$soapTransformado = new DOMDocument();
			$soapTransformado->loadXML($strSOAP);
			//$soapTransformado->save("Ordenado.xml");

			// cargar Ordenado.xml
			$dataInsert = new DOMDocument();
			//$dataInsert->load("Ordenado.xml");
			$dataInsert->loadXML($soapTransformado->saveXML());

			// crear inserts para aplicar en la bd
			$strsql = $procesadoInsert->transformToXML($dataInsert);

			echo "------------------------------------------INSERTAR ---------------------------\n";
			echo $strsql;

			echo "fin";

			//var_dump($rtaBuscarArchivo);
			/*
			echo "<br/><br/><br/><br/>";
			$soap = simplexml_load_string($rtaBuscarArchivo);
			echo "++++++++++++++++++++++++soap+++++++++++++++++++";
			var_dump($soap);
			$response = $soap->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children();
			echo "++++++++++++++++++++++++response+++++++++++++++++++";
			var_dump($response);
			*/
			//$customerId = (string) $response->CreateRebillCustomerResult->RebillCustomerID;
			//echo $customerId;
		?>
	</p>
</div>

</body>
</html>