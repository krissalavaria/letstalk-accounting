<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Accounting_logs_services extends MY_Controller {

		private $data = [];
		protected $session;
		public function __construct()
		{
			parent::__construct(); 
			$this->session = (object)get_userdata(USER);
			
			if(is_empty_object($this->session)){
				redirect(base_url().'dashboard/authentication', 'refresh');
			}

		}

		public function index()
		{
			echo 'error';
		}
		
		
	}
?>
