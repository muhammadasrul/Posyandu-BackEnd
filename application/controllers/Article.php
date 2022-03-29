<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {

	public function index()
	{
		$article = $this->db->query("SELECT * FROM article LEFT JOIN article_category ON article.category_id = article_category.id ORDER BY create_at DESC")->result_array();

		$data = [
			"title" => "Home",
			"article" => $article
		];

		$this->load->view('article', $data);
	}

	public function read($link)
	{
		$articles = $this->db->query("SELECT * FROM article LEFT JOIN article_category ON article.category_id = article_category.id ORDER BY create_at DESC")->result_array();
		$article = $this->db->query("SELECT * FROM article LEFT JOIN article_category ON article.category_id = article_category.id WHERE article.link = '$link'")->row_array();

		$data = [
			"title" => "Article",
			"article" => $article,
			"articles" => $articles,
		];

		$this->load->view('article_detail', $data);
	}
}
