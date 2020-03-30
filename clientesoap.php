<?php 

class ClienteSoap {
	// parametros SOAP
	public $wsdl;
	public $endpoint;
	// instancia SoapClient
	public $soapClient;

	public function __construct(){
		$this->wsdl = "http://test.analitica.com.co/AZDigital_Pruebas/WebServices/ServiciosAZDigital.wsdl";
		$this->endpoint = "http://test.analitica.com.co/AZDigital_Pruebas/WebServices/SOAP/index.php";
	 	$this->soapClient = new SoapClient($this->wsdl, array('trace' => 1));
	 	$this->soapClient->__setLocation($this->endpoint);
	}
   
    public function consumirSoap() {
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
			$rtaBuscarArchivo = $this->soapClient->BuscarArchivo($params);
		} catch(Exception $e){
			print 'Exception ' . $e->getMessage();
		}
    }

    public function obtenerInsertQuery(){
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
		//$dataSOAP = new DOMDocument();

		/*
		$mensajeSOAP = html_entity_decode($soapClient->__getLastResponse());
		$mensajeSOAP = $soapClient->__getLastResponse();
		str_replace('<?xml version="1.0" encoding="utf-8"?>', '<?xml version="1.0" encoding="utf-8"?><?xml-stylesheet href="BuscarArchivo.xsl" type="text/xsl"?>', $mensajeSOAP);
		echo "mensajeSOAP " . $mensajeSOAP;
		*/

		//$dataSOAP->loadXML($this->soapClient->__getLastResponse());
		//$dataSOAP->save("BuscarArchivo.xml");

		// cargar archivo soap transformado
		$nuevoXML = new DOMDocument();
		//$nuevoXML->load("BuscarArchivo.xml");
		$nuevoXML->loadXML($this->soapClient->__getLastResponse());
		$nuevoXML->save("BuscarArchivo.xml");
		// transformar respuesta soap
		$strSOAP = $procesaSOAP->transformToXML($nuevoXML);
		//echo "strSOAP " . $strSOAP;

		// cargar respuesta soap transformada y guardar en Ordenado.xml
		$strSOAP = str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="utf-8"?>', $strSOAP);

		$soapTransformado = new DOMDocument();
		$soapTransformado->loadXML($strSOAP);
		$soapTransformado->save("Ordenado.xml");

		// cargar Ordenado.xml
		$dataInsert = new DOMDocument();
		//$dataInsert->load("Ordenado.xml");
		$dataInsert->loadXML($soapTransformado->saveXML());
		//$dataInsert->save("Inserts.xml");

		// crear inserts para aplicar en la bd
		$strsql = $procesadoInsert->transformToXML($dataInsert);

		/*
		echo "-------------\n";
		echo $strsql;
		echo "-------------\n";
		*/
		
		/* 
		$archivoinserts = new DOMDocument();
		$strsql = str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="utf-8"?>', $strsql); 
		$archivoinserts->loadXML($strsql);
		$archivoinserts->save("inserts.xml");
		*/

		$strsql = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $strsql);

    	return $strsql;
    }

    public function getLastResponse() {
    	return $soapClient->__getLastResponse();
    }
}

?>