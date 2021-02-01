<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit extends MY_Controller {
	

	private $data = [];
	protected $session;
    public function __construct()
	{
		parent::__construct(); 
		$this->session = (object)get_userdata(USER);
		
		if(is_empty_object($this->session)){
			redirect(base_url().'login/authentication', 'refresh');
		}

		$model_list = [
			'credit/Credit_model' => 'cmodel'			
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		$this->data['session'] =  $this->session;	    
		$this->data['credit_emp'] = $this->cmodel->emp_credit();  
		$this->data['content'] = 'index';
		$this->load->view('layout',$this->data);
	}	

	public function empl_credit(){
	   
		$this->data['credit_emp'] = $this->cmodel->emp_credit();  
		$this->data['content'] = 'grid/employee_grid';
		$this->load->view('layout',$this->data);
		
	}
	
	public function view(){
		$this->data['user_details'] = $this->cmodel->view_credit($this->input->get('token'));
		$this->data['content'] = 'view';
		$this->load->view('layout',$this->data);   	
	}

	public function orderlist(){
		$data = @$this->cmodel->credit_per_empl($this->input->post('token'));
		$this->data['token'] = $this->input->post('token');
		$this->data['data'] = $data;
		$this->data['content'] = 'grid/order_list';
		$this->load->view('layout',$this->data);
	}

	public function clearall(){
		
		$this->cmodel->user_token = $this->input->post('token');
		$data = $this->cmodel->clearall(); 
		echo json_encode($data);
	}

	public function open_order(){
		
	}

}
