<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load->model('Login/Login_Model');
    }
    public function index()
    {
        echo "i am here";
    }
    /**
    
     *Purpose: get Institue login
     * @param  
     * @return Response Array
     * created BY: Nayan Sanadi
     * created on : 19/11/2019
     * modified on :
     */
    public function viewLoginPage()
    {
       $this->load->view("Admin/billingForm");
    }
    public function logout()
    {
        
        $this->load->view('login/login');

    }
	
}