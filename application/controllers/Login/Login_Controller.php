<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Controller extends CI_Controller {

    public function __construct() {

        parent::__construct();
        //$this->load->model('Login/Login_Model');
        $this->load->model('Mw_customers_Model');
    }

    public function index() {
        echo "i am here";
    }

    /**

     * Purpose: get Institue login
     * @param  
     * @return Response Array
     * created BY: Nayan Sanadi
     * created on : 19/11/2019
     * modified on :
     */
    public function viewLoginPage() {
        $custData['user_id'] = 1;
        $custData['first_name'] = 'hellosdfksd';
        $custData['last_name'] = 'bsbbbbbbb';
        $custData['vehicle_no'] = 'abcn201547dfks';
        $custData['mobile_no'] = '9865474745';

//        for ($i = 6000; $i < 9000; $i++) {
//            $custData['id'] = $i;
//            $returnData = $this->Mw_customers_Model->createCustomer($custData);
//        }

        $returnData = $this->Mw_customers_Model->listCustomer();
        $cntI = 0;
        
        echo "<div style='height:400px; overflow:scroll'>";
        foreach ($returnData As $rowData) {
            $cntI++;
            echo "<div style='text-align:center'>". $rowData->id . ") " . $rowData->first_name . " " . $rowData->last_name . " " . $rowData->vehicle_no ." " . $rowData->vehicle_no . "<br/></div>";           
        }
        echo "<div style='text-align:center'><b>".count($returnData)."</b></div>";
        echo "</div>";
        
        
        $this->load->view("Admin/billingForm");
    }

    public function logout() {

        $this->load->view('login/login');
    }

}
