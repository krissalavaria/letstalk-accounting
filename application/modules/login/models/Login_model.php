<?php

class Login_model extends CI_Model
{
    public $Username;
    public $Password;

    private $table = [
        'this' => 'user_account',        
        'city' => 'city_municipality',
        'prov' => 'province'        
    ];

    public function __construct()
	{
        parent::__construct();
        $model_list = [
          
        ];
        $this->load->model($model_list);
    }

    public function authentication(){ 
       
        try{            

            if(empty($this->username) || empty($this->password)){
				throw new Exception(REQUIRED_FIELD);
            }
            $from = 'admin';
            $this->db->select(
                'e.*, '.                 
                'c.citymun_desc as city, '.
                'pr.prov_desc as province, '.
                'pr.prov_code'                
            );
            $this->db->from($this->table['this'].' e');
            $this->db->join($this->table['city'].' c', 'c.ID = e.city_municipality_id', 'left');
            $this->db->join($this->table['prov'].' pr', 'pr.ID = e.province_id', 'left');                            
            $this->db->where('e.designation_id ', 3);
            $this->db->where('e.username', $this->username);
            $estabQuery = $this->db->get()->row();            
                                  
            /**check password */
            /**generate password from input */
            // if(!empty($estabQuery)){
            //     if($estabQuery->password !== sha1(password_generator($this->password,$estabQuery->locker)) ){
            //         throw new Exception(NOT_MATCH, true);
            //     }

            //     /**set user session */            
            //     set_userdata(USER,(array)$estabQuery);

            //     return array('has_error' => false, 'message' => 'Login Success');
            // }else{
            //     return array('has_error'=>true, 'error_message'=>'No existing account');
            // }         
            
             if(!empty($estabQuery)){
                if(!(password_verify_laravel($this->password,$estabQuery->password))){
                    throw new Exception(NOT_MATCH, true);
                } 

                /**set user session */            
                set_userdata(USER,(array)$estabQuery);

                return array('has_error' => false, 'message' => 'Login Success');
            }else{
                return array('has_error'=>true, 'error_message'=>'No existing account');
            }       
        }   
        catch(Exception $ex){			
            return array('error_message' => $ex->getMessage(), 'has_error' => true);
		}
        
    }




}
?>