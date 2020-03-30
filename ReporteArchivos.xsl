<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="yes" />

<xsl:template match="archivos">
	<html>
	<head>
		<title>Reporte de archivos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
	</head>
	<body>
	<div class="container">
		<div style="
		    text-align: center;
		    background-color: #b5c9ff;
		    color: darkgreen;
		    margin-top: 30px;
		    margin-bottom: 20px;
		    padding: 10px;
			">
			<h2>Reporte de archivos cargados</h2>
		</div>
		<div class="table-responsive">
			<table class="table table-hover" border="1" bgcolor="" style="font-size: small;">
				<thead style="text-align: center;">
					<tr>
						<th scope="col">ID</th>			
						<th scope="col">CÓDIGO</th>
						<th scope="col">EXTENSIÓN</th>			
						<th scope="col">NOMBRE</th>
					</tr>
				</thead>
				<tbody>
					<xsl:for-each select="archivo">
						<xsl:sort select="id" data-type="number" />
						<tr>
							<th scope="row">
					    		<xsl:value-of select="id" />
					    	</th>
					    	<td>
					    		<xsl:value-of select="codigo" />
					    	</td>
							<td>
					    		<xsl:value-of select="extension" />
					    	</td>
					    	<td>
					    		<xsl:value-of select="nombre" />
					    	</td>
						</tr>
					</xsl:for-each>
				</tbody>
			</table>
		</div>
	</div>

	</body>
	</html>

</xsl:template>

</xsl:stylesheet>
