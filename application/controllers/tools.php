<?php
class Tools extends CI_Controller {

	public function verify_account_activation(){
		
		$this->load->model('account');
		$days = $this->config_model->get_value('account_activation_days');
		
		$accounts = $this->account->get_pending_to_activate($days);
		if(!$accounts){
			echo 'No accounts to delete'.PHP_EOL;
			return null;	
		}
			
		foreach($accounts as $a){
			if($this->account->delete($a->id))
				echo 'Deleted account ID: '.$a->id.PHP_EOL;
			else
				echo 'Error deleting account ID: '.$a->id.PHP_EOL;
		}
	}
}
?>