


<?php
require_once "lib/nusoap.php";

$wsdl = "http://localhost/sid/soapjsonserver.php?wsdl"; //target server
$client = new nusoap_client($wsdl,'wsdl'); //create CLIEANT SOAP

$error = $client->getError();  //periksa apakah ada klesalahan dalam client
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    exit();  //stop jika ada error
}

// memanggil RPC "getProd"
$result = $client->call("getProd", array("category" => "profile"));

//if ($result) {
    echo "Hasil: "  . $result;  // profile dalam bentuk STRING JSON
//} else {
  //  echo "ada kesalahan transmisi ... ";
//}
