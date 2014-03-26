<?php
	class Spimodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		function get_books($num, $offset) {
   			 $query = $this->db->get('weibo', $num, $offset);        
    		return $query;
  		}

		function useman_insert($arr)
		{
			$this->db->insert("useman",$arr);
		}

		function useman_update($id,$arr)
		{
			$this->db->where("uid",$id);
			$this->db->update("useman",$arr);
		}

		function topic_search($key)
		{
			$this->db->select('content');
			$this->db->where('topic.key',$key);
			$this->db->where('tipicid','topicid');
			$query = $this->db->get('weibo,topic');
			return $query;
		}

		function topic_page($key,$num,$offset)
		{
			
			$this->db->select('weibo.id,content');
			$this->db->where('topic.key',$key);
			$this->db->where('tipicid','topicid');
			$query = $this->db->get('weibo,topic',$num,$offset);
			
			return $query;
		}

		function search_comment($weiboid)
		{
			$this->db->select('comment.id,comment.content');
			$this->db->where('comment.weiboid',$weiboid);
			$query = $this->db->get('comment');
			

			return $query;
		}

		function show($weiboid,$limit,$offset,$table = 'comment')
		{
			if(!$limit){
				$query = $this->db->get($table);
			}
			else
			{
				$this->db->select('comment.id,comment.content');
				$this->db->where('comment.weiboid',$weiboid);
				$this->db->limit($limit,$offset);
				$query = $this->db->get($table);
			}

			return $query;
		}

		

	}
?>