<xsl:stylesheet version="1.0"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 <xsl:output method="text" indent="yes"/>

<xsl:template match="/">
   <xsl:for-each select="Ordenado/Archivos/Archivo">
      <xsl:if test="Extension != '' and not(Extension=preceding-sibling::Archivo/Extension)">
         -- TIPOS
         insert into TIPOS (
            nombre
         ) values (
            "<xsl:value-of select="Extension"/>"
         );
      </xsl:if>
      -- ARCHIVOS
      insert into ARCHIVOS (
         codigo,
         nombre,
         id_tipo
      ) values (
         "<xsl:value-of select="Id" />",
         "<xsl:value-of select="Nombre" />",
         <xsl:choose>
            <xsl:when test="Extension != ''">
            (
               select id
               from TIPOS
               where nombre = "<xsl:value-of select="Extension"/>"
            )
            </xsl:when>
            <xsl:otherwise>null</xsl:otherwise>
         </xsl:choose>
      );
   </xsl:for-each>
</xsl:template>

</xsl:stylesheet>