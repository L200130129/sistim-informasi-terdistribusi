<?php

class Xmlrpc_server extends CI_Controller {

        public function index()
        {
                $this->load->library('xmlrpc');
                $this->load->library('xmlrpcs');

                //Mendaftar semua fungsi atau method yang dapat di panggil
                //dari jarak jarote   atau RPC
                $config['functions']['Greetings'] = 
                  array('function' => 'Xmlrpc_server.process');
                  
                $config['functions']['Simpan'] = 
                  array('function' => 'Xmlrpc_server.simpan_data');

                //mengaktifkan fungsi server xmlrpc  and standby menunggu request client
                $this->xmlrpcs->initialize($config);
                $this->xmlrpcs->serve();
        }



        public function simpan_data($request) {
                //mengambil parameter dari CLIENT
                $parameters = $request->output_parameters();

                //proses meyimpan data dalam database di sini
                //operasi CRUP dapat di eksekusi di sini
                $DATA = json_decode($parameters[0]);

                //pemberitahuan ke CLEINT
                $response = array(

                        array(
                                'Parameter dari Client'  => $parameters[0],
                                'Result' => 'Successfully'
                        ),

                        'struct'
                );

                return $this->xmlrpc->send_response($response);
        }


        public function process($request)
        {
                //mengambil parameter dari client
                $parameters = $request->output_parameters();

                //Proses operasi CRUD 
                //dapat di implementasi di sini

                // response dengan format 'STRUCT'
                $response = array(

                        array(
                                'Parameter dari Client, index 0'  => $parameters[0],
                                'Parameter dari Client, index 1'  => $parameters[1],
                                'Parameter dari Client, index 2'  => $parameters[2],
                                'Parameter dari Client, index 3'  => $parameters[3],
                                'Response Server' => 'Kabar baik.'
                        ),

                        'struct'     //tipe data yang dikirim balik dalam bentuk structure
                );
                // mengirim response ke client
                return $this->xmlrpc->send_response($response);
        }
}