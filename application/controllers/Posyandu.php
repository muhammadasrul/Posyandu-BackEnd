<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Posyandu extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $posyandu = $this->db->get("posyandu")->result_array();

        if ($posyandu) {
            $this->response( [
                'status' => true,
                'message' => 'Success',
                'data' => $posyandu
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Data posyandu kosong',
                'data' => null
            ], 200 );
        }
    }

    public function register_post()
    {
        $nama = $this->input->post("nama");
        $puskesmas = $this->input->post("puskesmas");
        $provinsi = $this->input->post("provinsi");
        $kabupaten = $this->input->post("kabupaten");
        $kecamatan = $this->input->post("kecamatan");
        $desa = $this->input->post("desa");
        $posyandu = $this->input->post("posyandu");

        $data = [
            "nama" => $nama,
            "puskesmas" => $puskesmas,
            "provinsi" => $provinsi,
            "kabupaten" => $kabupaten,
            "kecamatan" => $kecamatan,
            "desa" => $desa
        ];

        $insert = $this->db->insert("posyandu", $data);

        if ($insert) {
            $this->response( [
                'status' => true,
                'message' => 'Pendaftaran posyandu berhasil!'
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Pendaftaran posyandu gagal!'
            ], 200 );
        }
    }
}