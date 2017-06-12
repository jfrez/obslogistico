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
	private function periodo($periodo=null,$anno = null){
		$periodo=	preg_replace("/[^A-Za-z0-9 ]/", '', $periodo);

		if($periodo  and $anno){
			$q = $this->db->query("Select * from SYS_periodos where upper(original) = upper('$periodo')")->result_array();
			foreach($q as $row){
				$inicio = $anno."-".$row['inicio']."-01";
				$fin = $anno."-".$row['fin']."-01";		
				$fin = date("Y-m-t", strtotime($fin) ) ;
				$p = Array('inicio'=>$inicio,'fin'=>$fin,'final'=>$row['final'],'print'=>$row['print'],'campo'=>$row['campo']);
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
	public function carga(){
		$myfile = fopen("./uploads/tmpfile.csv", "w") or die("Unable to open file!");
		fwrite($myfile, urldecode($this->input->post('content')));
		fclose($myfile);	
		
		$tablename  = $this->input->post('tablename');
			$sql=	$this->loadcsv("./uploads/tmpfile.csv",$tablename);
	}
	private function loadcsv($file,$table){
		$sql="";
		$periodo  = $this->input->post('periodo');
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


			/* CODIGO MAGICO, AQUI SE ARMA EL INSERT, LEER CON CUIDADO Y MIRANDO LA BASE DE DATOS */
			$SYS= Array( 
					"SYS_MES"=>"''",
					"SYS_TRIMESTRE"=>"''",
					"SYS_TRIMESTRE_MOVIL"=>"''",
					"SYS_SEMESTRE"=>"''",
					"SYS_ANNO"=>"''",
					"SYS_PERIODO_INICIO"=>"''",
					"SYS_PERIODO_FIN"=>"''",
					"SYS_PAIS"=>"''",
					"SYS_REGION"=>"''",
					"SYS_PROVINCIA"=>"''",
					"SYS_COMUNA"=>"''"
				   );
			$PRINT = Array(
					"SYS_MES_PRINT"=>"''",
					"SYS_TRIMESTRE_PRINT"=>"''",
					"SYS_TRIMESTRE_MOVIL_PRINT"=>"''",
					"SYS_PAIS"=>"''",
					"SYS_REGION_PRINT"=>"''",
					"SYS_PROVINCIA_PRINT"=>"''",
					"SYS_COMUNA_PRINT"=>"''"
				      );
			/*

				CASOS:
					1 Solo año: todo
					2 periodo y año: listo
					3 lugar - region: todo
					4 lugar - provincia: todo
					5 lugar - comuna: todo
					6 lugar - pais: todo



			*/

				//CASO POR CASO SE AGREGAN LOS CAMPOS
			if(strlen($periodo)>0 and strlen($periodoano)>0){ // periodos en formato: [mes,trimestres,trimestre movil,semestres X  año] 

				$p = $this->periodo($data[$periodo],$data[$periodoano]); // p contiene inicio,fin,final,print,campo

				$SYS[$p['campo']]="'".$p['final']."'"; //MIRA LA TABLA SYS_periodo
				$PRINT[$p['campo']."_PRINT"]="'".$p['print']."'"; //MIRA LA TABLA SYS_periodo

				$SYS["SYS_ANNO"]=$data[$periodoano];

				$SYS["SYS_PERIODO_INICIO"] = "'".$p['inicio']."'"; 
				$SYS["SYS_PERIODO_FIN"] = "'".$p['fin']."'"; 
			}
			

			$sql[] = "Insert ignore into  $table values(NULL," . implode(', ', $fieldsi) .",".implode(', ',$SYS).",".implode(',',$PRINT).  ")";

		}

		for($i =0;$i<count($fieldtypes);$i++){
			$fields[$i+1] .= $fieldtypes[$i];
		}

		$SYS= Array( 
				"SYS_MES VARCHAR(255)",
				"SYS_TRIMESTRE VARCHAR(255)",
				"SYS_TRIMESTRE_MOVIL VARCHAR(255)",
				"SYS_SEMESTRE VARCHAR(255)",
				"SYS_ANNO VARCHAR(255)",
				"SYS_PERIODO_INICIO DATETIME",
				"SYS_PERIODO_FIN DATETIME",
				"SYS_PAIS VARCHAR(255)",
				"SYS_REGION VARCHAR(255)",
				"SYS_PROVINCIA VARCHAR(255)",
				"SYS_COMUNA VARCHAR(255)"
			   );
		$PRINT = Array(
				"SYS_MES_PRINT VARCHAR(255)",
				"SYS_TRIMESTRE_PRINT VARCHAR(255)",
				"SYS_TRIMESTRE_MOVIL_PRINT VARCHAR(255)",
				"SYS_PAIS_PRINT VARCHAR(255)",
				"SYS_REGION_PRINT VARCHAR(255)",
				"SYS_PROVINCIA_PRINT VARCHAR(255)",
				"SYS_COMUNA_PRINT VARCHAR(255)"
			      );

		$sqlcreate = "CREATE TABLE if not exists $table (" . implode(', ', $fields) . ",".implode(', ',$SYS).",".implode(',',$PRINT)." )";
		if(sizeof($realfields>11)){
			$realfields=array_slice($realfields,0,11);
		}
		$this->db->query("DROP TABLE IF EXISTS $table");
		$this->db->query($sqlcreate);


		//$unique = "ALTER TABLE $table ADD UNIQUE (".implode(", ",$realfields)."," .implode(', ',$SYS).",".implode(',',$PRINT)."  )";
		//$this->db->query($unique);


		foreach($sql as $s)
			$this->db->query($s);
		fclose($handle);
		ini_set('auto_detect_line_endings',FALSE);
		return $sql;

	}
}
