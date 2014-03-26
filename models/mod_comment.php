<?php
	
	class Mod_comment extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->output->set_header("Content-Type: text/html; charset=utf-8");
		}

		

		function Judg($praise,$unable,$criticize)
		{
			if($praise=='true')
								{
									if($unable=='true')
									{
										if($criticize=='true')
										{
											$add = "comment.Judgment='0' or comment.Judgment='1' or comment.Judgment='2'";
										}
										else
										{
											$add = "comment.Judgment='0' or comment.Judgment='1'";	
										}
									}
									else
									{
										if($criticize=='true')
										{
											$add = "comment.Judgment='1' or comment.Judgment='2'";
										}
										else
										{
											$add = "comment.Judgment='1'";
										}
									}
								}
								else
								{
									if($unable=='true')
									{
										if($criticize=='true')
										{
											$add = "comment.Judgment='0' or comment.Judgment='2'";
										}
										else
										{
											$add = "comment.Judgment='2'";	
										}
									}
									else
									{
										if($criticize=='true')
										{
											$add = "comment.Judgment='0' or comment.Judgment='2'";
										}
										else
										{
											$add = "comment.Judgment='6'";
										}
									}
								}
				return $add;
		}

		function format($form)
		{
			if($form == 'RadioButton3')//无词类标记
			{
				return "temp.content";
			}
			else //有词类标记
			{
				return "temp.format";
			}
		}

		function comment_like($word,$form,$praise,$unable,$criticize,$limit='null',$offset='null')  //模糊匹配，生语料或分词标记
		{
			$format = $this->mod_comment->format($form);
			$add = $this->mod_comment->Judg($praise,$unable,$criticize);
			if($limit=='null' && $offset=='null')
			{			
				$que = "SELECT id, $format
					FROM (
							SELECT * 
							FROM COMMENT 
							WHERE $add
							) AS temp
				WHERE temp.content LIKE  '%$word%'";
			}
			else
			{
				$que = "SELECT id, $format
					FROM (
							SELECT * 
							FROM COMMENT 
							WHERE $add
							) AS temp
				WHERE temp.content LIKE  '%$word%'
				LIMIT $offset , $limit";
				;
				
			}
				$query = $this->db->query($que);
			return $query;
		}

		function comment_vocabulary($word,$form,$praise,$unable,$criticize,$limit='null',$offset='null')   //整词匹配，生语料或分词标记
		{
			$format = $this->mod_comment->format($form);
			$add = $this->mod_comment->Judg($praise,$unable,$criticize);
			if($limit=='null' && $offset=='null')
			{
					$que = "SELECT id, $format
						FROM (
						SELECT * 
						FROM COMMENT 
						WHERE $add
						) AS temp
						WHERE id
						IN (
						SELECT comandword.cid
						FROM word, comandword
						WHERE word.word =  '$word'
						AND word.id = comandword.wid
						)";
			}
			else
			{

					$que = "SELECT id, $format
						FROM (
						SELECT * 
						FROM COMMENT 
						WHERE $add
						) AS temp
						WHERE id
						IN (
						SELECT comandword.cid
						FROM word, comandword
						WHERE word.word =  '$word'
						AND word.id = comandword.wid
						)
						limit $offset,$limit";
					
			}
			
			$result  = $this->db->query($que);

			return $result;
		}



		

		function weibo_comment($weiboid,$form,$praise,$unable,$criticize,$limit='null',$offset='null')   //微博查找，生语料
		{
				$format = $this->mod_comment->format($form);
				$add = $this->mod_comment->Judg($praise,$unable,$criticize);
				if($limit=='null' && $offset=='null')
				{
					$que = "select id,$format
						from  (
						SELECT * 
						FROM COMMENT 
						WHERE $add
						) AS temp
						where temp.weiboid = $weiboid";
				}
				else
				{
					$que = "select id,$format
						from  (
						SELECT * 
						FROM COMMENT 
						WHERE $add
						) AS temp
						where temp.weiboid = $weiboid
						limit $offset , $limit";
					//echo $que;	
				}
				$query = $this->db->query($que);
			return $query;
		}
}	
?>