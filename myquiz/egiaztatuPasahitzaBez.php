<?php
  require_once("lib/nusoap.php");
  require_once("lib/class.wsdlcache.php");

  $client = new nusoap_client('http://localhost:1234/ws16/myquiz/egiaztatuPasahitzaZerb.php?wsdl', true);

  $result = $client->call('egiaztatuPasahitza',array('x'=>$_POST['pass']));
  echo $result;

?>
