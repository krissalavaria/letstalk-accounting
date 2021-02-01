<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Accounting_logs_model extends CI_Model
    {
        private $table = array(
            'user' => 'user_account',  
            'orderh' => 'orderhead',
            'orderl' => 'orderline',       
            'orders' => 'orderstatus',           
            'prod' => 'product',
            'cat' => 'product_category',
            'unit' => 'product_unit',
            'salary' => 'salary_cycle',
            'salary_tyle' => 'salary_type',
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
        
        public function get_confirmed_order(){
            $this->db->select(
                'oh.order_no,
                u.first_name,
                u.last_name
            ');
            $this->db->from($this->table['orderh'].' oh');
            $this->db->join($this->table['user'].' u','u.ID=oh.user_account_id');
            $this->db->where('oh.order_status_id', 1);
            return $this->db->get()->result();
        }

        public function employee(){

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
            
            $query = $this->db->get()->result();
            return $query;

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

            $this->db->where('u.auth_token', $user_token);
            $query = $this->db->get()->row();
            return $query;

        }

        public function transaction_per_cycle($user_token){
            $this->db->select('
            u.auth_token,
            u.first_name,
            s.*,
            st.*,
            s.ID as Cycle_id
            ');
            $this->db->from($this->table['user'].' u');
            $this->db->join($this->table['salary'].' s','u.ID=s.user_account_id','left');
            $this->db->join($this->table['salary_tyle'].' st','st.ID=s.salary_type_id','left');

            $this->db->where('u.auth_token', $user_token);
            $query = $this->db->get()->result();
            return $query;
        }

        public function credit_per_empl($user_token){

   
            $this->db->select('
                u.auth_token,
                h.order_no,
                h.order_date,
                os.order_status
            ');
            $this->db->from($this->table['orderh'].' h');
            $this->db->join($this->table['orders'].' os','h.order_status_id=os.ID','left');
            $this->db->join($this->table['salary'].' s','h.salary_cycle_id=s.ID','left');
            $this->db->join($this->table['user'].' u','u.ID=h.user_account_id','left');

            $this->db->where('u.auth_token', $user_token);
            // $this->db->where('s.is_cleared', 0);
            $this->db->where('h.order_status_id!=', 2);
            // $this->db->where('h.order_status_id', 4);
            $query = $this->db->get()->result();

            foreach($query as $key=>$item){
                $item->total_amount = ($this->get_total_order($item->order_no))->get_total;
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

        public function order_product($orderno){
            $this->db->select(
                '
                h.*,
                l.*,
                l.datetime_created as datetime_order,
                p.*,
                c.*
                '
            );
            $this->db->from($this->table['orderh'].' h');
            $this->db->join($this->table['orderl'].' l','l.order_no=h.order_no','left');
            $this->db->join($this->table['prod'].' p','p.ID=l.product_id');
            $this->db->join($this->table['cat'].' c','c.ID=l.product_category_id');
            $this->db->where('h.order_no', $orderno);
            return $this->db->get()->result();

        }

        public function employee_salary($user_token){
            
            $this->db->select('
            u.employee_no,
            r.*,
            ut.hourly_rate,
            ');
            $this->db->from($this->table['user'].' u');
            $this->db->join($this->table['rate'].' r', 'r.user_account_id=u.ID', 'left');
            $this->db->join($this->table['user_type'].' ut','ut.ID=u.user_acct_type_id','left');
            $this->db->where('u.auth_token', $user_token);
            $this->db->where('r.ID!=', NULL);
            return $this->db->get()->result();

        }

        public function rollback(){

            try{

                $this->db->trans_start();

                $data = array(
                    'is_cleared'=> 0
                );

                $this->db->select('*');
                $this->db->where('ID', (int)$this->cycle_id);
                $this->db->update($this->table['salary'], $data);

                $data = array(
                    'order_status_id'=> 1
                );

                $this->db->select('*');
                $this->db->where('salary_cycle_id', (int)$this->cycle_id);
                $this->db->update($this->table['orderh'], $data);
                
                
                $this->db->where('salary_cycle_id', (int)$this->cycle_id);
                $this->db->delete($this->table['accounting']);
   
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    throw new Exception("Error Saving data. Transaction halted.", 1);	
                }else
                {
                    $this->db->trans_commit();
                }

                return array('message' => ROLL_BACK, 'has_error' => false);


            }catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }

        }
        

    }
?>