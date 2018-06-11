<?php
/**  
 * @category Model
 * @author Phia Thao
 * @version 1.0
 */

class PatientModel extends CI_Model{  
    private $_table='patients';
    
    public function __construct()
    {
        parent::__construct();

        $this->load->database();  
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
    public function getRecords($accountId, $orderBy = 'id', $limit = 0, $offset = 0)
    {
        if(is_numeric($accountId)){
            $qStr="SELECT * FROM ".$this->_table." WHERE account_id=$accountId ORDER BY $orderBy";
            if(is_numeric($limit) && is_numeric($offset) && $limit > 0)
                $qStr .=" LIMIT $limit, $offset";
            $query=$this->db->query($qStr);
            $records=$query->result(); 
            return $records;  
        }
        
        return [];
    }
   
    /***
     * @return bool
     */
    public function insert($data, &$id){   
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