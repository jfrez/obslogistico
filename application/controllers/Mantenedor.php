<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mantenedor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',(array)$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function periodo()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_periodos');
			$crud->set_subject('Periodos');
			$crud->required_fields('id');
			$crud->columns('original','final','print','inicio','fin','campo');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function comuna()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_COMUNA');
			$crud->set_subject('Comuna');
			$crud->required_fields('id');
			$crud->columns('original','final');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function provincia()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_PROVINCIA');
			$crud->set_subject('Provincia');
			$crud->required_fields('id');
			$crud->columns('original','final');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function region()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_REGION');
			$crud->set_subject('Region');
			$crud->required_fields('id');
			$crud->columns('original','final');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function pais()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_PAIS');
			$crud->set_subject('Pais');
			$crud->required_fields('id');
			$crud->columns('original','final');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}



	public function atributo()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_Atributos');
			$crud->set_subject('Atributo');
			$crud->required_fields('id');
			$crud->columns('name');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}


	public function unidad()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_Unidades');
			$crud->set_subject('Unidad');
			$crud->required_fields('id');
			$crud->columns('name');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function Preparation()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_PREPARATIONS');
			$crud->set_subject('Preparacion');
			$crud->required_fields('id');
			$crud->columns('name','code');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function Lugar()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_lugar');
			$crud->set_subject('Lugar');
			$crud->required_fields('id');
			$crud->columns('original','final','tipo','print');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function LugarCoords()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('SYS_LUGAR_COORDS');
			$crud->set_subject('Lugar');
			$crud->required_fields('id');
			$crud->columns('SYS_LUGAR','SYS_LAT','SYS_LNG');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}






}
