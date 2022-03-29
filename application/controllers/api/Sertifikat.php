<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {

	public function index()
	{
        $bayi_id = $this->input->get("bayi_id");

        $bayi = $this->db->get_where("bayi", ["id" => $bayi_id])->row_array();
        $posyandu = $this->db->get_where("posyandu", ["id" => $bayi["posyandu_id"]])->row_array();

        $data = [
            "nama" => $bayi["nama"],
            "ayah" => $bayi["nama_ayah"],
            "ibu" => $bayi["nama_ibu"],
            "posyandu" => $posyandu["nama"]
        ];

		$this->load->view('sertifikat', $data);
	}
}