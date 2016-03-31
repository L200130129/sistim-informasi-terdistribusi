<?php

require_once('lib/nusoap.php'); 
$server = new nusoap_server; 
$server->configureWSDL('server', 'urn:server');
$server->wsdl->schemaTargetNamespace = 'urn:server';
 
//Deklarasi tipe data yang akan di berikan kepada client
//dibuat dalam wsdl supya muncul dalam CATALOG
$server->wsdl->addComplexType(
    'Person',   //nama data, seperti nama tabel
    'complexType', //tipe data, tidak boleh dirubah
    'struct', //opsi yang tidak boleh di rubah 
    'all',
    '',
    array(  //Detail tipe data
        'id_user' => array('name' => 'id_user', 'type' => 'xsd:int'),
        'fullname' => array('name' => 'fullname', 'type' => 'xsd:string'),
        'email' => array('name' => 'email', 'type' => 'xsd:string'),
        'level' => array('name' => 'level', 'type' => 'xsd:int')
    )
);

//Mendaftar nama RPC 'login' di soap server
$server->register('login',
			array('username' => 'xsd:string', 'password'=>'xsd:string'),  //parameters
			array('return' => 'tns:Person'),  //output
			'urn:server',   //namespace
			'urn:server#login',  //soapaction
			'rpc', // style
			'encoded', // use
			'Check user login');  //description


//implementasi fungsi / rpc 'login'
function login($username, $password) {
	
	//$pwd = sha1($password);
	//execute SQL Command: 
	// select * from tuser where  username='$username' && password='$pwd' 
	// DI sini dibuat kode untuk validasi user
	// memeriksa data user dalam server database
    //sementara dianggap username dan password BETUL
		

		//koneksi dengan server basisdata
		$servername = "localhost";
		$DB_username = "root";
		$DB_password = "";
		$dbname = "mydb";

		$conn = new mysqli($servername, $DB_username, $DB_password, $dbname);
		if ($conn->connect_error) {
		     die("Connection failed: " . $conn->connect_error);
		}

		$sha1_pass = sha1($password);
		//validasi user
		$sql = "SELECT id, concat(firstname,' ',lastname) as fullname, email, level FROM MyGuests
				where username='$username' and password='$sha1_pass'";
		$result = $conn->query($sql); ///execute SQL


		if ($result->num_rows > 0) {
			//login succsessfully 		
		     return $result->fetch_assoc();
		} else {
			//login fail
		     return array(
		     	'id_user'=>1,
				'fullname'=>'contoh salah username',
				'email'=>'test@test.com',
				'level'=>99);
		}


/*
    return array(
		'id_user'=>1,
		'fullname'=>'John Reese',
		'email'=>'john@reese.com',
		'level'=>99
	);
*/
}
 
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);  //Aktivasi server 