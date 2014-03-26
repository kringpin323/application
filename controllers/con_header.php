<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Con_header extends CI_Controller 
{


	function __construct()
	{
		parent::__construct();
		$this->config->item('name_of_config_variable');
		$this->load->helper('url');
		$this->load->library('typography');
		session_start();
		
	}

	function layout()
	{
		$data['con_fun'] = "/con_login/index/";
		$data['base']=$this->config->item('base_url');
		$data['css']=$this->config->item('css');		
        $this->load->view('layout', $data);
	}

	function introduce()
	{
		$data['con_fun'] = "/con_login/index/";
		$data['base']=$this->config->item('base_url');
		$data['css']=$this->config->item('css');		
        $this->load->view('introduce', $data);
	}

	function parts_of_speech()
	{
		$data['con_fun'] = "/con_login/index/";
		$data['base']=$this->config->item('base_url');
		$data['css']=$this->config->item('css');		
        $this->load->view('parts_of_speech', $data);
	}

	function call_us()
	{
		$data['con_fun'] = "/con_login/index/";
		$data['base']=$this->config->item('base_url');
		$data['css']=$this->config->item('css');		
        $this->load->view('call_us', $data);
	}


}

?>