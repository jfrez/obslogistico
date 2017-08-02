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
		$q1 = $this->db->query("SELECT DISTINCT name from SYS_PREPARATIONS")->result_array();
		$this->load->view('upload',Array('prep'=>$q1));
	}
	public function do_upload()
	{
		$tablename  = $this->input->post('tablename');
		$prepname  = $this->input->post('prepname');
		$prepname=preg_replace("/[^A-Za-z0-9]/", '', $prepname);
		$tablename=$prepname;	
		$steps  = $this->input->post('steps');
		$tablefile  = $this->input->post('tablefile');
		$this->db->query("INSERT INTO SYS_PREPARATIONS (name, code) VALUES('$prepname','$steps') ON DUPLICATE KEY UPDATE  code='$steps'");
		$q1 = $this->db->query("SELECT DISTINCT name from SYS_PREPARATIONS")->result_array();
		$unidades = $this->db->query("Select name from SYS_Unidades")->result_array();
		if(!isset($tablefile)){
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'csv';
			$config['max_size']             = 1000000;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('userfile'))
			{
				$q = $this->db->query("Show tables")->result_array();
				$error = array('tables'=>$q,'error' => $this->upload->display_errors());
				print_r($error);
				$this->load->view('upload', $error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$file= $data['upload_data']['full_path'];

				$this->load->view('preparation',Array('file'=>$file,'tablename'=>$tablename,'unidades'=>$unidades,'preparations'=>$q1,'steps'=>$steps));

			}
		}else{


			$this->load->view('preparation',Array('file'=>$tablefile,'tablename'=>$tablename,'unidades'=>$unidades,'preparations'=>$q1,'steps'=>$steps));
		}
	}
	public function getAtributes(){
		$q = $this->db->query("Select name from SYS_Atributos")->result_array();
		$arr=Array();
		foreach( $q as $a){
			$arr[] = $a['name']; 
		}
		echo json_encode($arr);	
	}
	public function getPreparations(){
		$q = $this->db->query("Select distinct name from SYS_PREPARATIONS")->result_array();
		$arr=Array();
		foreach( $q as $a){
			$arr[] = $a['name']; 
		}
		echo json_encode($arr);	
	}

	public function getPreparationsCode($name){
		$q = $this->db->query("Select code from SYS_PREPARATIONS where name = '$name'")->result_array();
		echo json_encode($q);	
	}
	private function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
	public function getTable($name){
		$q = $this->db->query("Select * from $name ")->result_array();
		$table = Array();
		foreach($q as  $k => $row){
		$table[$k] = Array();
		foreach($row as $field => $v){
		if(!$this->startsWith($field,"SYS")){
			$table[$k][$field] = $v;
		}else{
			if($v!=""){
			$table[$k][$field] = $v;

			}
		}
		}
		}
		echo json_encode($table);
	
	}


}
