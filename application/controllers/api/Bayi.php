<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Bayi extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get($posyandu_id)
    {
        $bayi = $this->db->get_where("bayi", ["posyandu_id" => $posyandu_id])->result_array();

        if ($bayi) {
            $this->response( [
                'status' => true,
                'message' => '',
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
        $bayi_id = $this->input->post("bayi_id");
        $nama = $this->input->post("nama");
        $posyandu_id = $this->input->post("posyandu_id");
        $tanggal_lahir = $this->input->post("tanggal_lahir");
        $anak_ke = $this->input->post("anak_ke");
        $jenis_kelamin = $this->input->post("jenis_kelamin");
        $berat_badan = $this->input->post("berat_badan");
        $tinggi_badan = $this->input->post("tinggi_badan");
        $nama_ibu = $this->input->post("nama_ibu");
        $nama_ayah = $this->input->post("nama_ayah");
        $no_telp_ortu = $this->input->post("no_telp_ortu");
        $alamat = $this->input->post("alamat");
        $rt_rw = $this->input->post("rt_rw");

        $data = [
            "nama" => $nama,
            "posyandu_id" => $posyandu_id,
            "tanggal_lahir" => $tanggal_lahir,
            "anak_ke" => $anak_ke,
            "jenis_kelamin" => $jenis_kelamin,
            "berat_badan" => $berat_badan,
            "tinggi_badan" => $tinggi_badan,
            "nama_ibu" => $nama_ibu,
            "nama_ayah" => $nama_ayah,
            "no_telp_ortu" => $no_telp_ortu,
            "alamat" => $alamat,
            "rt_rw" => $rt_rw
        ];

        if ($bayi_id != null) {
            $update = $this->db->where("id", $bayi_id)->update("bayi", $data);
            $message =  'Edit data bayi berhasil!';
        } else {
            $insert = $this->db->insert("bayi", $data);

            $bayi = $this->db->get("bayi")->last_row();
            $bayi_id = $bayi->id;

            $data_pengukuran = [
                "bayi_id" => $bayi_id,
                "tinggi_badan" => $tinggi_badan,
                "berat_badan" => $berat_badan,
                "status_berat_badan" => "b"
            ];
            $this->db->insert("pengukuran", $data_pengukuran);
            $message = 'Tambah data bayi berhasil!';
        }

        $this->response( [
            'status' => true,
            'message' => $message
        ], 200 );
    }

    public function hapus_post()
    {
        $id = $this->input->post("id");

        $this->db->delete("bayi", ["id" => $id]);

        if ($this->db->affected_rows()) {
            $this->db->delete("pengukuran", ["bayi_id" => $id]);
            $this->response( [
                'status' => true,
                'message' => 'Hapus data bayi berhasil!'
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Hapus data bayi gagal!'
            ], 200 );
        }
    }

    public function catat_post()
    {
        $bayi_id = $this->input->post("bayi_id");
        $tinggi_badan = $this->input->post("tinggi_badan");
        $berat_badan = $this->input->post("berat_badan");
        $asi = $this->input->post("asi");
        $imd = $this->input->post("imd");

        if ($asi == true) {
            $asi = 1;
        } else {
            $asi = 0;
        }

        if ($imd == true) {
            $imd = 1;
        } else {
            $imd = 0;
        }

        $data = [
            "bayi_id" => $bayi_id,
            "tinggi_badan" => $tinggi_badan,
            "berat_badan" => $berat_badan,
            "asi" => $asi,
            "imd" => $imd
        ];

        $check = $this->db->get_where("pengukuran", [
            "bayi_id" => $bayi_id,
            "SUBSTRING(tanggal_ukur, 1, 7) = " => mdate("%Y-%m")
        ])->row_array();

        if (!$check) {
            $jumlah_pencatatan = $this->db->get_where("pengukuran", ["bayi_id" => $bayi_id])->num_rows();

            $bulan_lalu = mdate("%Y", time())."-".sprintf("%02d", mdate("%m", time())-1);
            $bulan_lalu_check = $this->db->get_where("pengukuran", [
                "bayi_id" => $bayi_id,
                "SUBSTRING(tanggal_ukur, 1, 7) = " => $bulan_lalu
                ])->row_array();

            if (!$bulan_lalu_check) {
                $data["status_berat_badan"] = "o";
            } else {
                if ($berat_badan <= $bulan_lalu_check["berat_badan"]) {
                    $data["status_berat_badan"] = "t";
                } else {
                    $data["status_berat_badan"] = "n";
                }
            }

            if ($jumlah_pencatatan <= 6) {
                $this->db->insert("pengukuran", $data);

                $this->response( [
                    'status' => true,
                    'message' => 'Data pengukuran berhasil disimpan'
                ], 200 );
            } else {
                $this->response( [
                    'status' => false,
                    'message' => 'Gagal, telah melakukan pengukuran selama 6 bulan'
                ], 200 );
            }
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Gagal, pengukuran bulan '.mdate("%F %Y").' sudah dilakukan'
            ], 200 );
        }
    }

    public function toring_post()
    {
        $posyandu_id = $this->input->post("posyandu_id");
        
        $toring = $this->db->query(
            "SELECT b.id as bayi_id, b.nama, p.asi
            FROM bayi as b
            INNER JOIN (SELECT bayi_id, SUM(asi) as asi FROM pengukuran GROUP BY bayi_id) p
            ON b.id = p.bayi_id
            WHERE b.posyandu_id = $posyandu_id")->result_array();
        
        if (sizeof($toring) > 0) {
            $this->response( [
                'status' => true,
                'message' => '',
                'data' => $toring
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Data kosong',
            ], 200 );
        }
    }

    public function sertifikat_get()
    {
        $bayi_id = $this->input->get("bayi_id");

        $pengukuran = $this->db->get_where("pengukuran", ["bayi_id" => $bayi_id, "asi" => 1])->num_rows();
        
        if ($pengukuran >= 6) {
            $this->response( [
                'status' => true,
                'message' => '',
                'data' => [
                    "link" => base_url()."sertifikat?bayi_id=".$bayi_id
                ]
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Sertifikat belum bisa diunduh!'
            ], 200 );
        }
    }

    public function detail_get()
	{
        $bayi_id = $this->input->get("bayi_id");
        
		$bayi = $this->db->get_where("bayi", ["id" => $bayi_id])->row_array();
		$pengukuran = $this->db->get_where("pengukuran", ["bayi_id" => $bayi_id])->result_array();

		if (sizeof($pengukuran) > 0) {
            $this->response( [
                'status' => true,
                'message' => '',
                'data' => [
                    'pengukuran' => $pengukuran,
                    'bayi' => $bayi
                ]
            ], 200 );
        } else {
            $this->response( [
                'status' => false,
                'message' => 'Data pengukuran kosong!'
            ], 200 );
        }
	}
}