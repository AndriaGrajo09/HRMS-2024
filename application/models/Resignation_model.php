<?php

class Resignation_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

    // Add the application of leave with ID no ID
    public function Application_Apply($data)
    {
        $this->db->insert('emp_resignation', $data);
        //return $this->db->ID();
    }

    // Add the application of SALN with ID no ID
    public function SALN_Apply($data)
    {
        $this->db->insert('emp_saln', $data);
        //return $this->db->ID();
    }

    // Add the application of PROMOTION with ID no ID
    public function Promotions_Apply($data)
    {
        $this->db->insert('emp_promotion', $data);
        //return $this->db->ID();
    }

  

   
    public function updateApplicationStatus($employeeId, $newStatus)
    {
        $data = array('resignation_status' => $newStatus);

        // Assuming you have a 'emp_resignation' table in your database
        $this->db->where('em_id', $employeeId);
        $this->db->update('emp_resignation', $data);

        return $this->db->affected_rows() > 0;
    }

    public function Application_Apply_Approve($data)
    {
        $this->db->insert('resignation_status', $data);
    }

    public function GetEmResignationReport($emid, $year)
    {

        if ($emid == "all") {
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




    public function GetResignationApply($id)
    {
        $sql = "SELECT `emp_resignation`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_resignation`
      LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id` 
      WHERE `emp_resignation`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function GetallApplication($emid)
    {
        $sql = "SELECT `emp_resignation`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_resignation`
      LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id`
      WHERE `emp_resignation`.`em_id`='$emid'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function AllResignationAPPlication()
    {
        $sql = "SELECT `emp_resignation`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_resignation`
      LEFT JOIN `employee` ON `emp_resignation`.`em_id`=`employee`.`em_id`";
   
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function AllSALNAPPlication()
    {
        $sql = "SELECT `emp_saln`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_saln`
      LEFT JOIN `employee` ON `emp_saln`.`em_id`=`employee`.`em_id`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function AllIPCRAPPlication()
    {
        $sql = "SELECT `emp_promotion`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_promotion`
      LEFT JOIN `employee` ON `emp_promotion`.`em_id`=`employee`.`em_id`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    

    public function DeletApply($id)
    {
        $this->db->delete('emp_resignation', array('id' => $id));
    }

    public function updateAplicationAsResolved($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('emp_resignation', $data);
    }

}
?>