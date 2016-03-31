<?php 
require_once('lib/nusoap.php');

//Definisi target server
$wsdl = "http://localhost/sid/server.php?wsdl";
//membuat obyek client
$client = new nusoap_client($wsdl,'wsdl');

//periksa apakah ada error ketika membuat soap client
$err = $client->getError();
//jika ada kesalahan dalam client maka 
//nilai $err > 0

if ($err) {
	//di sini akan di eksekusi jika ada error ($err > 0)
	echo '<h2>Constructor error</h2>' . $err;
    exit();  //selesai eksekusi kode
    echo 'test';
}
//mulai proses login 
//Memanggil RPC 'login' di server
$result2 = $client->call('login', 
	array('username'=>'user', 'password'=>'salah') );

//$result2 would be an array/struct
print_r($result2);

/*
echo "<hr>";
print('<h1>JSON format </h1><br>');
  
$json = json_encode($result2);  //array -> json

print( $json );

echo "<hr>";
print('<h1>ARRAY format </h1><br>');
$my_array = json_decode( $json ); //json -> array
print_r( $my_array ); 
*/
?>

<hr>
<h1> Data dalam bentuk Table </h1>
<table border="1">
	<tr><td>Nama</td><td>email</td><td>level</td></tr>
	<tr><td><?=$result2['fullname']?></td>
	    <td><?=$result2['email']?></td>
	    <td><?=$result2['level']?></td>
	</tr>
</table>

<?php
/*
echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
*/

/*
//calling our first simple entry point
$result1=$client->call('hello', array('username'=>'achmad'));
print_r($result1); 
*/ 
