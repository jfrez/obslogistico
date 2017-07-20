<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends CI_Controller {

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
	public function index()
	{
		$q = $this->db->query("Show tables")->result_array();
		$tables = Array();
		foreach($q as $t){
			$tname= $t['Tables_in_ObsLogistico'];
			if(strpos($tname,"BASE_")===0){
				$aux=$this->db->query("DESCRIBE $tname;")->result_array();
				$sql = array();
				foreach($aux as $k=> $field){
					$sql[] = "(SELECT count(DISTINCT ".$field['Field'].") FROM $tname) as ".$field['Field'];
					$meta = $this->db->query("Select * from Metadata where tabla = '$tname' and columna = '".$field['Field']."'")->result_array();
					foreach($meta as $m){
					$aux[$k]['meta'] =$m['valor'];
					}
					$field['meta'] ="";
				}
				$select = "select ".implode(", ",$sql);
				$count = $this->db->query($select)->result_array();
					$tablemeta="";	
					$meta = $this->db->query("Select * from Metadata where tabla = '$tname' and columna = ''")->result_array();
					foreach($meta as $m){
					$tablemeta =$m['valor'];
					}
				$tables[$tname] = Array('meta'=>$tablemeta,'desc'=>$aux,'count'=>$count);
				
		}
	}
		$this->load->view('base',Array('tables'=>$tables));
	}	
	public function addMeta()
	{
	$table = $this->input->post('table');
	$col = $this->input->post('col');
	$valor = $this->input->post('valor');
		$sql = "insert into Metadata values( null,'$table','$col','$valor') on duplicate key update valor = '$valor'";
				$res = $this->db->query($sql);
		echo json_encode($res);
		
	}

}
