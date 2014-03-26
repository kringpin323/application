<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Con_weibo extends CI_Controller 
{


	function __construct()
	{
		parent::__construct();
		$this->config->item('name_of_config_variable');
		$this->output->set_header("Content-Type: text/html; charset=utf-8");
		$this->load->helper('url');
		$this->load->library('typography');
		
		$this->load->database();
		$this->load->model('mod_weibo');
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
			$template['con_fun'] = "/con_weibo/s_wei_using_word/";
			$this->load->view('views_weibo',$template);
		}
	}

	function s_wei_using_word($DropDownListPsize="null",$page=1)
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
			if($DropDownListPsize=="null")
			{
				$array['DropDownListPsize'] = $this->input->post('DropDownListPsize');
				$data['DropDownListPsize'] = $array['DropDownListPsize'];
				$array['weibo_key'] = $this->input->post('TextBox1');
				$_SESSION['WEIBO_KEY'] = $array['weibo_key'];
				$DropDownListPsize=$array['DropDownListPsize'];
				$weibo_key=$array['weibo_key'];
			}
			else
			{
				$array['DropDownListPsize'] = $DropDownListPsize;
				$data['DropDownListPsize'] = $array['DropDownListPsize'];
				$array['weibo_key'] = $_SESSION['WEIBO_KEY'];
			}

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

			if($praise=='Praise'){ $praise = 'true'; }else{$praise = 'false';}
			if($unable=='Unable'){ $unable = 'true'; }else{$unable = 'false';}
			if($criticize=='Criticize'){ $criticize = 'true'; }else{ $criticize = 'false';}

			$in_pattern = $this->input->post('1');
			$out_pattern = $this->input->post('2');

			$res = $this->mod_weibo->weibo_search($array['weibo_key']);

			$this->load->library('pagination');

			//下面的$config['uri_segment'] = '5'指的就是这里，$DropDownListPsize之后的就是第4个，也就是页数
			$config['base_url'] = site_url().'/con_weibo/s_wei_using_word/'.$DropDownListPsize;

			$limit = $data['DropDownListPsize'];
	 		$offset = ($page-1) * $limit;
	 		

			$config['total_rows'] = $res->num_rows();
			$data['totalRows']= $res->num_rows();
			$config['per_page'] = $limit;

			$config['next_link'] = '下一页 >'; // 下一页显示   
			$config['prev_link'] = '< 上一页'; // 上一页显示 
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';
			$config['num_links'] = '3';
			$config['uri_segment'] = '4';
			$config['anchor_class'] = "";
			$config['use_page_numbers'] = TRUE;

			$this->pagination->initialize($config);

			//echo '$offset:  '.$offset.'   $limit:  '.$limit;
			//load the model and get results
			$data['results'] = $this->mod_weibo->weibo_page($array['weibo_key'],$config['per_page'],$offset);
			
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
			$this->table->set_heading('序号', '例句');

			$num=($page-1)*$DropDownListPsize+1;
			$data['num_begin'] = $num;
			$data['num_end'] = $num+$DropDownListPsize-1;
			while($row = $data['results']->_fetch_assoc())
	            {
	            	$newstr=str_replace($array['weibo_key'],'<font color=red>'.$array['weibo_key'].'</font>', $row['content']);//加红标注字体
	                $this->table->add_row(
	                $num,
	                anchor(site_url().'/con_comment/show_comment/'.$row['id'].'/'.$data['DropDownListPsize'].'/'.$out_pattern.'/'.$praise.'/'.$unable.'/'.$criticize, stripslashes($newstr))
	                //$this->typography->auto_typography($row->item)
	                );
	                $num++;
	         	}

	        $data['base']=$this->config->item('base_url');
			$data['css']=$this->config->item('css');

			$data['con_fun'] = "/con_weibo/s_wei_using_word/";

	        $this->load->view('v_s_weibo', $data);
		}
		
	}


}

?>