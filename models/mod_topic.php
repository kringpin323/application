<?php
	class Mod_topic extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		function topic_search($key)
		{
				$rowkey = explode(" ",$key);
				$que = "SELECT weibo.id, weibo.content
						FROM weibo, topicandkey
						WHERE weibo.topicid = topicandkey.topicid
						AND topicandkey.key in ('$key')";
				$query = $this->db->query($que);
				return $query;
		}

		function topic_page($key,$limit,$offset)
		{
				$rowkey = explode(" ",$key);
				
				/*foreach ($rowkey as $row) {
					echo " row ".$row;
				}*/
				$que = "SELECT weibo.id, weibo.content,weibo.createdate
						FROM weibo, topicandkey
						WHERE weibo.topicid = topicandkey.topicid
						AND topicandkey.key in ('$key')
						limit $offset,$limit";
				$query = $this->db->query($que);
				return $query;			
		}
}
?>