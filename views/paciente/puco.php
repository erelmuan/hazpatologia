<?php
$url = 'https://sisa.msal.gov.ar/sisa/services/rest/puco/12388635';

$ch = curl_init( $url );
# Setup request to send json via POST.
$data = array(
      'usuario' => 'vhbarriera',
      'clave' => 'S1stem4s'
  );
$payload = json_encode($data );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
# Send request.

$result = curl_exec($ch);
$oXML = new SimpleXMLElement($result);
curl_close($ch);

var_dump ($oXML);

 ?>
