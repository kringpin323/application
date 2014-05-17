<?php


	class Mod_comment extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->output->set_header("Content-Type: text/html; charset=utf-8");
		}

		
		function yuanweibo($weiboid)
		{
			$que = "
					SELECT content,createdate
					FROM  `weibo` 
					WHERE id =  $weiboid
					";
			$query = $this->db->query($que);
			return $query;
		}

		function yuancomment($weiboid)
		{
			$que = "
					SELECT comment.id,content,datetm,name,gender
					FROM  `comment`,user
					WHERE weiboid =  $weiboid
					and comment.userid = user.id
					";
			$query = $this->db->query($que);
			return $query;
		}

	// 请注意:  0 是无法确定，1是褒义 ，2是贬义
	// 
		function Judg($praise,$unable,$criticize)
		{
			if($praise=='true')
								{
									if($criticize=='true')
									{
										if($unable=='true')
										{
											$add = "comment.Judgment='0' or comment.Judgment='1' or comment.Judgment='2'";
										}
										else
										{  // 贬义 褒义
											$add = "comment.Judgment='2' or comment.Judgment='1'";	
										}
									}
									else
									{
										if($unable=='true')
										{  // 褒义 无法确定
											$add = "comment.Judgment='1' or comment.Judgment='0'";
										}
										else
										{  //褒义
											$add = "comment.Judgment='1'";
										}
									}
								}
		else
								{
									if($criticize=='true')
									{
										if($unable=='true')
										{   //贬义 无法确定
											$add = "comment.Judgment='0' or comment.Judgment='2'";
										}
										else
										{  // 贬义
											$add = "comment.Judgment='2'";	
										}
									}
									else
									{
										if($unable=='true')
										{   // 无法确定
											$add = "comment.Judgment='0'";
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
				$que = "SELECT weiboid,temp.id,datetm, $format,name,gender
					FROM (
							SELECT * 
							FROM COMMENT 
							WHERE $add
							) AS temp, user
				WHERE temp.content LIKE  '%$word%'
				and user.id = temp.userid";
			}
			else
			{
				$que = "SELECT weiboid,temp.id,datetm, $format,name,gender
					FROM (
							SELECT * 
							FROM COMMENT 
							WHERE $add
							) AS temp, user
				WHERE temp.content LIKE  '%$word%'
				and user.id = temp.userid
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
					$que = "SELECT weiboid,temp.id,datetm, $format,name,gender
						FROM (
						SELECT * 
						FROM COMMENT
						WHERE $add
						) AS temp , user
						WHERE temp.id
						IN (
						SELECT comandword.cid
						FROM word, comandword
						WHERE word.word =  '$word'
						AND word.id = comandword.wid
						)
						and user.id = temp.userid
						

						";
			}
			else
			{

					$que = "SELECT weiboid,temp.id,datetm, $format,name,gender
						FROM (
						SELECT * 
						FROM COMMENT
						WHERE $add
						) AS temp , user
						WHERE temp.id
						IN (
						SELECT comandword.cid
						FROM word, comandword
						WHERE word.word =  '$word'
						AND word.id = comandword.wid
						)
						and user.id = temp.userid
						
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
					$que = "select temp.id,datetm,$format,name,gender
						from  (
						SELECT * 
						FROM COMMENT 
						WHERE $add
						) AS temp,user
						where temp.weiboid = $weiboid
						and temp.userid = user.id";
				}
				else
				{
					$que = "select temp.id,datetm,$format,name,gender
						from  (
						SELECT * 
						FROM COMMENT 
						WHERE $add
						) AS temp,user
						where temp.weiboid = $weiboid
						and temp.userid = user.id
						limit $offset , $limit";
					//echo $que;	
				}
				$query = $this->db->query($que);
			return $query;
		}

		function baobian($weiboid)
		{
			$que = "SELECT Judgment, COUNT( * ) AS coun 
					FROM COMMENT 
					WHERE  $weiboid = weiboid
					GROUP BY Judgment
					" ;
			$query = $this->db->query($que);
			return $query;
		}
}	
?>