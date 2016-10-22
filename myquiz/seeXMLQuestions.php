<?php
  $xslDoc = new DOMDocument();
  $xslDoc->load("galderak.xsl");
  $xmlDoc = new DOMDocument();
  $xmlDoc->load("galderak.xml");
  $proc = new XSLTProcessor;
  $proc->importStylesheet($xslDoc);
  echo $proc->transformToXML($xmlDoc);

 ?>
