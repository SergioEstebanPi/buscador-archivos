<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:soap-enc="http://schemas.xmlsoap.org/soap/encoding/"
    xmlns:az="http://www.analitica.com.co/AZDigital/xsds/">
<xsl:output method="xml" indent="yes" />

<xsl:template match="az:RtaBuscarArchivo">
	<xsl:processing-instruction name="xml-stylesheet">
		<xsl:text>type="text/xsl" href="Ordenado.xsl"</xsl:text>
	</xsl:processing-instruction>
	<Ordenado>
		<Archivos>
			<xsl:for-each select="Archivo">
				<Archivo>
					<Id>
			    		<xsl:value-of select="@Id" />
			    	</Id>
			    	<Nombre>
			    		<xsl:value-of select="@Nombre" />
			    	</Nombre>
			    	<Extension>
				        <xsl:call-template name="get-extension">
				        	<xsl:with-param name="nombre" select="substring-after(@Nombre,'.')" />
				        </xsl:call-template>			    		
					</Extension>
				</Archivo>
			</xsl:for-each>
		</Archivos>
	</Ordenado>
</xsl:template>

<xsl:template name="get-extension">
	<xsl:choose>
		<xsl:when test="contains(@Nombre, '.')">
	        <xsl:call-template name="buscar-extension">
	        	<xsl:with-param name="nombre" select="substring-after(@Nombre,'.')" />
	        </xsl:call-template>
		</xsl:when>
		<xsl:otherwise>null</xsl:otherwise>
	</xsl:choose>
</xsl:template>


<xsl:template name="buscar-extension">
    <xsl:param name="nombre" />
    <xsl:choose>
	    <xsl:when test="contains($nombre, '.')">
	        <xsl:call-template name="buscar-extension">
	        	<xsl:with-param name="nombre" select="substring-after($nombre,'.')" />
	       	</xsl:call-template>
	    </xsl:when>
	    <xsl:otherwise><xsl:value-of select="$nombre" /></xsl:otherwise>
   	</xsl:choose>
</xsl:template>

</xsl:stylesheet>
