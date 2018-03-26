<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}





Class Sales_Controller extends Admin_Controller {
    
    public function __construct(){
        parent::__construct('user_type', 3);
    }
  
}