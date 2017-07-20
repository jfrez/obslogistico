<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function tofloat($num) {
	$dotPos = strrpos($num, '.');
	$commaPos = strrpos($num, ',');
	$sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
		((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

	if (!$sep) {
		return floatval(preg_replace("/[^\d-]+/", "", $num));
	}

	return floatval(
			preg_replace("/[^\d-]+/", "", substr($num, 0, $sep)) . '.' .
			preg_replace("/[^\d-]+/", "", substr($num, $sep+1, strlen($num)))
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
	private function region($region){
		$region=	preg_replace("/[^A-Za-z0-9 ]/", '', $region);
		$q = $this->db->query("Select SYS_REGION.original,SYS_REGION.final,SYS_geografico.SYS_REGION_PRINT  as print from SYS_REGION,SYS_geografico where SYS_REGION.final = SYS_geografico.SYS_REGION and SYS_REGION.original = '$region'")->result_array();
		$row = $q[0];
		return $row; 	
	}
	private function provincia($provincia){
		$provincia=	preg_replace("/[^A-Za-z0-9 ]/", '', $provincia);
		$q = $this->db->query("Select SYS_PROVINCIA.original,SYS_PROVINCIA.final,SYS_geografico.SYS_PROVINCIA_PRINT  as print from SYS_PROVINCIA,SYS_geografico where SYS_PROVINCIA.final = SYS_geografico.SYS_PROVINCIA and SYS_PROVINCIA.original = '$provincia'")->result_array();
		$row = $q[0];
		return $row; 	
	}
	private function comuna($comuna){
		$comuna=	preg_replace("/[^A-Za-z0-9 ]/", '', $comuna);
		$q = $this->db->query("Select SYS_COMUNA.original,SYS_COMUNA.final,SYS_geografico.SYS_COMUNA_PRINT  as print from SYS_COMUNA,SYS_geografico where SYS_COMUNA.final = SYS_geografico.SYS_COMUNA and SYS_COMUNA.original = '$comuna'")->result_array();
		$row = $q[0];
		return $row; 	
	}


	private function periodo($periodo=null,$anno = null){
		//$periodo=	preg_replace("/[^A-Za-z0-9 ]/", '', $periodo);
		$p = Array();
		if($periodo  and $anno){
			$q = $this->db->query("Select * from SYS_periodos where upper(original) = upper('$periodo')")->result_array();
			foreach($q as $row){
				$inicio = $anno."-".$row['inicio']."-01";
				if($row['fin']<$row['inicio'])$anno++;
				$fin = $anno."-".$row['fin']."-01";		
				$fin = date("Y-m-t", strtotime($fin) );
				$p[] = Array('inicio'=>$inicio,'fin'=>$fin,'final'=>$row['final'],'print'=>$row['print'],'campo'=>$row['campo']);
			}

		}
		if($anno and  !$periodo){
			$inicio = $anno."-01-01";
			$fin = $anno."-01-31";		
			$p = Array('inicio'=>$inicio,'fin'=>$fin,'final'=>$anno,'print'=>$anno,'campo'=>"SYS_ANNO");
		}
		return $p;
	}
	public function index()
	{
		$q = $this->db->query("Show tables")->result_array();
		$this->load->view('fuentes',Array('tables'=>$q));
	}
	public function tmptable($table)
	{
		$data = $this->db->query("select * from $table")->result_array();
		$columns = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'$table'")->result_array();
		$this->load->view('tabla',Array('table'=>$data,'cols'=>$columns));
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
		$columna  = $this->input->post('columna');
		$sql=	$this->loadcsv("./uploads/tmpfile.csv",$tablename,$columna);
	}
	private function loadcsv($file,$table,$columna){
		$sql="";
		$periodoi =null;
		$periodoanoi=null;
		$regioni=null;
		$provinciai=null;
		$comunai=null;
		$region="region";
		$provincia="provincia";
		$comuna="comuna";
		$periodo  = "periodo";
		$datetime  = $this->input->post('datetime');
		$periodoano  ="anno";;
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
						$periodoi=$i;
				if(strlen($periodoano)>0)
					if(strtoupper($periodoano)==strtoupper($f))
						$periodoanoi=$i;
				if(strlen($region)>0)
					if(strtoupper($region)==strtoupper($f))
						$regioni=$i;
				if(strlen($provincia)>0)
					if(strtoupper($provincia)==strtoupper($f))
						$provinciai=$i;
				if(strlen($comuna)>0)
					if(strtoupper($comuna)==strtoupper($f))
						$comunai=$i;
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
				if($data[$i]==""){
					$fieldsi[] ="NULL";
				}else{
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
					"SYS_PAIS_PRINT"=>"''",
					"SYS_REGION_PRINT"=>"''",
					"SYS_PROVINCIA_PRINT"=>"''",
					"SYS_COMUNA_PRINT"=>"''",
					"SYS_ANNO_PRINT"=>"''"
				      );
			/*

CASOS:
1 Solo año: listo
2 periodo y año: listo
3 lugar - region: listo
4 lugar - provincia: listo
5 lugar - comuna: listo
6 lugar - pais: todo


			 */
			//CASO POR CASO SE AGREGAN LOS CAMPOS
			if($periodoi!=null and $periodoanoi!==null and array_key_exists($periodoi,$data)){ // periodos en formato: [mes,trimestres,trimestre movil,semestres X  año] 
				echo "ANNO Y PERIODO";			
				$per = $this->periodo($data[$periodoi],$data[$periodoanoi]); // p contiene inicio,fin,final,print,campo

				foreach($per as $p){
					$SYS[$p['campo']]="'".$p['final']."'"; //MIRA LA TABLA SYS_periodo
					$PRINT[$p['campo']."_PRINT"]="'".$p['print']."'"; //MIRA LA TABLA SYS_periodo

					$SYS["SYS_ANNO"]=$data[$periodoanoi];
					$PRINT["SYS_ANNO_PRINT"]=$data[$periodoanoi];

					$SYS["SYS_PERIODO_INICIO"] = "'".$p['inicio']."'"; 
					$SYS["SYS_PERIODO_FIN"] = "'".$p['fin']."'"; 
				}
			}else if( $periodoanoi!==null and  $periodoi===null){
				$p = $this->periodo(null,$data[$periodoanoi]); // p contiene inicio,fin,final,print,campo
				$SYS[$p['campo']]="'".$p['final']."'"; //MIRA LA TABLA SYS_periodo
				$PRINT[$p['campo']."_PRINT"]="'".$p['print']."'"; //MIRA LA TABLA SYS_periodo
				$SYS["SYS_ANNO"]=$data[$periodoanoi];
				$PRINT["SYS_ANNO_PRINT"]=$data[$periodoanoi];
				$SYS["SYS_PERIODO_INICIO"] = "'".$p['inicio']."'"; 
				$SYS["SYS_PERIODO_FIN"] = "'".$p['fin']."'"; 
			}
			if($regioni){
				$p = $this->region($data[$regioni]);
				$SYS["SYS_REGION"] = "'".$p['final']."'"; 
				$PRINT["SYS_REGION_PRINT"] = "'".$p['print']."'"; 
			}
			if($provinciai){
				$p = $this->provincia($data[$provinciai]);
				$SYS["SYS_PROVINCIA"] = "'".$p['final']."'"; 
				$PRINT["SYS_PROVINCIA_PRINT"] = "'".$p['print']."'"; 
			}
			if($comunai){
				$p = $this->comuna($data[$comunai]);
				$SYS["SYS_COMUNA"] = "'".$p['final']."'"; 
				$PRINT["SYS_COMUNA_PRINT"] = "'".$p['print']."'"; 
			}
			$updates=array();
			for($i=1;$i<count($fields)-1;$i++){
				array_push($updates,$fields[$i]." = ".$fieldsi[$i-1]."");
			}
			$duplicate = "ON DUPLICATE KEY UPDATE ".implode(', ',$updates);

			if(strlen($columna)>0){
				foreach($fieldsi as $k =>$value){
					
					$colname = $realfields[$k];
					echo $colname;
					if(!in_array($colname,array("anno","periodo","lat","lng","lugar","region","comuna","provincia"))){
							$duplicate = "ON DUPLICATE KEY UPDATE value = $value";
							$sql[] = "Insert ignore into  $table values(NULL,'$colname',$value,".implode(', ',$SYS).",".implode(',',$PRINT).  ")  ".$duplicate;
							}
							}
					echo "<br>";
							}else{
							$sql[] = "Insert ignore into  $table values(NULL," . implode(', ', $fieldsi) .",".implode(', ',$SYS).",".implode(',',$PRINT).  ")  ".$duplicate;
							}
							}

							for($i =0;$i<count($fieldtypes);$i++){
							$fields[$i+1] .= $fieldtypes[$i];
							}

							$KEY= Array(
								"SYS_MES ",
								"SYS_TRIMESTRE ",
								"SYS_TRIMESTRE_MOVIL ",
								"SYS_SEMESTRE ",
								"SYS_ANNO ",
								"SYS_REGION ",
								"SYS_PROVINCIA ",
								"SYS_COMUNA "
								);

							$SYS= Array( 
									"SYS_MES VARCHAR(50)",
									"SYS_TRIMESTRE VARCHAR(50)",
									"SYS_TRIMESTRE_MOVIL VARCHAR(50)",
									"SYS_SEMESTRE VARCHAR(50)",
									"SYS_ANNO VARCHAR(5)",
									"SYS_PERIODO_INICIO DATE",
									"SYS_PERIODO_FIN DATE",
									"SYS_PAIS VARCHAR(50)",
									"SYS_REGION VARCHAR(50)",
									"SYS_PROVINCIA VARCHAR(50)",
									"SYS_COMUNA VARCHAR(50)"
								   );
							$PRINT = Array(
									"SYS_MES_PRINT VARCHAR(255)",
									"SYS_TRIMESTRE_PRINT VARCHAR(255)",
									"SYS_TRIMESTRE_MOVIL_PRINT VARCHAR(255)",
									"SYS_PAIS_PRINT VARCHAR(255)",
									"SYS_REGION_PRINT VARCHAR(255)",
									"SYS_PROVINCIA_PRINT VARCHAR(255)",
									"SYS_COMUNA_PRINT VARCHAR(255)",
									"SYS_ANNO_PRINT VARCHAR(255)"
								      );
							if(strlen($columna)>0){
								$sqlcreate = "CREATE TABLE if not exists $table (id Integer PRIMARY KEY AUTO_INCREMENT,$columna VARCHAR(50),value DOUBLE,".implode(', ',$SYS).",".implode(',',$PRINT)." )";
							}else{
								$sqlcreate = "CREATE TABLE if not exists $table (" . implode(', ', $fields) . ",".implode(', ',$SYS).",".implode(',',$PRINT)." )";
							}
							if(sizeof($realfields>11)){
								$realfields=array_slice($realfields,0,11);
							}
							//$this->db->query("DROP TABLE IF EXISTS $table");
							$this->db->query($sqlcreate);


							if(strlen($columna)>0){
							$unique = "ALTER TABLE $table ADD UNIQUE ($columna,".implode(', ',$KEY)."  )";

							}else{
							$unique = "ALTER TABLE $table ADD UNIQUE (".implode(', ',$KEY)."  )";
							}
							$this->db->query($unique);


							foreach($sql as $s)
								$this->db->query($s);
							fclose($handle);
							ini_set('auto_detect_line_endings',FALSE);
							return $sql;

	}
}
