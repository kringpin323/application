<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Spicontrol extends CI_Controller 
{


	function __construct()
	{
		parent::__construct();
		$this->config->item('name_of_config_variable');
		$this->load->helper('url');
		$this->load->library('typography');
		
		$this->load->database();
		$this->load->model('spimodel');

		//$base=$this->config->item('base_url');
		
	}

	function introduce()
	{
		$template['base']=$this->config->item('base_url');
		$template['css']=$this->config->item('css');
		$this->load->view('introduce',$template);
	}

	function parts_of_speech()
	{
		$template['base']=$this->config->item('base_url');
		$template['css']=$this->config->item('css');
		$this->load->view('parts_of_speech',$template);
	}

	function layout()
	{
		$template['base']=$this->config->item('base_url');
		$template['css']=$this->config->item('css');
		$this->load->view('layout',$template);
	}

	function show()
	{
		$template['base']=$this->config->item('base_url');
		$template['css']=$this->config->item('css');
		$this->load->view('views_topic',$template);
	}

	function search_comment()
	{
		$template['base']=$this->config->item('base_url');
		$template['css']=$this->config->item('css');
		$this->load->view('search_comment',$template);
	}

	function search_topic() //查询topic和分页显示功能在这里实现了
	{
		$array['DropDownListPsize'] = $this->input->get('DropDownListPsize');
		$data['DropDownListPsize'] = $array['DropDownListPsize'];
		$array['topic_key'] = $this->input->get('TextBox1');
		$res = $this->spimodel->topic_search($array['topic_key']);
		//$this->load->view('views_show',$res,$array);

		$this->load->library('pagination');

		$config['base_url'] = site_url().'spicontrol/search_topic';
		//$query = $this->db->query('select weibo.content from weibo,topic where topic.key="地产" and tipicid=topicid;' );
 
		$config['total_rows'] = $res->num_rows();
		$data['totalRows']= $res->num_rows();
		$config['per_page'] = $data['DropDownListPsize'];
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';

		$this->pagination->initialize($config);

		//load the model and get results
		//$this->load->model('spimodel');
		$data['results'] = $this->spimodel->topic_page($array['topic_key'],$config['per_page'],$this->uri->segment(3));
				
		// load the HTML Table Class
	    $this->load->library('table');
	    
	    //$list = array('one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve');
	    //$data['new_list'] = $this->table->make_columns($list, 3);

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

		$data['base']=$this->config->item('base_url');
		$data['css']=$this->config->item('css');
	    // load the view
		


		$this->table->set_heading('序号', '例句');
		
		while($row = $data['results']->_fetch_assoc())
            {
                $this->table->add_row(
                $row['id'],
                anchor("http://www.ran.com:8081/index.php/spicontrol/show_comment/".$row['id']."/".$data['DropDownListPsize'], $row['content'])
                //$this->typography->auto_typography($row->item)
                );
         	}
         //$this->table->generate();
        //echo anchor('spicontrol/show_comment/'.$row['id'],'fuck');

        $this->load->view('test_views_two', $data);
		
	}

	function show_comment($weiboid='123',$DropDownListPsize,$page =1)
	{
		$data['DropDownListPsize'] = $DropDownListPsize;
		$comment = $this->spimodel->search_comment($weiboid);
		$data['pageSize'] = $page;

		$this->load->library('pagination');

		$config['base_url'] = site_url().'/spicontrol/show_comment/'.$weiboid.'/'.$DropDownListPsize;
		
 		$limit = $data['DropDownListPsize'];
 		$offset = ($page-1) * $limit + 1;
		$config['total_rows'] = $comment->num_rows();
		$data['totalRows']= $comment->num_rows();
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['per_page'] = $limit;
		$config['next_link'] = '下一页 >'; // 下一页显示   
		$config['prev_link'] = '< 上一页'; // 上一页显示 
	
		$config['cur_tag_open'] = '<b>';
		$config['cur_tag_close'] = '</b>';
		$config['num_links'] = '3';
		$config['uri_segment'] = '5';
		$config['anchor_class'] = "";
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config);

		$data['results'] = $this->spimodel->show($weiboid,$limit,$offset);
		
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
		$data['base']=$this->config->item('base_url');
		$data['css']=$this->config->item('css');
	    // load the view
		$this->table->set_heading('序号', '例句');

		while($row = $data['results']->_fetch_assoc())
            {
                $this->table->add_row(
                $row['id'],
                $row['content']
                //anchor("http://www.ran.com:8081/index.php/spicontrol/show", $row['content'])
                //$this->typography->auto_typography($row->item)
                );
         	}
        //$buffer = $this->load->view('test_views_two',$data, true);

		$this->load->view('test_views_two', $data);

	}

	

}

?>