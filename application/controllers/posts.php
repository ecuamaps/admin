<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {

	var $title = 'Posts';
	var $setup_params = array();
		
	function __construct(){
		parent::__construct();
		
		$this->load->library('grocery_CRUD');
	}
	
	function index(){	
		//$this->grocery_crud->set_theme('datatables');
		
		$this->grocery_crud->set_table('post');
		
		$this->grocery_crud->unset_add();
		$this->grocery_crud->unset_delete();
		//$this->grocery_crud->unset_texteditor('notes');
		
		/* Campos de la lista */
		$this->grocery_crud->columns('id','post_type_id','user_id','name','creation','last_update','tags','state');
		
		/* Relacion con otras tablas */
		$this->grocery_crud->set_relation('post_type_id','post_type','name_es');
		$this->grocery_crud->set_relation('user_id','user','name');
		
		/* Campos para editar */
		$this->grocery_crud->fields('user_id', 'state');
		
		//$this->grocery_crud->callback_after_update(array($this, 'after_update'));
			
		$this->setup_params['output'] = $this->grocery_crud->render();
  		$this->setup_params['title'] = lang('setup.rooms.title');
  		
		$this->render();
	}
	
	/*function after_update($post_array,$primary_key){
		
		$this->load->model('business'); 
		$this->load->model('invoice'); 
		
		//Load the invoice
		$invoice = $this->invoice->get_by_id($primary_key);
		$invoice = $invoice[0];
		
		$fp = fopen('/tmp/debug', 'w');
		fwrite($fp, var_export($invoice, true));
		fclose($fp);
		
		if($post_array['state'] == 'paid' && $invoice->activate_biz == '1'){
			$this->business->activate($invoice->post_id);
		}elseif($post_array['state'] != 'paid' && $invoice->activate_biz == '1'){
			$this->business->inactivate($invoice->post_id);
		}
		
		$products = $this->business->get_products_by_invoice($primary_key);
		
		foreach($products as $p){
			if($post_array['state'] == 'paid')
				$this->business->activate_product($p->id);
			else
				$this->business->inactivate_product($p->id);
		}
		
		return true;
	}*/
	
	private function render(){
		
		$this->template->write('title', $this->title);
		
		$this->template->add_js('https://www.google.com/jsapi', 'import', FALSE, FALSE);

		$this->template->write_view('content', 'templates/crud', $this->setup_params, TRUE);
		
		$this->template->render();		
	}
	
	
	
}