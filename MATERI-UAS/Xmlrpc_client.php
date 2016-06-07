<?php

class Xmlrpc_client extends CI_Controller {

        public function index()
        {
                $this->load->helper('url');
                // $server_url = site_url('xmlrpc_server');
                //Link target server 'xmlrpc'
                $server_url = "http://localhost/sid/api/index.php/Xmlrpc_server/index";

                // memmanggil library
                $this->load->library('xmlrpc');

 //mengkonfigurasi server target, dengan parameer link server dan nomor port
                // 80 = http protocol
                $this->xmlrpc->server($server_url, 80);

// method atau function di server yang akan dipanggil oleh client 
                $this->xmlrpc->method('Greetings');
// parameter fungsi di atas
                
                // $data = 'Nama user';  
                              
                $request = array( 'Nama user', 'NIM', 'Alamat', '{"json":"format data"}');

                $this->xmlrpc->request($request);

                if ( ! $this->xmlrpc->send_request())   //eksekusi RPC 
                {       
                        // eksekusi RPC gagal 
                        echo $this->xmlrpc->display_error();
                }
                else
                {       //eksekusi RPC sukses

                        echo '<h1>Response dari server</h1>';
                        
                        echo '<pre>';
                        print_r($this->xmlrpc->display_response());
                        // Di sini tempat code untuk memproses data dari server
                        echo '</pre>';
                }
        }
}
?>