<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	

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
			'dashboard/Dashboard_model' => 'dModel'			
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		$this->data['session'] =  $this->session;	  
		$this->data['content'] = 'index';
		$this->load->view('layout',$this->data);
	}	

	public function employee(){
		$this->data['data'] = $this->dModel->employee();	
		$this->data['content'] = 'grid/employee';
		$this->load->view('layout',$this->data);
	}

	public function open_employee(){
		$this->data['user_details'] = $this->dModel->view_credit($this->input->get('token'));
		$this->data['content'] = 'view';
		$this->load->view('layout',$this->data);   	
	}

	public function transaction(){

		$this->data['user_details'] = $this->dModel->view_credit($this->input->get('token'));
		$this->data['content'] = 'transaction';
		$this->load->view('layout',$this->data);   	
	}
	
	public function list_transaction(){
	
		$this->data['data'] = $this->dModel->transaction_per_cycle($this->input->post('token'));
		$this->data['content'] = 'grid/list_cycle';
		$this->load->view('layout',$this->data);   	

	}

	public function orderlist(){
		$this->data['data'] = $this->dModel->credit_per_empl($this->input->post('token'));
		$this->data['content'] = 'grid/list_order';
		$this->load->view('layout',$this->data);
	}

	public function order(){
		$this->data['user_details'] = $this->dModel->view_credit($this->input->get('token'));
		$this->data['content'] = 'order';
		$this->load->view('layout',$this->data);   	
	}

	public function orderlistproduct(){

		$this->data['data'] = $this->dModel->order_product($this->input->post('orderno'));
		$this->data['content'] = 'grid/list_order_products';
		$this->load->view('layout',$this->data);

	}

	public function employee_salary(){
		$this->data['data'] = $this->dModel->employee_salary($this->input->post('token'));
		$this->data['content'] = 'grid/employee_salary';
		$this->load->view('layout',$this->data);
		// var_dump($this->data['data']);
	}

}
