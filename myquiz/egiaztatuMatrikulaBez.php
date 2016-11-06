<?php
  require_once("lib/nusoap.php");
  require_once("lib/class.wsdlcache.php");

  $client = new nusoap_client('http://wsjiparsar.esy.es/webZerbitzuak/egiaztatuMatrikula.php?wsdl', false);

  $result = $client->call('egiaztatuE',array('x'=>$_POST['email']));
  echo $result;
 ?>
