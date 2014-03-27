<?php

	class Mod_weibo extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->output->set_header("Content-Type: text/html; charset=utf-8");
		}

		function weibo_search($key)
		{
				$que = "SELECT weibo.id, weibo.content
					FROM weibo
					WHERE weibo.content LIKE  '%$key%'";	
				$query = $this->db->query($que);
				return $query;
		}

		function weibo_page($key,$limit,$offset)
		{
				$que = "SELECT weibo.id, weibo.content,weibo.createdate
					FROM weibo
					WHERE weibo.content LIKE  '%$key%'
					limit $offset,$limit";
				$query = $this->db->query($que);
				return $query;	
		}
}
?>