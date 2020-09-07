<?php

////nayan Sanadi developer start Working on time table model
class Customers_Model extends CI_Model {

    function __construct() {
        parent::__construct();
//        $userData = getUserData();
//        $this->UserId = $userData->UserId;
    }

    public function createCustomer() {

        $data = $this->encdec->loadjson();

        $custData = $this->getCustomer(array('vehicle_no' => $data->vehicle_no));

        $custValid = $this->validateCreateCust($data);

        if ($custValid['datavalid']) {
            if (!$custData) {
                $result_array = array(
                    "user_id" => $this->UserId,
                    "first_name" => $data->firstname,
                    "last_name" => $data->lastname,
                    "vehicle_no" => $data->vehicle_no,
                    "mobile_no" => $data->mobile_no
                );

                $flag = 1;
                $message = "Error While Create Customer";

                $this->db->trans_start();
                if ($this->db->insert("mw_customers", $result_array)) {
                    $flag = 0;
                    $message = "Customer created successfully";
                }

                if ($this->db->trans_status() == FALSE) {
                    $this->db->trans_rollback();
                    $resultdata['code'] = 1;
                    $resultdata['result'] = 'Error while Creating customer';
                } else {
                    $this->db->trans_commit();
                    $resultdata['code'] = $flag;
                    $resultdata['result'] = $message;
                }
            } else {
                $resultdata['code'] = 1;
                $resultdata['result'] = "Customer already exit!!!";
            }
        } else {
            $resultdata['code'] = 1;
            $resultdata['result'] = implode("<br/>", $custValid['errors']);
        }
        return $resultdata;
    }

    public function listCustomer() {

        $data = $this->encdec->loadjson();

        $this->db->trans_start();

        $flag = 1;
        $message = "Error While Create Customer";

        $this->db->select('*, cm.id As cust_id, max(invdate) As maxinvdate');
        $this->db->from('mw_customers as cm');
        $this->db->join('mw_service as ms', 'cm.id = ms.c_id', 'left');
        $this->db->where('cm.user_id = ' . $this->UserId);
        $this->db->where('cm.is_active', '1');
        $this->db->order_by('cm.id DESC');
        $this->db->group_by('cm.id');

//        $this->db->get()->result();
//        echo $this->db->last_query();exit;
        return $this->db->get()->result();
    }

    public function getCustomer($params, $excludeId = false) {
        $this->db->trans_start();

        $this->db->select('*');
        foreach ($params AS $pKey => $pVal) {
            $this->db->where($pKey . "='" . $pVal . "'");
        }

        if ($excludeId) {
            $this->db->where("id!='" . $excludeId . "'");
        }

        $this->db->where('is_active', '1');
        $this->db->where('user_id', $this->UserId);

        $this->db->from('mw_customers');
        $custRow = $this->db->get()->row();

        if ($custRow) {
            return $custRow;
        } else {
            return null;
        }
    }

    public function searchCustomer($searchFor) {

        $this->db->trans_start();
        return $this->getCustomer($searchFor);
    }

    public function validateCreateCust($postData) {
        $dataErrors = array();
        if (strlen($postData->vehicle_no) < 5) {
            $dataErrors[] = 'Invalid Vehicle No';
        }
        if (strlen($postData->firstname) < 3) {
            $dataErrors[] = 'Enter valid First Name';
        }
        if (strlen($postData->lastname) < 3) {
            $dataErrors[] = 'Enter valid Last Name';
        }
        if (strlen($postData->mobile_no) < 10) {
            $dataErrors[] = 'Enter valid Mobile No';
        }

        if (count($dataErrors)) {
            return array('datavalid' => false, 'errors' => $dataErrors);
        } else {
            return array('datavalid' => true);
        }
    }

    public function deleteCustomer($customerId) {
        $this->db->set('is_active', '0');
        $this->db->where('id', $customerId);
        $this->db->where('user_id = ' . $this->UserId);
        $this->db->update('mw_customers');

        $resultdata['code'] = 0;
        $resultdata['result'][] = 'Customer deleted successfully';
        
        return $resultdata;
    }

    public function updateCustomer($updateData) {
        $resultdata['code'] = 0;
        $custDtl = $this->getCustomer(array('vehicle_no' => $updateData['vehicle_no']), $updateData['cust_id']);

        if ($custDtl) {
            $resultdata['code'] = 1;
            $resultdata['result'][] = 'Customer already exist';
        } else {
            try {
                $this->db->set('first_name', $updateData['firstname']);
                $this->db->set('last_name', $updateData['lastname']);
                $this->db->set('vehicle_no', $updateData['vehicle_no']);
                $this->db->set('mobile_no', $updateData['mobile_no']);
                $this->db->where('id', $updateData['cust_id']);
                $this->db->where('user_id = ' . $this->UserId);
                $this->db->update('mw_customers');
                $resultdata['result'][] = 'Customer update successfull';
            } catch (Exception $ex) {
                $resultdata['code'] = 1;
                $resultdata['result'][] = 'Customer update fail';
            }
        }

        return $resultdata;
    }

}

?>
