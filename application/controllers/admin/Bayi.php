<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bayi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata("nama") == null) {
			redirect("admin/login");
		}
	}

	public function index()
	{
		$posyandu_id = $this->session->userdata("posyandu_id");

		if ($posyandu_id == null) {
			$bayi = $this->db->get("bayi")->result_array();
		} else {
			$bayi = $this->db->get_where("bayi", ["posyandu_id" => $posyandu_id])->result_array();
		}

        if (!$bayi) {
            $this->session->set_flashdata("message", '<div class="alert alert-danger">Data bayi kosong.</div>');
        }
		
		$data = array(
			'title' => "Data Bayi",
			'data' => $bayi
		);
		$this->load->view('bayi', $data);
	}

	public function edit($bayi_id)
	{
		if ($bayi_id != 0) {
			$title = "Edit Data Bayi";
			$bayi = $this->db->get_where("bayi", ["id" => $bayi_id])->row_array();
		} else {
			$title = "Tambah Data Bayi";
			$bayi = [
				"id" => "",
				"nama" => "",
				"tanggal_lahir" => "",
				"anak_ke" => "",
				"jenis_kelamin" => "",
				"berat_badan" => "",
				"tinggi_badan" => "",
				"nama_ayah" => "",
				"nama_ibu" => "",
				"no_telp_ortu" => "",
				"alamat" => "",
				"rt_rw" => ""
			];
		}

		$data = array(
			'title' => $title,
			'bayi' => $bayi
		);

		$this->load->view('edit', $data);
	}

	public function edit_act()
	{
		$bayi_id  = $this->input->post("id");
		$posyandu_id = $this->session->userdata("posyandu_id");
		$nama = $this->input->post("nama");
		$tanggal_lahir = $this->input->post("tanggal_lahir");
		$anak_ke = $this->input->post("anak_ke");
		$jenis_kelamin = $this->input->post("jenis_kelamin");
		$berat_badan = $this->input->post("berat_badan");
		$tinggi_badan = $this->input->post("tinggi_badan");
		$nama_ayah = $this->input->post("nama_ayah");
		$nama_ibu = $this->input->post("nama_ibu");
		$no_telp_ortu = $this->input->post("no_telp_ortu");
		$alamat = $this->input->post("alamat");
		$rt_rw = $this->input->post("rt_rw");

		$data = [
			"posyandu_id" => $posyandu_id,
			"nama" => $nama,
			"tanggal_lahir" => $tanggal_lahir,
			"anak_ke" => $anak_ke,
			"jenis_kelamin" => $jenis_kelamin,
			"berat_badan" => $berat_badan,
			"tinggi_badan" => $tinggi_badan,
			"nama_ayah" => $nama_ayah,
			"nama_ibu" => $nama_ibu,
			"no_telp_ortu" => $no_telp_ortu,
			"alamat" => $alamat,
			"rt_rw" => $rt_rw
		];

		if ($bayi_id != null) {
            $update = $this->db->where("id", $bayi_id)->update("bayi", $data);
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
        }

		redirect("admin/bayi");
	}

	public function catat()
	{
		$bayi_id = $this->input->post("id");
		$tinggi_badan = $this->input->post("tinggi_badan");
		$berat_badan = $this->input->post("berat_badan");
		if ($this->input->post("imd") == null) {
			$imd = 0;
		} else {
			$imd = 1;
		}
		if ($this->input->post("asi") == null) {
			$asi = 0;
		} else {
			$asi = 1;
		}

		$data = [
			"bayi_id" => $bayi_id,
			"tinggi_badan" => $tinggi_badan,
			"berat_badan" => $berat_badan,
			"imd" => $imd,
			"asi" => $asi
		];

		$check = $this->db->get_where("pengukuran", [
            "bayi_id" => $bayi_id,
            "SUBSTRING(tanggal_ukur, 1, 7) = " => mdate("%Y-%m")
        ])->row_array();
		
		$bayi = $this->db->get_where("bayi", ["id" => $bayi_id])->row_array();

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
				$this->session->set_flashdata("message", '<div class="alert alert-success">Data pengukuran data '.$bayi["nama"].' berhasil disimpan.</div>');
            } else {
				$this->session->set_flashdata("message", '<div class="alert alert-danger">Gagal, pengukuran data '.$bayi["nama"].' telah dilakukan selama 6 bulan.</div>');
            }
        } else {
			$this->session->set_flashdata("message", '<div class="alert alert-danger">Gagal, pengukuran data '.$bayi["nama"].' bulan '.mdate("%F %Y").' sudah dilakukan.</div>');
        }

		redirect("admin/bayi");
	}

	public function hapus($bayi_id)
	{
		$this->db->delete("bayi", ["id" => $bayi_id]);
		if ($this->db->affected_rows()) {
            $this->db->delete("pengukuran", ["bayi_id" => $id]);
			$this->session->set_flashdata("message", '<div class="alert alert-success">Hapus data berhasil.</div>');
        } else {
            $this->session->set_flashdata("message", '<div class="alert alert-danger">Hapus data gagal.</div>');
        }
		redirect("admin/bayi");
	}

	public function sertifikat($bayi_id)
    {
        $pengukuran = $this->db->get_where("pengukuran", ["bayi_id" => $bayi_id, "asi" => 1])->num_rows();

        if ($pengukuran >= 6) {
            redirect(base_url()."api/sertifikat?bayi_id=".$bayi_id);
        } else {
			$this->session->set_flashdata("message", '<div class="alert alert-danger">Sertifikat belum bisa diunduh.</div>');
			redirect("admin/bayi");
        }
    }

	public function detail($bayi_id)
	{
		$bayi = $this->db->get_where("bayi", ["id" => $bayi_id])->row_array();
		$pengukuran = $this->db->get_where("pengukuran", ["bayi_id" => $bayi_id])->result_array();

		$data = [
			'title' => "Detail Data Bayi",
			'bayi' => $bayi,
			'pengukuran' => $pengukuran
		];

		$this->load->view('bayi_detail', $data);
	}
}
