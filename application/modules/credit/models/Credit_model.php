<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Credit_model extends CI_Model
    {
        private $table = array(
            'user' => 'user_account',  
            'orderh' => 'orderhead',
            'orderl' => 'orderline',       
            'prod' => 'product',
            'cat' => 'product_category',
            'unit' => 'product_unit',
            'salary' => 'salary_cycle',
            'brgy' => 'barangays',
            'citynum'=> 'city_municipality',
            'province'=> 'province',
            'depart'=> 'department',
            'design' => 'designation',
            'user_type' => 'user_account_type',
            'rate' => 'employee_rate',
            'accounting' => 'accounting_logs'
        );                

        public function __construct()
        {
            parent::__construct(); 
			$this->session = (object)get_userdata(USER);
			
			if(is_empty_object($this->session)){
				redirect(base_url().'dashboard/authentication', 'refresh');
			}
			$model_list = [               
            ];
            $this->load->model($model_list);
        }       
        
    

        public function emp_credit(){

            $fday = (new DateTime('first day of this month'))->format('Y-m-d');
            $lday = (new DateTime('last day of this month'))->format('Y-m-d');

            $this->db->select('
                s.ID,
                u.auth_token,
                u.employee_no,
                u.first_name,
                u.middle_name,
                u.last_name
            ');
            
            $this->db->from($this->table['orderh'].' h');
            $this->db->join($this->table['salary'].' s','h.salary_cycle_id=s.ID','left');
            $this->db->join($this->table['user'].' u','u.ID=h.user_account_id','left');

            $this->db->where('s.is_cleared', 0);
            $this->db->where('h.order_status_id!=', 2);
            $this->db->where('h.order_status_id', 1);
            $this->db->where('s.created_at >=', $fday);
            $this->db->where('s.created_at <=', $lday);
            $this->db->group_by('h.user_account_id');
            $query = $this->db->get()->result();

            foreach($query as $key=>$item){
                $item->total_credit = ($this->total_credit_per_empl($item->ID))->get_total;
            }

            return $query;
        }


        public function total_credit_per_empl($id){
            
            $this->db->select('SUM(l.total_amount) as get_total');

            $this->db->from($this->table['orderh'].' h');
            $this->db->join($this->table['orderl'].' l','l.order_no=h.order_no','left');
            $this->db->where('h.order_status_id!=', 2);
            $this->db->where('h.order_status_id', 1);
            $this->db->where('h.salary_cycle_id', $id);
            

            return $this->db->get()->row();
        }

        public function view_credit($user_token){

            $this->db->select('
            u.*,
            b.desc as brgy,
            cm.citymun_desc as citynum, 
            p.prov_desc as province, 
            de.name as designation,
            d.name as department,
            ut.account_name,
            ');
            $this->db->from($this->table['user'].' u');
            $this->db->join($this->table['brgy'].' b','b.ID=u.barangay_id','left');
            $this->db->join($this->table['citynum'].' cm','cm.ID=u.city_municipality_id','left');
            $this->db->join($this->table['province'].' p','p.ID=u.province_id','left');
            $this->db->join($this->table['design'].' de','de.ID=u.designation_id','left');
            $this->db->join($this->table['depart'].' d','d.ID=u.department_id','left');
            $this->db->join($this->table['user_type'].' ut','ut.ID=u.user_acct_type_id','left');

            $this->db->where('auth_token', $user_token);
            $query = $this->db->get()->row();
            return $query;

        }

        public function credit_per_empl($user_token){

            $fday = (new DateTime('first day of this month'))->format('Y-m-d');
            $lday = (new DateTime('last day of this month'))->format('Y-m-d');

            $this->db->select('
                h.order_no
            ');
            $this->db->from($this->table['orderh'].' h');
            $this->db->join($this->table['salary'].' s','h.salary_cycle_id=s.ID','left');
            $this->db->join($this->table['user'].' u','u.ID=h.user_account_id','left');

            $this->db->where('u.auth_token', $user_token);
            $this->db->where('s.is_cleared', 0);
            $this->db->where('h.order_status_id!=', 2);
            $this->db->where('h.order_status_id', 1);
            $this->db->where('s.created_at >=', $fday);
            $this->db->where('s.created_at <=', $lday);
            $query = $this->db->get()->result();

            foreach($query as $key=>$item){
                $item->total_credit = ($this->get_total_order($item->order_no))->get_total;

            }

            return $query;
            
        }

        public function get_total_order($order_no){
       
            $this->db->select('SUM(l.total_amount) as get_total');

            $this->db->from($this->table['orderh'].' h');
            $this->db->join($this->table['orderl'].' l','l.order_no=h.order_no','left');

            $this->db->where('h.order_no', $order_no);


            return $this->db->get()->row();
        }


        public function clearall(){

            try{
                $fday = (new DateTime('first day of this month'))->format('Y-m-d');
                $lday = (new DateTime('last day of this month'))->format('Y-m-d');

                $this->db->select('ID');
                $this->db->from($this->table['user']);
                $this->db->where('auth_token', $this->user_token);

                $user_id = $this->db->get()->row();

                $this->db->select('ID');
                $this->db->from($this->table['salary']);
                $this->db->where('is_cleared', 0);
                $this->db->where('user_account_id', $user_id->ID);
                $this->db->where('created_at >=', $fday);
                $this->db->where('created_at <=', $lday);

                $cycle_id = $this->db->get()->row();

                $this->db->select('SUM(total_amount) as total_salary');
                $this->db->from($this->table['rate']);
                $this->db->where('salary_cycle_id', $cycle_id->ID);
                $total_salary_cycle = $this->db->get()->row();
                

                $credit = $this->total_credit_per_empl($cycle_id->ID);

                $balance = (float)$total_salary_cycle->total_salary - (float)$credit->get_total;

                $data = array(
                    'user_account_id'=>$user_id->ID,
                    'salary_cycle_id'=>$cycle_id->ID,
                    'total_salary'=>(float)$total_salary_cycle->total_salary,
                    'total_credit'=>(float)$credit->get_total,
                    'user_account_balance'=>$balance,
                    'user_account_incharge_id'=>$this->session->id,
                    'datetime_created' => date('Y-m-d H:i:s')
                );
                $this->db->trans_start();

                $this->db->insert($this->table['accounting'], $data);

                $orderhead = array(
                    'order_status_id' => 4
                );
                $this->db->where('salary_cycle_id', $cycle_id->ID);
                $this->db->update($this->table['orderh'], $orderhead);

                $salary_cycle = array(
                    'is_cleared' => 1
                );

                $this->db->where('ID', $cycle_id->ID);
                $this->db->update($this->table['salary'], $salary_cycle);

                
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    throw new Exception("Error Saving data. Transaction halted.", 1);	
                }else
                {
                    $this->db->trans_commit();
            
                }

                return array('message' => CLEAR_CREDIT, 'has_error' => false);

            }catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }

        }


    

    }
?>