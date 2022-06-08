<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{

		if ($this->session->userdata("nama") != null) {
			redirect("admin/dashboard");
		}

		$posyandu = $this->db->get("posyandu")->result_array();

		$data = array(
			'title' => "Register",
			'posyandu' => $posyandu
		);
		$this->load->view('auth-register', $data);
	}

	public function register_act()
	{
		$posyandu_id = $this->input->post("posyandu_id");
		$nama = $this->input->post("nama");
		$email = $this->input->post("email");
		$password = password_hash($this->input->post("password"), PASSWORD_DEFAULT);
		$tempat_lahir = $this->input->post("tempat_lahir");
		$tanggal_lahir = $this->input->post("tanggal_lahir");
		$alamat = $this->input->post("alamat");
		$posyandu = $this->db->get_where("posyandu", ["id" => $posyandu_id])->row()->nama;
		$level = "user";

		$user = [
			"posyandu_id" => $posyandu_id,
			"nama" => $nama,
			"email" => $email,
			"password" => $password,
			"tempat_lahir" => $tempat_lahir,
			"tanggal_lahir" => $tanggal_lahir,
			"alamat" => $alamat,
			"posyandu" => $posyandu,
			"level" => $level
		];

		$is_email_exist = $this->db->get_where("user", ["email" => $email])->num_rows();

		if ($is_email_exist > 0) {
			$this->session->set_flashdata("message", '<div class="alert alert-danger mx-2">Gagal, email sudah terdaftar. Silahkan gunakan email lain.</div>');
			redirect("admin/register");
		}

		$this->db->insert("user", $user);
		$this->session->set_flashdata("message", '<div class="alert alert-success mx-2">Daftar akun baru berhasil. Silahkan login</div>');

		redirect("admin/login");
	}

	public function tambah_posyandu()
	{
		$nama = $this->input->post("nama");
		$provinsi = $this->input->post("provinsi");
		$kabupaten = $this->input->post("kabupaten");
		$kecamatan = $this->input->post("kecamatan");
		$desa = $this->input->post("desa");

		$posyandu = [
			"nama" => $nama,
			"provinsi" => $provinsi,
			"kabupaten" => $kabupaten,
			"kecamatan" => $kecamatan,
			"desa" => $desa
		];

		$this->db->insert("posyandu", $posyandu);
		$this->session->set_flashdata("message", '<div class="alert alert-success mx-2">Berhasil menambahkan posyandu</div>');

		redirect("admin/register");
	}
}
