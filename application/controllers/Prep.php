<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prep extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
	public function index()
	{
		$this->load->view('upload');
	}
	public function do_upload()
	{
		$tablename  = $this->input->post('tablename');
		$tablefile  = $this->input->post('tablefile');
		if(!isset($tablefile)){
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'csv';
		$config['max_size']             = 1000000;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload', $config);
		$tablename  = $this->input->post('tablename');
		if ( ! $this->upload->do_upload('userfile'))
		{
			$q = $this->db->query("Show tables")->result_array();
			$error = array('tables'=>$q,'error' => $this->upload->display_errors());

			$this->load->view('upload', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file= $data['upload_data']['full_path'];
		$this->load->view('preparation',Array('file'=>$file,'tablename'=>$tablename));
			
		}
		}else{


		$this->load->view('preparation',Array('file'=>$tablefile,'tablename'=>$tablename));
		}
	}
}
