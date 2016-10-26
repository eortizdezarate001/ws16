<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
    <head>
      <title>Questions</title>
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet"/>
      <style>
        body  {font-family: 'Roboto', sans-serif; font-weight: 400;}
        #header  {
          font-size: 300%; text-align: center; font-weight: 100;
          padding-top: 20px;
        }
        a:link, a:visited{color: #0772C6; text-decoration:none}
        table	{border-collapse: collapse; width: 100%; }
  	    th		{text-align: center;padding: 8px; border-bottom: 1px solid #ddd;}
  	    td 		{padding: 8px; text-align: center; border-bottom: 1px solid #ddd;}
        .q  {text-align: left;}
  	    tr:hover{background-color:#f5f5f5}
        #tr1:hover{background-color: #ffffff};
      </style>
    </head>
    <body>
      <h1 id='header'> Questions </h1>
      <table>
        <tr id='tr1'>
          <th>Question</th>
          <th>Difficulty</th>
          <th>Subject</th>
        </tr>
        <xsl:for-each select="assessmentItems/assessmentItem">
          <tr>
            <td class="q"><xsl:value-of select="itemBody/p"/></td>
            <td><xsl:value-of select="@complexity"/></td>
            <td><xsl:value-of select="@subject"/></td>
          </tr>
        </xsl:for-each>

      </table>
    </body>
  </html>
</xsl:template>
</xsl:stylesheet>
