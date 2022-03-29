<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata("nama") == null) {
			redirect("admin/login");
		}
	}

	public function index()
	{
		$user = $this->db->get_where("user", ["email" => $this->session->userdata("email")])->row_array();

		$data = array(
			'title' => "Profile",
			'user' => $user
		);
		$this->load->view('profile', $data);
	}
}
