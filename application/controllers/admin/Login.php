<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{

		if ($this->session->userdata("nama") != null) {
			redirect("admin/dashboard");
		}

		$data = array(
			'title' => "Login"
		);
		$this->load->view('auth-login', $data);
	}

	public function login_act()
	{
		$email = $this->input->post("email");
		$password = $this->input->post("password");

		$user = $this->db->get_where("user", ["email" => $email])->row_array();

		if ($user) {
			if (password_verify($password, $user["password"])) {
				$this->session->set_userdata($user);

				redirect("admin/dashboard");
			} else {
				$this->session->set_flashdata("email", $email);
				$this->session->set_flashdata("message", '<div class="alert alert-danger mx-2">Password salah.</div>');
			}
		} else {
			$this->session->set_flashdata("message", '<div class="alert alert-danger mx-2">Email tidak terdaftar.</div>');
		}

		redirect("admin/login");
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("admin/login");
	}
}
