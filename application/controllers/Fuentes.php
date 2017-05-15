<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function tofloat($num) {
	$dotPos = strrpos($num, '.');
	$commaPos = strrpos($num, ',');
	$sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
		((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

	if (!$sep) {
		return floatval(preg_replace("/[^0-9]/", "", $num));
	}

	return floatval(
			preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
			preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
		       );
}

class Fuentes extends CI_Controller {

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
	private function is_date($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	private function periodo($periodo=null,$ano = null){
		if($ano and !$periodo){
			$p=[];
			for($i=1;$i<=12;$i++){
				$inicio = $ano."-".$i."-01";
				$fin = $ano."-".$i."-01";		
				$fin = date("Y-m-t", strtotime($fin) ) ;
				$p[] = [$inicio,$fin,$i,12];		
			}

		}
		if($periodo  and $ano){
			$p=[];
			$q = $this->db->query("Select * from SYS_periodos where upper(periodo) = upper('$periodo')")->result_array();
			foreach($q as $row){
				$inicio = $ano."-".$row['code']."-01";
				$fin = $ano."-".$row['code']."-01";		
				$fin = date("Y-m-t", strtotime($fin) ) ;
				$p[] = [$inicio,$fin,$row['code'],$row['divisor']];		
			}

		}
		return $p;
	}
	public function index()
	{
		$q = $this->db->query("Show tables")->result_array();
		$this->load->view('fuentes',Array('tables'=>$q));
	}
	public function do_upload()
	{
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

			$this->load->view('fuentes', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$tablename = preg_replace ('/[^A-Za-z0-9]/', '', $tablename);
			$sql=	$this->loadcsv($data['upload_data']['full_path'],$tablename);
			if($sql)	
				$this->index();
		}
	}
	private function loadcsv($file,$table){
		$sql="";
		$periodo  = $this->input->post('periodo');
		$periodoInicio  = $this->input->post('periodoInicio');
		$periodoFin  = $this->input->post('periodoFin');
		$datetime  = $this->input->post('datetime');
		$ano  = $this->input->post('ano');
		$periodoano  = $this->input->post('periodoano');
		// get structure from csv and insert db
		ini_set('auto_detect_line_endings',TRUE);
		$handle = fopen($file,'r');
		// first row, structure
		if ( ($data = fgetcsv($handle,0,";") ) === FALSE ) {
			echo "Cannot read from csv $file";die();
		}
		$fields = array();
		$fields[] = "id Integer PRIMARY KEY AUTO_INCREMENT";
		$fieldtypes = array();
		$field_count = 0;
		for($i=0;$i<count($data); $i++) {
			$f = strtolower(trim($data[$i]));
			if ($f) {
				// normalize the field name, strip to 20 chars if too long
				$f = substr(preg_replace ('/[^0-9a-z]/', '_', $f), 0, 20);

				$field_count++;
				$fields[] = $f;
				$fieldtypes[] = " DOUBLE";
				if(strlen($periodoInicio)>0)
					if(strtoupper($periodoInicio)==strtoupper($f))
						$periodoInicio=$i;
				if(strlen($periodoFin)>0)
					if(strtoupper($periodoFin)==strtoupper($f))
						$periodoFin=$i;
				if(strlen($datetime)>0)
					if(strtoupper($datetime)==strtoupper($f))
						$datetime=$i;
				if(strlen($periodo)>0)
					if(strtoupper($periodo)==strtoupper($f))
						$periodo=$i;
				if(strlen($periodoano)>0)
					if(strtoupper($periodoano)==strtoupper($f))
						$periodoano=$i;
			}
		}
		$realfields=Array();
		$sql=Array();
		for($i=1;$i<count($fields); $i++) {
			$realfields[] = $fields[$i];
		}
		while ( ($data = fgetcsv($handle,0,";") ) !== FALSE ) {
			$fieldsi = array();
			for($i=0;$i<$field_count; $i++) {
				$d = tofloat($data[$i]);
				if($d>0)$data[$i] = $d;
				$fieldsi[] = '\''.addslashes($data[$i]).'\'';
				if(is_numeric($data[$i]))
					$fieldtypes[$i] = " DOUBLE ";
				if(!is_numeric($data[$i]))
					$fieldtypes[$i] = " VARCHAR(255) ";
				if($this->is_date($data[$i]))
					$fieldtypes[$i] = " DATETIME ";
			}
			if($periodoInicio>0 and $periodoFin>0) // Dos datetime inicio y fin
				$sql[] = "Insert ignore into  $table values(NULL," . implode(', ', $fieldsi) . ",'".$data[$periodoInicio]."','".$data[$periodoFin]."',MONTH('".$data[$periodoInicio]."'),YEAR('".$data[$periodoInicio]."'),1)";
			if(strlen($datetime)>0)  // un solo datetime
				$sql[] = "Insert ignore into  $table values(NULL," . implode(', ', $fieldsi) . ",'".$data[$datetime]."','".$data[$datetime]."',MONTH('".$data[$periodoInicio]."'),YEAR('".$data[$datetime]."'),1)";
			if(strlen($periodo)>0 and strlen($periodoano)>0){ // periodos en formato: mes, mes1-mes2, año 
				$p = $this->periodo($data[$periodo],$data[$periodoano]);
				foreach($p as $m){
					$sql[] = "Insert ignore into  $table values(NULL," . implode(', ', $fieldsi) . ",'".$m[0]."','".$m[1]."',YEAR('".date($m[0])."'),".$m[2]." ,".$m[3].")";
				}
			}

			if(strlen($periodo)>0 and !strlen($periodoano)>0){ // periodos en formato: mes, mes1-mes2, año 
				$p = $this->periodo($data[$periodo],null);
				print_r($p);		
			}
			if(!strlen($periodo)>0 and strlen($periodoano)>0){ // periodos en formato: mes, mes1-mes2, año 
				$p = $this->periodo(null,$data[$periodoano]);
				foreach($p as $m){
					$sql[] = "Insert ignore into  $table values(NULL," . implode(', ', $fieldsi) . ",'".$m[0]."','".$m[1]."',YEAR('".date($m[0])."'),".$m[2]." ,".$m[3].")";
				}
			}
		}

		for($i =0;$i<count($fieldtypes);$i++){
			$fields[$i+1] .= $fieldtypes[$i];
		}


		$sqlcreate = "CREATE TABLE if not exists $table (" . implode(', ', $fields) . ", SYS_periodoInicio Datetime, SYS_periodoFin Datetime, SYS_ano int,SYS_mes int, SYS_divisor int)";
		if(sizeof($realfields>11)){
			$realfields=array_slice($realfields,0,11);
		}
		$unique = "ALTER TABLE $table ADD UNIQUE (".implode(", ",$realfields).", SYS_periodoInicio , SYS_periodoFin, SYS_ano ,SYS_mes , SYS_divisor )";
		$this->db->query($sqlcreate);
		$this->db->query($unique);
		foreach($sql as $s)
			$this->db->query($s);
		fclose($handle);
		ini_set('auto_detect_line_endings',FALSE);
		return $sql;

	}
}
