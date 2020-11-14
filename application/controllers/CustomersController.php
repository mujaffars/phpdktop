<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CustomersController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/customers_Model');
    }

    public function indexnew() {
        echo 'here';
        exit;
    }

    public function createcustomer() {
        echo 'HEllo here';
        
    }

}
