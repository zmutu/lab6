<?xml version='1.0' encoding='UTF-8'?>

<xsl:stylesheet xmlns:xsl='http://www.w3.org/1999/XSL/Transform' version='1.0'>

	<xsl:output method='html' indent='no'/>
	<xsl:template match='/'>
		<html>
			<head><style>th:{background-color:#55FF55;}</style></head>
			<body>
				<table bgcolor='#FFFFAA' border='1'>
					<tr bgcolor='#AAFFAA'><th scope='col'>Egilea</th><th scope='col'>Gaia</th><th scope='col'>Galdera</th><th scope='col'>Erantzun zuzena</th><th scope='col'>Erantzun okerrak</th></tr>
					<xsl:for-each select='//assessmentItem'>
						<tr>
							<td>
								<xsl:value-of select='@author'/>
							</td>
							<td>
								<xsl:value-of select='@subject'/>
							</td>
							<td>
								<xsl:value-of select='itemBody/p'/>
							</td>
							<td>
								<xsl:value-of select='./correctResponse/value'/>
							</td>
							<td>
								<xsl:for-each select='./incorrectResponses/value'>
									<xsl:value-of select='.'/><br/>
								</xsl:for-each>
							</td>
						</tr>
					</xsl:for-each>

				</table>
				
				<span onclick='window.history.back()' style='cursor:hand;cursor:pointer;background-color:#DDDFF;color:#0000DD'>nagusia</span>
				
			</body>
		</html>
	</xsl:template>

</xsl:stylesheet>