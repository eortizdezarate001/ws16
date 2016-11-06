<?php
  require_once("lib/nusoap.php");
  require_once("lib/class.wsdlcache.php");

  $ns="http://localhost:1234/ws16/myquiz/egiaztatuPasahitzaZerb.php?wsdl"; //name of the service
  $server = new soap_server;
  $server->configureWSDL('egiaztatuPasahitza',$ns);
  $server->wsdl->schemaTargetNamespace=$ns;
  //inplementatu nahi dugun funtzioa erregistratzen dugu
  $server->register('egiaztatuPasahitza',
  array('x'=>'xsd:string'),
  array('z'=>'xsd:string'),
  $ns);
  //funtzioa inplementatzen dugu
  function egiaztatuPasahitza($pass){
    $file = file_get_contents("toppasswords.txt");
    if(!strpos($file,$pass)){
      return "BALIOZKOA";
    } else{
      return "BALIOGABEA";
    }
  }
  //nusoap klaseko sevice metodoari dei egiten diogu
  $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
  $server->service($HTTP_RAW_POST_DATA);

?>
