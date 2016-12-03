<?php
  echo "<p align='right'><a href='layout.php'>Home</a></p>";
  $xslDoc = new DOMDocument();
  $xslDoc->load("seeQuestions.xsl");
  $xmlDoc = new DOMDocument();
  $xmlDoc->load("galderak.xml");
  $proc = new XSLTProcessor;
  $proc->importStylesheet($xslDoc);
  echo $proc->transformToXML($xmlDoc);

 ?>
