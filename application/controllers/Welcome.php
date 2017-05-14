<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->load->view('dashboard');
	}
	

	
	private function load($file){
		$table = 'table_name';

		// get structure from csv and insert db
		ini_set('auto_detect_line_endings',TRUE);
		$handle = fopen($file,'r');
		// first row, structure
		if ( ($data = fgetcsv($handle,0,";") ) === FALSE ) {
			echo "Cannot read from csv $file";die();
		}
		$fields = array();
		$field_count = 0;
		for($i=0;$i<count($data); $i++) {
			$f = strtolower(trim($data[$i]));
			if ($f) {
				// normalize the field name, strip to 20 chars if too long
				$f = substr(preg_replace ('/[^0-9a-z]/', '_', $f), 0, 20);
				$field_count++;
				$fields[] = $f.' VARCHAR(50)';
			}
		}

		$sql = "CREATE TABLE $table (" . implode(', ', $fields) . ')';
		echo $sql . "<br /><br />";
		// $db->query($sql);
		while ( ($data = fgetcsv($handle) ) !== FALSE ) {
			$fields = array();
			for($i=0;$i<$field_count; $i++) {
				$fields[] = '\''.addslashes($data[$i]).'\'';
			}
			$sql = "Insert into $table values(" . implode(', ', $fields) . ')';
			echo $sql; 
			// $db->query($sql);
		}
		fclose($handle);
		ini_set('auto_detect_line_endings',FALSE);

	}
}
