<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
// 请注意:  0 是无法确定，1是褒义 ，2是贬义

*四个点还没有做完：
1. 话题搜索没支持多关键字搜索(从客户处未见重要 2014-3-28 )（重要但搁置）
2. 褒贬显示是无法选择的(于2014/2/28完成)
3. 按浏览器的返回按钮会导致重新提交订单的错误(搁置)
4. 微博搜索或者评论搜索如果为空，显示全部内容（搁置）
5. con_topic 的分页功能 (于2014-2-25完成)
6. 用session 将 查询模式，输出模式，褒贬显示重写（搁置，不重要 2014-3-28）
7. 学习js，用js写弹出作品人（无需 2014-3-28）
8. 显示微博时间（客户需求）(2014/3/27 完成)
9. 显示褒贬义数目（客户需求）（2014-3-28 完成）（基本完成，只是褒贬义分得不太准确，而且要在search_comment中要定为到原微博不容易。）
10. 点击重新回到上下文处（客户需求）（2014-3-28 完成）
*日期：2013-12-24
*作者：林景培
*
*/

class Con_topic extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->config->item('name_of_config_variable');
		$this->output->set_header("Content-Type: text/html; charset=utf-8");
		$this->load->helper('url');
		$this->load->library('typography');
		
		$this->load->database();
		$this->load->model('mod_topic');
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
			$template['con_fun'] = "/con_topic/search_topic/";
			$this->load->view('views_topic',$template);
		}
			
	}

	function search_topic($DropDownListPsize="null",$page=1) //查询topic和分页显示功能在这里实现了
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
				$array['topic_key'] = $this->input->post('TextBox1');
				$_SESSION['KEY'] = $array['topic_key'];
				$DropDownListPsize = $array['DropDownListPsize'];
				$comment_key = $array['topic_key'];
			}
			else
			{
				$array['DropDownListPsize'] = $DropDownListPsize;
				$data['DropDownListPsize'] = $array['DropDownListPsize'];
				$array['topic_key'] = $_SESSION['KEY'];
				
			}


			//搜索查找 topic_key,返回的结果存储在$res中			
			$res = $this->mod_topic->topic_search($array['topic_key']);

			//加载分页类
			$this->load->library('pagination');

			//设置base_url  为分页类做准备
			//此处是ci分页类最最重要的处理位置
			$config['base_url'] = site_url().'/con_topic/search_topic/'.$DropDownListPsize;
			
			

			$limit = $data['DropDownListPsize'];
	 		$offset = ($page-1) * $limit;

			//将结果的总行数放在这两个里面
			$config['total_rows'] = $res->num_rows();
			$data['totalRows']= $res->num_rows();

			//设置每个页面显示多少条结果
			$config['per_page'] = $limit;
			
			//format
			$config['next_link'] = '下一页 >'; // 下一页显示   
			$config['prev_link'] = '< 上一页'; // 上一页显示 
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';
			//设置分页类的显示链接条目，这里是3
			//指的就是前后能够显示当前页的3个以内的结果
			$config['num_links'] = '3';
			//接受分页类的分页数是 被函数的第4个
			$config['uri_segment'] = '4';
			//作用未知
			$config['anchor_class'] = "";
			//使用页数目，作用未知
			$config['use_page_numbers'] = TRUE;
			


			//测试 打印 总数目  关键字 
			//echo '总数目  '.$config['total_rows'].'    关键字:  '.$array['topic_key'];

			//分页类加载 $config 目的是将上述的设置加载
			$this->pagination->initialize($config);

			

			//load the model and get results
			//加载mod_topic的topic_page函数，该函数的接受 查找关键字，每页限制数目，开始条目
			$data['results'] = $this->mod_topic->topic_page($array['topic_key'],$config['per_page'],$offset);
			
			

			// load the HTML Table Class
			//加载 table类 ，统一table格式
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

			//设置 table 模板
		    $this->table->set_template($tmpl);

		    //设置table 题头
			$this->table->set_heading('序号', '例句','时间');

			//显示本页要输出的条目，从 多少到多少 之类
			$num=($page-1)*$DropDownListPsize+1;
			$data['num_begin'] = $num;
			$data['num_end'] = $num+$DropDownListPsize-1;

			//添加并输出
			while($row = $data['results']->_fetch_assoc())
	            {
	            	//row是每个条目
	                $this->table->add_row(
	                $num, //题目标号
	                anchor(site_url().'/con_comment/show_comment/'.$row['id'].'/'.$data['DropDownListPsize'].'/RadioButton3', $row['content']),
	                $row['createdate']
	                // site_url().'/con_comment/show_comment/'.$row['id'].'/'.$data['DropDownListPsize']
	                // 该段代表 生成链接 site_url() 的 con_comment 的 show_comment函数，参数列表：weiboid，每页数目，跳转过去默认第一页
	                );
	                $num++;
	         	}

	         

	        $data['base']=$this->config->item('base_url');
			$data['css']=$this->config->item('css');

			// 该设置用以 动态 生成 http post 地址，
			//但是出现了 按后退按钮需要重新提交的问题,等待解决
			$data['con_fun'] = "/con_topic/search_topic/";

			//将data传递给 v_s_top_wei 	
	        $this->load->view('v_s_top_wei', $data);
		}
	}

}

?>