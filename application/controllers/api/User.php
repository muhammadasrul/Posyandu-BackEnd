<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $this->response([
                "status" => true,
                "message" => "muhammadasrul@gmail.com"
        ], 200);
    }

    public function login_post()
    {
        $email = $this->input->post("email");
        $password = $this->input->post("password");

        $user = $this->db->get_where("user", ["email" => $email])->row_array();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->response( [
                    'status' => true,
                    'message' => 'Login berhasil!',
                    'data' => $user
                ], 200 );
            } else {
                $this->response( [
                    'status' => false,
                    'message' => 'Password salah!',
                    'data' => null
                ], 200 );
            }
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Email tidak terdaftar!',
                'data' => null
            ], 200 );
        }
    }

    public function register_post()
    {
        $nama = $this->input->post("nama");
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $tempat_lahir = $this->input->post("tempat_lahir");
        $tanggal_lahir = $this->input->post("tanggal_lahir");
        $alamat = $this->input->post("alamat");
        $posyandu = $this->input->post("posyandu");
        $posyandu_id = $this->input->post("posyandu_id");

        $data = [
            "nama" => $nama,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "tempat_lahir" => $tempat_lahir,
            "tanggal_lahir" => $tanggal_lahir,
            "alamat" => $alamat,
            "posyandu" => $posyandu,
            "posyandu_id" => $posyandu_id,
            "level" => "user"
        ];

        $cek = $this->db->get_where("user", ["email" => $email])->row_array();

        if (!$cek) {
            $insert = $this->db->insert("user", $data);

            if ($insert) {
                $this->response( [
                    'status' => true,
                    'message' => 'Registrasi berhasil!'
                ], 200 );
            } else {
                $this->response( [
                    'status' => false,
                    'message' => 'Registrasi gagal!'
                ], 200 );
            }
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Email sudah terdaftar!'
            ], 200 );
        }
    }
}