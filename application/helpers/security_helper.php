<?php
date_default_timezone_set("Asia/Manila");
function locker($length=50)
{
    $result = "";
    $chars = CHAR_SET;
    $charArray = str_split($chars);
    
    for($i = 0; $i < $length; $i++)
    {
	    $randItem = array_rand($charArray);
	    $result .= "".$charArray[$randItem];
    }
    
    return $result;
}

function auth_token($id = 1, $length = 50)
{
    
    $bytes = random_bytes(ceil($length / 2));
    $random = substr(bin2hex($bytes), 0, $length);
    $auth = (sha1($random. date('y-m-d:h:i:s').$random. date('y-m-d:h:i:s')).':'.sha1(date('y-m-d:h:i:s')).':'.sha1($random)).$id;
    
    return $auth;
}

function auth_token_product($length = 10)
{
    
    $bytes = random_bytes(ceil($length / 2));
    $random = substr(bin2hex($bytes), 0, $length);
    $auth = sha1($random. date('y-m-d:h:i:s'));
    
    return $auth;
}
function password_generator($password,$locker,$length=100){
    $result = "";    
    
    for($i = 0; $i < $length; $i++)
    {	    
	    $result .= "".strrev($password).$locker;
    }
    
    return $result;
}

function password_verify_laravel($plain_text, $hash){
    if (password_verify($plain_text, $hash)) {
        return true;
    } else {
        return false;
    }
}

function check_user_info(){
    if(empty($_SESSION[USER])){
        redirect(base_url().'login');
    }
}
function reset_session(){
    unset($_SESSION[USER]);
}

function check_permission($position='',$condition=[]){
    if (in_array($position, $condition))
        return true;
    return false;
}

function unit_permission($condition='', $values){    
    switch ($condition) {
        case 'lgu':
            return (bool) $values->city_id && (bool) $values->province_id && (bool) $values->region_id; 
            break;
        case 'provincial':
            return  !((bool) $values->city_id) && $values->province_id && (bool) $values->region_id; 
            break;
        case 'regional':
            return  !((bool) $values->city_id) && !((bool) $values->province_id) &&  (bool) $values->region_id; 
            break;
        default:
            return false;
            break;
    }
}

function id_code($brgy='',$no=''){
    // $brgy = 'San Vicente (Pob.)';
    $str = str_replace(' ','',$brgy);
    $trim = strtok($str, '(');
    $trim = preg_replace('/ -]/','',$trim);
    
    $brgy = $trim;
    
    if (strpos(strtolower(@$brgy), 'barangay') !== false) {
        // $brgy_no = filter_var($brgy, FILTER_SANITIZE_NUMBER_INT);
        $result = strtoupper(explode('barangay', strtolower($brgy), 2)[1]);
         
        $data = 'BRGY'.@$result.'-'.$no;
    }else{
        
        // $data  = strtoupper(@$brgy[0].substr(@$brgy, -3, 1).substr(@$brgy, -1)).'-'.$no;
        $data = strtoupper(substr($brgy, 0, 3)).'-'.$no;
    }

    return $data;
}