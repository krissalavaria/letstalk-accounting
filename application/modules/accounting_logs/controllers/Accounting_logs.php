<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting_logs extends MY_Controller {
	

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
			'accounting_logs/Accounting_logs_model' => 'aModel'			
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
		$this->data['data'] = $this->aModel->employee();	
		$this->data['content'] = 'grid/employee';
		$this->load->view('layout',$this->data);
	}

	public function open_employee(){
		$this->data['user_details'] = $this->aModel->view_credit($this->input->get('token'));
		$this->data['content'] = 'view';
		$this->load->view('layout',$this->data);   	
	}

	public function list_transaction(){
	
		$this->data['data'] = $this->aModel->transaction_per_cycle($this->input->post('token'));
		$this->data['content'] = 'grid/list_cycle';
		$this->load->view('layout',$this->data);   	

	}

	public function transaction(){

		$this->data['user_details'] = $this->aModel->view_credit($this->input->get('token'));
		$this->data['content'] = 'transaction';
		$this->load->view('layout',$this->data);   	
	}

	public function orderlist(){
		$this->data['data'] = $this->aModel->credit_per_empl($this->input->post('token'));
		$this->data['content'] = 'grid/list_order';
		$this->load->view('layout',$this->data);
	}

	public function roll_back(){

		$this->aModel->cycle_id = $this->input->post('cycle_id');
		$data = $this->aModel->rollback(); 
		echo json_encode($data);
	}


}
