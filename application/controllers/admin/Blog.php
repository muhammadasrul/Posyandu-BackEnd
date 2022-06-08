<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata("nama") == null) {
			redirect("admin/login");
		}
	}

	public function index()
	{
		$articles = $this->db->query("SELECT article.*, article_category.category FROM article LEFT JOIN article_category ON article.category_id = article_category.id")->result_array();

		$data = [
			'title' => "Blog",
			'articles' => $articles
		];

		$this->load->view('blog', $data);
	}

	public function tambah()
	{
		$id = $this->input->get("id");
		$category = $this->db->get("article_category")->result_array();

		if ($id) {
			$article = $this->db->get_where("article", ["id" => $id])->row_array();
		} else {
			$article = [
				"id" => "",
				"title" => "",
				"category_id" => "",
				"content" => "",
				"link" => ""
			];
		}

		$data = [
			'title' => "Tambah Article",
			'category' => $category,
			'article' => $article
		];

		$this->load->view('tambah_article', $data);
	}

	public function tambah_act()
	{
		$id = $this->input->post("id");

		$title = $this->input->post("title");
		$content = $this->input->post("content");
		$link = $this->input->post("link");
		$category = $this->input->post("category");

		$data = [
			"title" => $title,
			"content" => $content,
			"link" => $link,
			"category_id" => $category
		];

		if (count($_FILES) > 0) {
            $config = [
                'upload_path' => './uploads/thumb/',
                'allowed_types' => 'jpg|jpeg|png'
            ];

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('thumb')) {
				$error = $this->upload->display_errors('', '');
                $this->session->set_flashdata("message", $error);
            } else {
                $thumb = $this->upload->data('file_name');
                $data['thumb'] = $thumb;
            }
        }

		$link_check = $this->db->get_where("article", ["link" => $link])->num_rows();

		if ($link_check) {
			if ($id) {
				$this->db->where("id", $id)->update("article", $data);
			} else {
				$this->session->set_flashdata("message", "gagal menambah postingan");
				redirect("admin/blog/tambah");
			}
		} else {
			if ($id) {
				$this->db->where("id", $id)->update("article", $data);
			} else {
				$this->db->insert("article", $data);
			}
		}

		redirect("admin/blog");
	}

	public function hapus($id)
	{
		$this->db->delete("article", ["id" => $id]);
		redirect("admin/blog");
	}

	public function tambah_category()
	{
		$category = $this->input->post("category");
		$id = $this->input->post("id");

		$this->db->insert("article_category", ["category" => $category]);

		if ($id == "") {
			$cat_id = $this->db->get("article_category")->last_row()->id;
			redirect("admin/blog/tambah?cat_id=".$cat_id);
		} else {
			redirect("admin/blog/tambah?id=".$id);
		}
	}
}
