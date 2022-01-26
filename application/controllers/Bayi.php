<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Bayi extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $bayi = $this->db->get("bayi")->result_array();

        if ($bayi) {
            $this->response( [
                'status' => true,
                'message' => 'Success',
                'data' => $bayi
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Data bayi kosong',
                'data' => null
            ], 200 );
        }
    }

    public function tambah_post()
    {
        $nama = $this->input->post("nama");
        $tanggal_lahir = $this->input->post("tanggal_lahir");
        $anak_ke = $this->input->post("anak_ke");
        $jenis_kelamin = $this->input->post("jenis_kelamin");
        $berat_badan = $this->input->post("berat_badan");
        $tinggi_badan = $this->input->post("tinggi_badan");
        $nama_ibu = $this->input->post("nama_ibu");
        $no_telp_ortu = $this->input->post("no_telp_ortu");
        $alamat = $this->input->post("alamat");
        $rt_rw = $this->input->post("rt_rw");

        $data = [
            "nama" => $nama,
            "tanggal_lahir" => $tanggal_lahir,
            "anak_ke" => $anak_ke,
            "jenis_kelamin" => $jenis_kelamin,
            "berat_badan" => $berat_badan,
            "tinggi_badan" => $tinggi_badan,
            "nama_ibu" => $nama_ibu,
            "no_telp_ortu" => $no_telp_ortu,
            "alamat" => $alamat,
            "rt_rw" => $rt_rw
        ];

        $insert = $this->db->insert("bayi", $data);

        if ($insert) {
            $this->response( [
                'status' => true,
                'message' => 'Tambah data bayi berhasil!'
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Tambah data bayi gagal!'
            ], 200 );
        }
    }
}