<?php

	class Resignation_model extends CI_Model {


	function __construct(){
	parent::__construct();
	}

    // Add the application of leave with ID no ID
    public function Application_Apply($data){
        $this->db->insert('emp_resignation',$data);
    }

    // Update application with employee ID
    public function Application_Apply_Update($id, $data){
        $this->db->where('id', $id);
        $this->db->update('emp_resignation', $data);         
    }

    public function Application_Apply_Approve($data){
        $this->db->insert('resignation_status', $data);
    }
    
    public function GetEmResignationReport($emid, $year){

        if($emid == "all") {
        $sql = "SELECT `emp_resignation`.*,
                `employee`. `first_name`, `last_name`, `em_code`
                FROM emp_resignation
                LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id`
                WHERE MONTH(resignation_date) = '$day' AND YEAR(resignation_date) = '$year'";
    } else {

        $sql = "SELECT `emp_resignation`.*, 
        `employee`. `first_name`, `last_name`, `em_code`
        FROM emp_resignation
        LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id`
        WHERE `emp_resignation`.`em_id` = '$emid' AND MONTH(resignation_date) = '$day' AND YEAR(resignation_date) = '$year'";

/*public function GetEmLEaveReport($emid, $date){

        if($emid == "all") {
            $sql = "SELECT `assign_leave`.*,
        `employee`.`first_name`,`last_name`,
        `leave_types`.`name`
        FROM `assign_leave`
        LEFT JOIN `leave_types` ON `assign_leave`.`type_id`=`leave_types`.`type_id`
        LEFT JOIN `employee` ON `assign_leave`.`emp_id`=`employee`.`em_id`
        WHERE `dateyear`='$date'
        ";
    } else {

        $sql = "SELECT `assign_leave`.*,
        `employee`.`first_name`,`last_name`,
        `leave_types`.`name`
        FROM `assign_leave`
        LEFT JOIN `leave_types` ON `assign_leave`.`type_id`=`leave_types`.`type_id`
        LEFT JOIN `employee` ON `assign_leave`.`emp_id`=`employee`.`em_id`
        WHERE `assign_leave`.`emp_id`='$emid' AND `dateyear`='$date'
        ";
    }

*/
        
    }
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result; 
}




    public function GetResignationApply($id){
        $sql = "SELECT `emp_resignation`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_resignation`
      LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id` 
      WHERE `emp_resignation`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
   
    public function GetallApplication($emid){
    $sql = "SELECT `emp_resignation`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_resignation`
      LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id`
      WHERE `emp_resignation`.`em_id`='$emid'";
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result; 
    }
    public function AllResignationAPPlication(){
    $sql = "SELECT `emp_resignation`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_resignation`
      LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id`
      WHERE `emp_resignation`.`resignation_status`='Not Approve'";
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result; 
    }
    
    public function DeletApply($id){
        $this->db->delete('emp_resignation',array('id'=> $id));        
    }

    public function updateAplicationAsResolved($id, $data){
        $this->db->where('id', $id);
        $this->db->update('emp_resignation', $data);         
    }  
    }
?>    