<?php

/***
 * @return bool
 */
function bmFormValidated()
{
    $CI =& get_instance();

    $CI->load->library('form_validation');
    $CI->load->helper('form');  
    $CI->form_validation->set_rules('patient_id', 'Patient', 'required');
    $CI->form_validation->set_rules('weight', 'Weight', 'required'); 
    $CI->form_validation->set_rules('fat', 'Fat', 'required'); 
    $CI->form_validation->set_rules('muscle', 'Muscle', 'required'); 
    $CI->form_validation->set_rules('bmi', 'BMI', 'required'); 
    $CI->form_validation->set_rules('resting_kcal', 'Resting Kcal', 'required'); 
    $CI->form_validation->set_rules('visceral_fat', 'Visceral Fat', 'required'); 
    $CI->form_validation->set_rules('body_age', 'Body Age', 'required'); 
    if($CI->form_validation->run()){
        return true;
    }
    return false;
}
