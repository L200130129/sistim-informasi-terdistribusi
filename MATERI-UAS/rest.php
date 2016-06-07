<?php

require("ItemStorage.php");

//fungsi untuk meresponse client jika terjadi kesalahan
set_exception_handler(function ($e) {
	$code = $e->getCode() ?: 400;
	header("Content-Type: application/json", NULL, $code);
	echo json_encode(["error" => $e->getMessage()]);
	exit;
});

//menyimpan tipe request / verb dalam variabel $verb
$verb = $_SERVER['REQUEST_METHOD'];

//identifikasi link yang di request oleh client
$url_pieces = explode('/', $_SERVER['PATH_INFO']);

$storage = new ItemStorage();

// catch this here, we don't support many routes yet
if($url_pieces[1] != 'items') {
	throw new Exception('Unknown endpoint', 404);
	// exit di sini
}

// jika program sampai di baris ini berarti tidak ada error pada proses sebelumnya

switch($verb) {
	case 'GET':

		if(isset($url_pieces[2])) {
			// data akan di ambil sesuai dengan ID
			try {
				$data = $storage->getOne($url_pieces[2]);
			} catch (UnexpectedValueException $e) {
				throw new Exception("Resource does not exist", 404);
			}
		} else {
			$data = $storage->getAll();
		}
		break; // keluar dari block SWITCH
	// two cases so similar we'll just share code
	case 'POST':  

		header("Content-Type: application/json");
		echo json_encode('{"info":"Operasi POST belum di ijinkan"}');

		exit;
		break;
		// belum ada layanan terkait operasi CREATE 
	case 'PUT':
		// membaca data JSON dari client diubah menjadi ARRAY
		$params = json_decode(file_get_contents("php://input"), true);


//		print_r( $params );


		if(!$params) {
			//tidak ada data dari client
			throw new Exception("Data missing or invalid");
			//exit
		}
		if($verb == 'PUT') {
			$id = $url_pieces[2];
			$item = $storage->update($id, $params);
			$status = 204;
		} else {
			$item = $storage->create($params);
			$status = 201;
		}
		$storage->save();

		// send header, avoid output handler
		// header("Location: " . $item['url'], null,$status);
		exit;
		break;
	case 'DELETE':
		$id = $url_pieces[2];
		$storage->remove($id);
		$storage->save();
		header("Location: http://localhost/rest/rest.php/items", null, 204);
		exit;
		break;
	default: 
		throw new Exception('Method Not Supported', 405);
}

header("Content-Type: application/json");
echo json_encode($data);