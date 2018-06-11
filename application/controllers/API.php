<?php
/**  
 * @category Controller
 * @author Phia Thao
 * @version 1.0
 * 
 * Description: This is a simple API class for patient model.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."/libraries/Format.php");
require_once(APPPATH."/libraries/REST_Controller.php");

class API extends \Restserver\Libraries\REST_Controller { 
    
    public function __construct(){
        parent::__construct(); 
        $this->load->model('PatientModel');  
    }
    
    /***
     * @return void
     */
    public function patients_get(){
        $accountId = $this->uri->segment(3); //Get ID from the third url 
        $records = $this->PatientModel->getRecords($accountId);
        if(count($records)>0){
             $this->response($records); 
        }
        $this->response('No records found!');  
    }
    
    /***
     * @return void
     * 
     * NOTE: I don't think this is work!... Somehow when sending from postman 
     *      the body data is not getting through.
     *      From googling, it might have something to do with PHP 7. 
     */
    public function patient_put(){  
        $id = $this->uri->segment(3);   //Get ID from the third url   
        $data = array('full_name' => $this->input->get('full_name'),
            'age' => $this->input->get('age'), 
            'gender' => $this->input->get('gender') 
        );
        print_r($this->input->get());
        $r = $this->PatientModel->update($data, $id);
        $this->response($r); 
    }
 
    /***
     * @return void
     */
    public function patient_post(){
        $data = array('account_id'=> $this->input->post('account_id'),
            'full_name' => $this->input->post('full_name'),
             'age' => $this->input->post('age'), 
             'gender' => $this->input->post('gender') 
         ); 
        $r = $this->PatientModel->insert($data, $id);
        $this->response($r); 
    }
     
    /***
     * @return void
     */
    public function patient_delete(){
        $id = $this->uri->segment(3);   //Get ID from the third url 
        $r = $this->PatientModel->delete($id);
        $this->response($r); 
    }
}