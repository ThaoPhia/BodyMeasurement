<?php
/**  
 * @category Model
 * @author Phia Thao
 * @version 1.0
 */

class MeasurementModel extends CI_Model{  
    private $_table='measurements';
    
    public function __construct()
    {
        parent::__construct();

        $this->load->database();  
    }
    
    /***
     * @return double 
     */
    public function lbsTokg($valNum) {
      if($valNum){
          return number_format($valNum / 2.2046, 2);
      }
      return 0;
    } 
    
    /***
     * @return double 
     */
    public function kgToLbs($valNum) { 
        if($valNum){
          return number_format($valNum * 2.2046, 2);
      }
      return 0; 
    }

    /***
     * @return array 
     */
    public function getPatientIds($accountId){
        $pids=[];
        if(is_numeric($accountId)){
            $query=$this->db->query("SELECT id FROM patients WHERE account_id=$accountId;");
            $records=$query->result();  
            foreach($records as $row){
                $pids[]=$row->id;
            } 
        }
        return $pids;
    }
    
    /***
     * @return array 
     */
    public function buildSearchFilters($accountId, $filters=[]){
        $filterAry=[];
        if(is_numeric($accountId)){
            //Has filters
            if(count($filters)>0){ 
                foreach($filters as $key=>$val){
                    //Since all values are numeric, check it first.
                    if(!empty($val) && is_numeric($val)){
                        $filterAry[]="m.$key = $val";
                    }               
                } 
            }
            //If no patient is selected, then show all measurements by this account patients 
            if(empty($filters["patient_id"]) || !is_numeric($filters["patient_id"])){
                $pids=$this->getPatientIds($accountId);
                $filterAry[]="m.patient_id IN(".implode(",",$pids).")";
            }
        } 
        return $filterAry;
    }
    
    /***
     * @return array/object 
     */
    public function getRecord($id, $aryFormat=false)
    {
        if(is_numeric($id)){
            $query = $this->db->get_where($this->_table, array('id' => $id));
            if($query->num_rows()){ 
                if($aryFormat)
                    return $query->row_array();
                return $query->row();
            }
        }
        return null;
    }

    /***
     * @return array object
     */
    public function getRecords($accountId, $filters=[], $orderBy = 'id', $limit = 0, $offset = 0)
    {
        //Measurements must link to the owner account only
        if(!is_numeric($accountId)){
            return [];
        }
         
        $filterAry=$this->buildSearchFilters($accountId, $filters); 
        //If there is no filters(Must be link to a patients regardless) then return
        if(count($filterAry)<=0){
            return [];
        }
        $qStr="SELECT p.full_name, p.age, p.gender, m.* "
            . "FROM ".$this->_table." m INNER JOIN patients p ON m.patient_id=p.id "
            . "WHERE ".implode(" AND ", $filterAry)." "
            . "GROUP BY m.id " 
            . "ORDER BY m.$orderBy";  
        if(is_numeric($limit) && is_numeric($offset) && $limit > 0){
            $qStr .=" LIMIT $limit, $offset";
        } 
        $query=$this->db->query($qStr);
        $records=$query->result(); 
        return $records;  
    }
    
    /***
     * @return array object
     */
    public function getPatientMeasurements($patientId, $year, $orderBy = 'id', $limit = 0, $offset = 0){
        if(!is_numeric($patientId) || !is_numeric($year)){
            return [];
        } 
                        
        $qStr="SELECT * "
            . "FROM ".$this->_table." "
            . "WHERE patient_id=$patientId AND date_created >= '$year-01-01 00:00:00' "
                . " AND date_created <= '$year-12-31 23:59:59' "  
            . "ORDER BY $orderBy ";
        if(is_numeric($limit) && is_numeric($offset) && $limit > 0){
            $qStr .=" LIMIT $limit, $offset";
        }  
        $query=$this->db->query($qStr);
        $records=$query->result(); 
        return $records;  
    }
    
    /***
     * @return bool
     */
    public function insert($data, &$id){
        //Convert kg to lbs 
        if(!$data["inLbs"]){
            $data["weight"]=$this->kgToLbs($data["weight"]);
        }
        unset($data["id"]);
        unset($data["inLbs"]);
        
        $this->db->insert($this->_table, $data);
	$id= $this->db->insert_id();
        if(is_numeric($id) && $id > 0){
            return true;
        }
        return false;
    }
    
    /***
     * @return bool
     */
    public function update($data, $id){ 
        if(is_numeric($id)){
            //Convert kg to lbs 
            if(!$data["inLbs"]){
                $data["weight"]=$this->kgToLbs($data["weight"]);
            }
            unset($data["id"]);
            unset($data["inLbs"]);
        
            $this->db->where('id', $id);
            if($this->db->update($this->_table, $data)){
                return true;
            }
        }
        return false;
    }
    
    /***
     * @return bool
     */
    public function delete($id){ 
        if(is_numeric($id)){
            if($this->db->delete($this->_table, array('id' => $id))){
                return true;
            }
        }
        return false;
    }
}