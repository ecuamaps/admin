<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

	var $title = 'Config';
	var $setup_params = array();
		
	function __construct(){
		parent::__construct();
		
		$this->load->library('grocery_CRUD');
	}
	
	function index(){	
		//$this->grocery_crud->set_theme('datatables');
		
		$this->grocery_crud->set_table('config');
		
		$this->grocery_crud->unset_add();
		$this->grocery_crud->unset_delete();
		
		/* Campos para editar */
		$this->grocery_crud->fields('value');
			
		$this->setup_params['output'] = $this->grocery_crud->render();
  		$this->setup_params['title'] = lang('setup.rooms.title');
  		
		$this->render();
	}
	
	
	function after_update($post_array,$primary_key){
		
		$this->load->model('business');
		
		if($post_array['state'] == 'A'){
			$this->business->syncronize($primary_key);
		}else{
			delete_solr_document($primary_key);
		}
				
		return true;
	}
	
	private function render(){
		
		$this->template->write('title', $this->title);
		
		$this->template->add_js('https://www.google.com/jsapi', 'import', FALSE, FALSE);

		$this->template->write_view('content', 'templates/crud', $this->setup_params, TRUE);
		
		$this->template->render();		
	}
	
	
	
}