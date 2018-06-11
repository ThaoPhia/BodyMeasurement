<?php
/**  
 * @category Controller
 * @author Phia Thao
 * @version 1.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
    private $_CI;
    
    public function __construct()
    {
        parent::__construct();

        $this->_CI =& get_instance();
        
        $this->load->library('authit');
        $this->load->helper('authit');
        $this->config->load('authit');
                
        $this->load->helper('url');

        $this->_init();
    }

    private function _init()
    {
        $this->output->set_template('bm'); 
        //$this->load->js('_assets/themes/default/js/jquery-1.9.1.min.js'); 
    }

    /***
     * Landing/login page 
     */
    public function index()
    { 
        if(logged_in()) redirect('account/home');
		 
        $data=["bannerText"=>"Welcome, Please Login.", "pageUrl"=>"", "pageName"=>"", "error"=>false];
        
        $this->load->library('form_validation');
        $this->load->helper('form'); 

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
 
        if($this->form_validation->run()){
            //exit(set_value('email')." // ".md5(set_value('password')));
            if($this->authit->login(set_value('email'), md5(set_value('password')))){ 
                redirect('account/home');// Redirect to your logged in landing page here
            } else {
                $data['error'] = 'Your email address and/or password is incorrect.';
            }
        } 
         
        $this->load->view('login', $data); 
    } 
    
    /***
     * account/logout
     */
    public function logout(){
        if(!logged_in()) redirect('/');

        // Redirect to your logged out landing page here
        $this->authit->logout('/');
    }
    
    /***
     * account/home
     */
    public function home()
    {
        if(!logged_in()) redirect();
        
        $data=["bannerText"=> "WELCOME BACK ".strtoupper(user("fname"))."! ", "pageUrl"=>"home", "pageName"=>"My Account"];
        $this->load->view('account', $data);
    } 
    
    /***
     * account/patients 
     */
    public function patients()
    {
        if(!logged_in()) redirect();
        
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js');
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-messages.js');
        $this->load->js('_assets/js/patient.js'); //Load in js file for patients page
        
        $this->_CI->load->model('PatientModel');
        //$this->_CI->PatientModel->getRecords(2);
         
        $data=["bannerText"=>"Patients", "pageUrl"=>"patients", "pageName"=>"Patients"];
        $this->load->view('patients', $data);
    } 
    
    /***
     * account/addPatient 
     */
    public function addPatient()
    {
        if(!logged_in()) redirect();
        
        $data=["bannerText"=>"Add Patient", "pageUrl"=>"addPatient", "pageName"=>"Add Patient"];
        $data["error"]=false;
        $this->load->view('formPatient', $data);
    } 
    
    /***
     * account/editPatient
     */
    public function editPatient($id="")
    {
        if(!logged_in() || !is_numeric($id)) redirect();
        
        $data=["bannerText"=>"Edit Patient", "pageUrl"=>"editPatient", "pageName"=>"Edit Patient"];
        $this->load->view('formPatient', $data);
    } 
    
    /***
     * account/measurements 
     */
    public function measurements()
    {
        if(!logged_in()) redirect();
        //AngularJS    
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js');
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-messages.js'); 
        //Colorbox 
        $this->load->css('_assets/plugins/colorbox/colorbox.css'); 
        $this->load->js('_assets/plugins/colorbox/jquery.colorbox.js'); 
        
        //My js helpers 
        $this->load->js('_assets/js/helpers.js'); 
        $this->load->js('_assets/js/measurement.js'); 
        
        $this->_CI->load->model('PatientModel'); 
        $this->_CI->load->model('MeasurementModel');
        $error='';  
        
        $data=["bannerText"=>"Body Measurements", "pageUrl"=>"measurements", "pageName"=>"Measurements"];
        $data["error"]=$error;
        $data["patients"]= $this->_CI->PatientModel->getRecords(user("id"), "full_name"); 
            
        $this->load->view('measurements', $data);
    } 
    
    public function measurementDetails($patientId=0){ 
        $this->output->unset_template();
        $this->output->set_template("basic");
        $this->load->js('https://www.gstatic.com/charts/loader.js');

        $data=[];
        if(logged_in() && !empty($patientId) && $patientId>0){ 
            $data["patientId"]=$patientId;
            $this->load->view('detailsBM', $data);
        }else if(!logged_in()){
            echo 'Your login has expired!';
        }else{
            echo 'Invalid data!';
        }  
    }
    
    /***
     * account/addMeasurement 
     */
    public function addMeasurement()
    {
        if(!logged_in()) redirect();
        //AngularJS    
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js');
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-messages.js');
        //Switch button    
        $this->load->css('_assets/plugins/switchButton/docs/lib/css/highlight.css');
        $this->load->css('_assets/plugins/switchButton/dist/css/bootstrap3/bootstrap-switch.css');
        $this->load->js('_assets/plugins/switchButton/dist/js/bootstrap-switch.js'); 
        //My js helpers 
        $this->load->js('_assets/js/helpers.js'); 
        
        $this->_CI->load->model('PatientModel'); 
        $this->_CI->load->model('MeasurementModel');
        $error=''; 
        //If form posted, then valid/add 
        $this->load->helpers("bm_helper"); 
        if(bmFormValidated()){   
            if($this->MeasurementModel->insert($this->input->post(NULL, TRUE), $id)){
                redirect("account/measurements");
            }else {
                $error = 'Error... Failed to insert!';
            }
        } 
        
        $data=["bannerText"=>"Add Body Measurement", "pageUrl"=>"addMeasurement", "pageName"=>"Add Measurement"];
        $data["error"]=$error;
        $data["patients"]= $this->_CI->PatientModel->getRecords(user("id"), "full_name");
        
        if(strtoupper($this->input->server('REQUEST_METHOD'))=='POST'){  
            $data = array_merge($data, $this->input->post(NULL, TRUE));//Set posted data back
        }   
        $this->load->view('formBM', $data);
    } 
    
    /***
     * account/editMeasurement 
     */
    public function editMeasurement($id="")
    { 
        if(!logged_in() || !is_numeric($id)) redirect(); 
        //AngularJS    
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js');
        $this->load->js('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-messages.js');
        //Switch button    
        $this->load->css('_assets/plugins/switchButton/docs/lib/css/highlight.css');
        $this->load->css('_assets/plugins/switchButton/dist/css/bootstrap3/bootstrap-switch.css');
        $this->load->js('_assets/plugins/switchButton/dist/js/bootstrap-switch.js'); 
        //My js helpers 
        $this->load->js('_assets/js/helpers.js'); 
        
        $this->_CI->load->model('PatientModel'); 
        $this->_CI->load->model('MeasurementModel');
        $error='';
        
        //If form posted, then valid/add 
        $this->load->helpers("bm_helper"); 
        if(bmFormValidated()){   
            if($this->MeasurementModel->update($this->input->post(NULL, TRUE), $id)){
                redirect("account/measurements");
            }else {
                $error = 'Error... Failed to update!';
            }
        } 
        
        $data=["bannerText"=>"Edit Body Measurement", "pageUrl"=>"editMeasurement", "pageName"=>"Edit Measurement"];
        $data["error"]=$error;
        $data["patients"]= $this->_CI->PatientModel->getRecords(user("id"), "full_name");
        
        if(strtoupper($this->input->server('REQUEST_METHOD'))=='POST'){  
            $data = array_merge($data, $this->input->post(NULL, TRUE));//Set posted data back
        }else{
            $mb=$this->MeasurementModel->getRecord($id, true);
            $data= array_merge($data, $mb);
            $data["inLbs"]=true;
        }   
        $this->load->view('formBM', $data);
    } 
    
    /***
     * account/delete 
     */
    public function deleteMeasurement($id)
    {
        //Delete using ajax 
        
//        if(!logged_in()) redirect();
//        
//        $data=["bannerText"=>"Edit Body Measurement", "pageUrl"=>"editMeasurement", "pageName"=>"Edit Measurement"];
//        $this->load->view('editBM', $data);
    } 
    
     /***
     * account/call?data=xxx 
     */
    public function call($action){    
        $this->output->unset_template(); 
        if(!logged_in())
            return null; 
            
        switch(strtoupper($action)){
            case "GET-PATIENTS":
                //$data=$this->input->post();
                $data= json_decode(file_get_contents('php://input'), TRUE);  
                $accountId=$data['aid'];
                $this->_CI->load->model('PatientModel');
                $records = $this->_CI->PatientModel->getRecords($accountId, "full_name");  
                if(count($records)>0){
                    echo json_encode($records);
               }
                break;
            case "GET-MEASUREMENTS": 
               // $data=$this->input->get(null, true);
                $data= json_decode(file_get_contents('php://input'), TRUE);  
                $accountId=$data["account_id"];
                unset($data["account_id"]);
                $this->_CI->load->model('MeasurementModel');
                $records=$this->_CI->MeasurementModel->getRecords($accountId, $data, 'date_created');
                echo json_encode($records);
                break; 
            case "GET-BM-CHART-DATA": 
                $data=$this->input->get(null, true);
                //$data= json_decode(file_get_contents('php://input'), TRUE);   
                $patientId=$data["patient_id"]; 
                $year=$data["year"];
                $this->_CI->load->model('MeasurementModel');
                $records=$this->_CI->MeasurementModel->getPatientMeasurements($patientId, $year, 'date_created');
                echo json_encode($records);
                break;
            case "DELETE-MEASUREMENT":
                $data=$this->input->get(null, true);
                //$data= json_decode(file_get_contents('php://input'), TRUE);   
                //print_r($data);
                $id=$data["id"];  
                $this->_CI->load->model('MeasurementModel');
                
                $obj["error"]='';
                if(!$this->_CI->MeasurementModel->delete($id)){
                    $obj["error"]='Failed to delete';
                } 
                echo json_encode($obj);
                break;
            default:
                break;
        }
    } 
}
