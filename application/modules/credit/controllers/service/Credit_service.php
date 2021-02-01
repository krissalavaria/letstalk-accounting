<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Credit_service extends MY_Controller {

		private $data = [];
		protected $session;
		public function __construct()
		{
			parent::__construct(); 
			$this->session = (object)get_userdata(USER);
			
			if(is_empty_object($this->session)){
				redirect(base_url().'dashboard/authentication', 'refresh');
			}

			$model_list = [
				'order_menu/Order_menu_model' => 'omodel'			
			];
			$this->load->model($model_list);

		}

		public function index()
		{
			echo 'error';
		}


		public function by_category(){
			$this->omodel->category_id = $this->input->post('category_id');
			
			$response = $this->omodel->by_category();

			echo json_encode($response);
		}

		
		
	}
?>
