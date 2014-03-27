<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Con_comment extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->config->item('name_of_config_variable');
		$this->output->set_header("Content-Type: text/html; charset=utf-8");
		$this->load->helper('url');
		$this->load->library('typography');
		
		$this->load->database();
		$this->load->model('mod_comment');
		session_start();
	}

	function show()
	{
		$template['base']=$this->config->item('base_url');
		$template['css']=$this->config->item('css');
		
		if(empty($_SESSION['lzduser'])|| empty($_SESSION['lzdusername']))
		{
			$template['con_fun'] = "/con_login/check/";
			$_SESSION['fail']='登陆后才可使用搜索功能！';
			$this->load->view('login_fail_view',$template);
		}
		else
		{
			$template['con_fun'] = "/con_comment/search_comment/";
			$this->load->view('views_comment',$template);
		}
		
	}

	//直接搜comment
	//传入参数为：每页个数，查询模式，输出模式，页数
	function search_comment($DropDownListPsize="null",$in_pattern="null",$out_pattern="null",$page=1)
	{
		if(empty($_SESSION['lzduser'])|| empty($_SESSION['lzdusername']))
		{
			$template['base']=$this->config->item('base_url');
			$template['css']=$this->config->item('css');
			$template['con_fun'] = "/con_login/check/";	
			$_SESSION['fail']='登陆后才可使用搜索功能！';
			$this->load->view('login_fail_view',$template);
		}
		else
		{
			if($DropDownListPsize=="null" && $out_pattern=="null")
			{
				//每页显示条目
				$array['DropDownListPsize'] = $this->input->post('DropDownListPsize');
				$data['DropDownListPsize'] = $array['DropDownListPsize'];
				
				//comment搜索关键字	
				$array['comment_key'] = $this->input->post('TextBox1');
				$_SESSION['KEY'] = $array['comment_key'];
				//查询模式， 输出模式
				$array['in_pattern']  = $this->input->post('1');
				$array['out_pattern'] = $this->input->post('2');
				
				// 2014/2/28 处理完成
				$baobian = array();
				$baobian = $this->input->post('baobian');

				$praise ='';
				$unable = '';
				$criticize = '';
				if(!empty($baobian))
				{
					foreach ($baobian as $key => $value) {
						if($baobian[$key] == 'Praise') {$praise = 'Praise';}
						if($baobian[$key] == 'Unable'){$unable = 'Unable';}
						if($baobian[$key] == 'Criticize'){$criticize = 'Criticize';}
					}
				}

				
				if($praise=='Praise'){ $praise = 'true'; }else{ $praise = 'false';}
				if($unable=='Unable'){ $unable = 'true'; }else{ $unable = 'false';}
				if($criticize=='Criticize'){ $criticize = 'true'; }else{ $criticize = 'false';}
				
				$_SESSION['praise'] = $praise;
				$_SESSION['unable'] = $unable;
				$_SESSION['criticize'] = $criticize;

				//每页数目
				$DropDownListPsize=$array['DropDownListPsize'];
				//评论搜索关键字
				$comment_key=$array['comment_key'];
				//输入输出模式
				$in_pattern=$array['in_pattern'];
				$out_pattern=$array['out_pattern'];
 
			}
			else
			{
				// 2014/2/28 处理完成
				// 2014/3/25
				// $baobian = array();
				// $baobian = $this->input->post('baobian');

				// $praise ='';
				// $unable = '';
				// $criticize = '';
				// if(!empty($baobian))
				// {
				// 	foreach ($baobian as $key => $value) {
				// 		if($baobian[$key] == 'Praise') {$praise = 'Praise';}
				// 		if($baobian[$key] == 'Unable'){$unable = 'Unable';}
				// 		if($baobian[$key] == 'Criticize'){$criticize = 'Criticize';}
				// 	}
				// }

				// if($praise=='Praise'){ $praise = 'true'; }else{ $praise = 'false';}
				// if($unable=='Unable'){ $unable = 'true'; }else{ $unable = 'false';}
				// if($criticize=='Criticize'){ $criticize = 'true'; }else{ $criticize = 'false';}
			
				$praise = $_SESSION['praise'] ;
				$unable = $_SESSION['unable'];
				$criticize = $_SESSION['criticize'];
				
				$array['DropDownListPsize'] = $DropDownListPsize;
				$data['DropDownListPsize'] = $array['DropDownListPsize'];
				$array['comment_key'] = $_SESSION['KEY'];
				
				// 输入输出模式
				$array['in_pattern']  = $in_pattern;
				$array['out_pattern'] = $out_pattern;	
 
			}
			
						
			//设置输出模式
			$form = $array['out_pattern'];
			if($array['in_pattern'] == "RBobscure") //模糊匹配
			{
				//模糊匹配
				$res = $this->mod_comment->comment_like($array['comment_key'],$form,$praise,$unable,$criticize);
			 
			}
			else
			{
				//整词匹配
				$res = $this->mod_comment->comment_vocabulary($array['comment_key'],$form,$praise,$unable,$criticize);
			}

						
			$this->load->library('pagination');

			$config['base_url'] = site_url().'/con_comment/search_comment/'.$DropDownListPsize.'/'.$in_pattern.'/'.$out_pattern.'/';
			
			$limit = $data['DropDownListPsize'];
	 		$offset = ($page-1) * $limit;

	 		//返回的匹配总数
			$config['total_rows'] = $res->num_rows();

	 

			$data['totalRows']= $res->num_rows();
			
			//设置每页显示数目
			$config['per_page'] = $limit;
			
			//各种标签
			$config['next_link'] = '下一页 >'; // 下一页显示   
			$config['prev_link'] = '< 上一页'; // 上一页显示 
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';
			
			// 显示链接数
			$config['num_links'] = '3';
			
			// 分割段
			$config['uri_segment'] = '6';
			$config['anchor_class'] = "";
			$config['use_page_numbers'] = TRUE;

			// 为分页类加载config
			$this->pagination->initialize($config);

			//load the model and get results
			if($array['in_pattern'] == "RBobscure") //模糊匹配
			{
				// 带着 limit 和 offset 的返回搜索结果
				$data['results'] = $this->mod_comment->comment_like($array['comment_key'],$form,$praise,$unable,$criticize,$limit,$offset);
			}
			else
			{
				$data['results'] = $this->mod_comment->comment_vocabulary($array['comment_key'],$form,$praise,$unable,$criticize,$limit,$offset);
			}
			
			// load the HTML Table Class
		    $this->load->library('table');

		     $tmpl = array('table_open'          => '<table cellspacing="0" cellpadding="4" align="Center" border="0" id="SensGridView" style="color:#333333;width:904px;border-collapse:collapse;font-family: Calibri">',

		    			'heading_row_start'   => '<tr style="color:White;background-color:#006699;font-size:10pt;font-weight:bold;">',
	                    'heading_row_end'     => '</tr>',
	                    'heading_cell_start'  => '<th align="left" scope="col" style="width:30px;">',
	                    'heading_cell_end'    => '</th>',

	                    'row_start'           => '<tr style="background-color:#EFF3FB;border-color:#EFF3FB;border-width:1px;border-style:None;font-size:10pt;">',
	                    'row_end'             => '</tr>',
	                    'cell_start'          => '<td align="left" >',
	                    'cell_end'            => '</td>',

	                    'row_alt_start'       => '<tr  style="background-color:White;font-size:10pt;">',
	                    'row_alt_end'         => '</tr>',
	                    'cell_alt_start'      => '<td align="left">',
	                    'cell_alt_end'        => '</td>',

	                    'table_close'         => '</table>'
		    				);
		    $this->table->set_template($tmpl);
			$this->table->set_heading('序号', '例句' );

			$num=($page-1)*$DropDownListPsize+1;
			$data['num_begin'] = $num;
			$data['num_end'] = $num+$DropDownListPsize-1;
			while($row = $data['results']->_fetch_assoc())
	            {
	            	if($array['out_pattern'] == "RadioButton3") //分词标记
	            	{
	            		$newstr=str_replace($array['comment_key'],'<font color=red>'.$array['comment_key'].'</font>', $row['content']);//加红标注字体	
	            	}
	            	else
	            	{
	            		if($array['in_pattern'] == "RBobscure") //模糊匹配
	            		{
	            			$newstr = $row['format'];	
	            		}
	            		else
	            		{
	            			$newstr=str_replace($array['comment_key'],'<font color=red>'.$array['comment_key'].'</font>', $row['format']);
	            		}
	            		
	            	}
	            	
	                $this->table->add_row(
	                $num,
	                stripslashes($newstr)
	                // 作品人暂无
	                // ,
	                // anchor("",'作品人')
	                );
	                $num++;
	         	}


			$data['base']=$this->config->item('base_url');
			$data['css']=$this->config->item('css');
			$data['con_fun'] = "/con_comment/search_comment/";
	        $this->load->view('v_s_comment', $data);
		}
	}

	//通过微博点击找到comment
	//$DropDownListPsize="null",$in_pattern="null",$out_pattern="null",$page=1
	function show_comment($weiboid='123',$DropDownListPsize='null',$out_pattern="null",$praise='true',$unable='true',$criticize='true',$page =1)
	{
		if(empty($_SESSION['lzduser'])|| empty($_SESSION['lzdusername']))
		{
			//模板数组 template
			$template['base']=$this->config->item('base_url');
			$template['css']=$this->config->item('css');

			//选项用来动态生成 http post 地址
			$template['con_fun'] = "/con_login/check/";	
			
			//不会消失的_SESSION提示信息
			$_SESSION['fail']='登陆后才可使用搜索功能！';

			$this->load->view('login_fail_view',$template);
		}
		else
		{

			$data['DropDownListPsize'] = $DropDownListPsize;
			$form = $out_pattern;
			$comment = $this->mod_comment->weibo_comment($weiboid,$form,$praise,$unable,$criticize);
			$data['pageSize'] = $page;

			$this->load->library('pagination');

			//下面的$config['uri_segment'] = '5'指的就是这里，$DropDownListPsize之后的就是第5个，也就是页数
			$config['base_url'] = site_url().'/con_comment/show_comment/'.$weiboid.'/'.$DropDownListPsize.'/'.$out_pattern.'/'.$praise.'/'.$unable.'/'.$criticize.'/';
			
	 		$limit = $data['DropDownListPsize'];
	 		$offset = ($page-1) * $limit;
			$config['total_rows'] = $comment->num_rows();
			$data['totalRows']= $comment->num_rows();
			$config['per_page'] = $limit;
			
			$config['next_link'] = '下一页 >'; // 下一页显示   
			$config['prev_link'] = '< 上一页'; // 上一页显示 
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';

			$config['num_links'] = '3';
			$config['uri_segment'] = '9';
			$config['anchor_class'] = "";
			$config['use_page_numbers'] = TRUE;
			
			$this->pagination->initialize($config);

			$form = $out_pattern;
			$data['results'] = $this->mod_comment->weibo_comment($weiboid,$form,$praise,$unable,$criticize,$limit,$offset);
			$data['baobian'] = $this->mod_comment->baobian($weiboid);

			$data['baoyi'] = "0";
			$data['bianyi'] = "0";
			$data['wufapanduan'] = "0";
// 请注意:  0 是无法确定，1是褒义 ，2是贬义
			while($row = $data['baobian']->_fetch_assoc())
	            {
	            	 if($row['Judgment'] =='0')
	            	 {
	            	 	$data['wufapanduan'] = $row['coun'];
	            	 }
	            	 else if($row['Judgment'] =='1')
	            	 {
	            	 	$data['baoyi'] = $row['coun'];
	            	 }
	            	 else
	            	 {
	            	 	$data['bianyi'] = $row['coun'];
	            	 }
	         	}

			// load the HTML Table Class
		    $this->load->library('table');
		    
		    $tmpl = array('table_open'          => '<table cellspacing="0" cellpadding="4" align="Center" border="0" id="SensGridView" style="color:#333333;width:904px;border-collapse:collapse;font-family: Calibri">',

		    			'heading_row_start'   => '<tr style="color:White;background-color:#006699;font-size:10pt;font-weight:bold;">',
	                    'heading_row_end'     => '</tr>',
	                    'heading_cell_start'  => '<th align="left" scope="col" style="width:30px;">',
	                    'heading_cell_end'    => '</th>',

	                    'row_start'           => '<tr style="background-color:#EFF3FB;border-color:#EFF3FB;border-width:1px;border-style:None;font-size:10pt;">',
	                    'row_end'             => '</tr>',
	                    'cell_start'          => '<td align="left" >',
	                    'cell_end'            => '</td>',

	                    'row_alt_start'       => '<tr  style="background-color:White;font-size:10pt;">',
	                    'row_alt_end'         => '</tr>',
	                    'cell_alt_start'      => '<td align="left">',
	                    'cell_alt_end'        => '</td>',

	                    'table_close'         => '</table>'
		    				);
		    $this->table->set_template($tmpl);
			
		    // load the view
			$this->table->set_heading('序号', '例句' );

			$num=($page-1)*$DropDownListPsize+1;
			$data['num_begin'] = $num;
			$data['num_end'] = $num+$DropDownListPsize-1;

			

			while($row = $data['results']->_fetch_assoc())
	            {
	            	if($out_pattern == "RadioButton3") //分词标记
	            	{
	            		$newstr = $row['content'];	
	            	}
	            	else
	            	{
	            		$newstr = $row['format'];	
	            	}
	                $this->table->add_row(
	                $num,
	                stripslashes($newstr)
	                // 作品人暂无
	                // ,
	                // anchor(site_url().'/con_comment/creator_Information/'.$row['userid'],'作品人')
	                
	                );
	                $num++;
	         	}
			// $data['baoyi'] = $data['baobian']['1'];
			// $data['bianyi'] = $data['baobian']['2'];
			// $data['wufapanduan'] = $data['baobian']['0'];
	 

	        $data['base']=$this->config->item('base_url');
			$data['css']=$this->config->item('css');
			$data['con_fun'] = "/con_comment/search_comment/";
			$this->load->view('v_s_comment', $data);
		}
	}

	// 弹窗功能，要再js中才能使用了
	// 修改日期 2014/3/26
	// function creator_Information($userid)
	// {

	// 		$data['base']=$this->config->item('base_url');
	// 		$data['css']=$this->config->item('css');
	// 		$data['con_fun'] = "/con_comment/search_comment/";
	// 		$this->load->view('v_s_', $data);
	// }
}

?>