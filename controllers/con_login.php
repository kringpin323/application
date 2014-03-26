<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Con_login extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		session_start();	
	}

	public function index()
	{	
		$template['base']=$this->config->item('base_url');
		$template['css']=$this->config->item('css');
		$template['con_fun'] = "/con_login/check/";
		$this->load->view('views_login',$template);
		
	}

	public function exit_()
	{
			session_destroy();
			redirect('con_login/index/','location');
	}

	
	
	public function check()
	{

		$this->load->helper('url');	
		$this->load->model('mod_login');
		//从前台获取数据！
		$name=$this->input->post('user_name');
		$passwd=$this->input->post('password');
		//验证信息		
		//echo $name." && ".$passwd;
		if(!$this->mod_login->checking($name,$passwd))
		{
			//验证不通过则转到错误页面。
			$template['base']=$this->config->item('base_url');
			$template['css']=$this->config->item('css');
			$template['con_fun'] = "/con_login/index/";
			$template['false'] = $_SESSION['nameword'];
			$this->load->view('login_fail_view',$template);
		}
		else
		{
			redirect('con_topic/show/','location');
		} 
			
	}

}

?>