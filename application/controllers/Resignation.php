<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resignation extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $this->load->model('settings_model');
        $this->load->model('resignation_model');
    }

    public function index()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
        $data = array();
        #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
        $this->load->view('login');
    }

    public function Application()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['employee'] = $this->employee_model->emselect(); // gets active employee details
            $data['application'] = $this->resignation_model->AllResignationAPPlication();
            $this->load->view('backend/resignation_approve', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function EmApplication()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $emid = $this->session->userdata('user_login_id');
            $data['employee'] = $this->employee_model->emselectByID($emid);
            $data['application'] = $this->resignation_model->GetallApplication($emid);
            $this->load->view('backend/resignation_apply', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function SALNApplication()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $emid = $this->session->userdata('user_login_id');
            $data['employee'] = $this->employee_model->emselectByID($emid);
            $data['application'] = $this->resignation_model->AllSALNAPPlication($emid);
            $this->load->view('backend/saln_form', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function PromotionApplication()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $emid = $this->session->userdata('user_login_id');
            $data['employee'] = $this->employee_model->emselectByID($emid);
            $data['application'] = $this->resignation_model->AllIPCRAPPlication($emid);
            $this->load->view('backend/promotions', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }



    public function Update_Applications()
    {
        $employeeId = $this->input->post('employeeId');
        $newStatus = $this->input->post('new_status');

        // Load your model (assuming you have a model for your application data)
        $this->load->model('Resignation_model');

        // Call a method in your model to update the application status
        $result = $this->Resignation_model->updateApplicationStatus($employeeId, $newStatus);

        if ($result) {
            echo "Data inserted successfully with ID: ". $result; // You can return any success message here
            redirect(base_url(), 'refresh');
        } else {
            echo 'Update failed'. $result; ; // You can return an error message here
            redirect(base_url(), 'refresh');
        }


        // $employeeId = $this->input->post('employeeId'); // You can get this value from the form or AJAX request
        // $newStatus = $this->input->post('new_status'); // You can get this value from the form or AJAX request

        // if ($newStatus == 'Approve' || $newStatus == 'Reject') {
        //     $this->load->model('Resignation_model');
        //     $affectedRows = $this->Resignation_model->Application_Apply_Update($employeeId, $newStatus);
        //     if ($affectedRows > 0) {
        //         // The update was successful
        //         echo 'Status updated successfully!';
        //     } else {
        //         // Update failed
        //         echo 'Status update failed.';
        //     }
        // } else {
        //     echo 'Invalid new status';
        // }

        // if ($this->session->userdata('user_login_access') != False) {
        //     $id           = $this->input->post('id');
        //     $emid         = $this->input->post('emid');
        //     $reason       = $this->input->post('reason');
        //     /*      $type = $this->input->post('type');*/
        //     $datetime     = $this->input->post('datetime');
        //     $this->load->library('form_validation');
        //     $this->form_validation->set_error_delimiters();
        //     $this->form_validation->set_rules('reason', 'reason', 'trim|required|min_length[5]|max_length[512]|xss_clean');
        //     if ($this->form_validation->run() == FALSE) {
        //         echo validation_errors();
        //         #redirect("employee/view?I=" .base64_encode($eid));
        //     } else {
        //         $data    = array();
        //         $data    = array(
        //             'em_id' => $emid,
        //             'reason' => $reason,
        //             /*'leave_type'=>$type,*/
        //             'resignation_status' => 'Approve'
        //         );
        //         $success = $this->resignation_model->Application_Apply_Update($id, $data);
        //         $this->session->set_flashdata('feedback','Successfully Updated');
        //         redirect("resignation/Application");

        //         if ($this->db->affected_rows()) {
        //             $data    = array();
        //             $data    = array(
        //                 'emp_id' => $emid,
        //                 'app_id' => $id,
        //                 'dateyear' => $datetime
        //             );
        //             $success = $this->resignation_model->Application_Apply_Approve($data);
        //             echo "Successfully Approved";
        //         }
        //     }
        // } else {
        //     redirect(base_url(), 'refresh');
        // }
    }

    public function SALN_Applications()
    {
        // Check if the user is logged in
        if ($this->session->userdata('user_login_access') != false) {
            // Retrieve data from the form
            $emid = $this->input->post('emid');
            $resignation_date = $this->input->post('resignation_date');
    
            // Load necessary libraries and helpers
            $this->load->library('upload');
            $this->load->model('Resignation_model');
    
            // File upload configuration
            $config['upload_path'] = './SALN/'; // Specify the directory where files will be uploaded
            $config['allowed_types'] = 'pdf|doc|docx'; // Allowed file types
            $config['max_size'] = 2048; // Maximum file size in KB
         
    
            $this->upload->initialize($config);
    
            // Check if the file was successfully uploaded
            if ($this->upload->do_upload('file_url')) {
                $upload_data = $this->upload->data();
                $attachment_path = $upload_data['full_path']; // Use 'file_name' to get the encrypted file name
    
                // Insert data into the database
                $data = array(
                    'em_id' => $emid,
                    'date_filed' => $resignation_date,
                    'file_url' => $attachment_path
                );
    
                $success = $this->Resignation_model->SALN_Apply($data);
                
    
                echo "Data inserted successfully with ID: " . $success;
                redirect(base_url(), 'refresh');
            } else {
                echo "File upload failed: " . $this->upload->display_errors();
            }
        } else {
            echo "User not logged in.";
        }
    }
    

    public function Promotion_Application()
    {
        // Check if the user is logged in
        if ($this->session->userdata('user_login_access') != false) {
            // Retrieve data from the form
            $emid = $this->input->post('emid');
            $resignation_date = $this->input->post('resignation_date');
    
            // Load necessary libraries and helpers
            $this->load->library('upload');
            $this->load->model('Resignation_model');
    
            // File upload configuration
            $config['upload_path'] = './IPCR/'; // Specify the directory where files will be uploaded
            $config['allowed_types'] = 'pdf|doc|docx'; // Allowed file types
            $config['max_size'] = 2048; // Maximum file size in KB
         
    
            $this->upload->initialize($config);
    
            // Check if the file was successfully uploaded
            if ($this->upload->do_upload('file_url')) {
                $upload_data = $this->upload->data();
                $attachment_path = $upload_data['full_path']; // Use 'file_name' to get the encrypted file name
    
                // Insert data into the database
                $data = array(
                    'em_id' => $emid,
                    'date_filed' => $resignation_date,
                    'file_url' => $attachment_path
                );
    
                $success = $this->Resignation_model->Promotions_Apply($data);
    
                echo "Data inserted successfully with ID: " . $success;
                redirect(base_url(), 'refresh');
            } else {
                echo "File upload failed: " . $this->upload->display_errors();
            }
        } else {
            echo "User not logged in.";
        }
    }


    public function Add_Applications()
    {
        if ($this->session->userdata('user_login_access') != false) {
            $id = $this->input->post('id');
            $emid = $this->input->post('emid');
            $resignation_date = $this->input->post('resignation_date');
            $reason = $this->input->post('reason');
            // $duration     = $this->input->post('duration');

            // $this->load->library('form_validation');
            // $this->form_validation->set_error_delimiters();
            // if ($this->form_validation->run() == false) {
            //     echo "invalid";
            //     echo validation_errors();
            //     // redirect("employee/view?I=" .base64_encode($eid));
            // } else {

             // Load necessary libraries and helpers
             $this->load->library('upload');
             $this->load->model('Resignation_model');
     
             // File upload configuration
             $config['upload_path'] = './Resignation/'; // Specify the directory where files will be uploaded
             $config['allowed_types'] = 'pdf|doc|docx'; // Allowed file types
             $config['max_size'] = 2048; // Maximum file size in KB

             $this->upload->initialize($config);
    
             // Check if the file was successfully uploaded
             if ($this->upload->do_upload('file_url')) {
                 $upload_data = $this->upload->data();
                 $attachment_path = $upload_data['full_path']; // Use 'file_name' to get the encrypted file name
     
                 // Insert data into the database
                 $data = array(
                    'em_id' => $emid,
                    'resignation_date' => $resignation_date,
                    'reason' => $reason,
                    'file_url' => $attachment_path,
                    'resignation_status' => 'Not Approved'
                 );
     
                 $success = $this->Resignation_model->Application_Apply($data);
     
                 echo "Data inserted successfully with ID: " . $success;
                 redirect(base_url(), 'refresh');
             } else {
                 echo "File upload failed: " . $this->upload->display_errors();
             }


            // //  $data = array();
            // $data = array(
            //     'em_id' => $emid,
            //     'resignation_date' => $resignation_date,
            //     'reason' => $reason,
            //     'resignation_status' => 'Not Approved'
            // );
            // $success = $this->Resignation_model->Application_Apply($data);
            // if (!$success) {
            //     echo "Data inserted successfully with ID: " . $success;
            // } else {
            //     echo "Failed to insert data.";
            // }


            // if (empty($id)) {
            //     $success = $this->resignation_model->Application_Apply($data);
            //     $this->session->set_flashdata('feedback','Successfully Updated');
            //     redirect("resignation/Application");
            //     echo "Successfully Added";
            // } else {
            //     $success = $this->resignation_model->Application_Apply_Update($id, $data);
            //     $this->session->set_flashdata('feedback','Successfully Updated');
            //     redirect("resignation/Application");
            //     echo "Successfully Updated";
            // }

            //   }
        } else {
            redirect(base_url(), 'refresh');
        }

        // if ($this->session->userdata('user_login_access') != false) {
        //     $filetitle = $this->input->post('title');
        //     $ndate = $this->input->post('nodate');

        //     $this->load->library('form_validation');
        //     $this->form_validation->set_error_delimiters();
        //     $this->form_validation->set_rules('title', 'title', 'trim|required|min_length[25]|max_length[150]|xss_clean');

        //     if ($this->form_validation->run() == FALSE) {
        //         #echo validation_errors();
        //     # redirect("notice/All_notice");
        //     } else {
        //         if ($_FILES['file_url']['name']) {
        //             $file_name = $_FILES['file_url']['name'];
        //             $fileSize = $_FILES["file_url"]["size"] / 1024;
        //             $fileType = $_FILES["file_url"]["type"];
        //             $new_file_name = '';
        //             $new_file_name .= $file_name;

        //             $config = array(
        //                 'file_name' => $new_file_name,
        //                 'upload_path' => "./assets/images/notice",
        //                 'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx",
        //                 'overwrite' => False,
        //                 'max_size' => "50720000"
        //             );

        //             $this->load->library('Upload', $config);
        //             $this->upload->initialize($config);

        //             if (!$this->upload->do_upload('file_url')) {
        //                 echo $this->upload->display_errors();
        //                 // redirect("notice/All_notice");
        //             } else {
        //                 $path = $this->upload->data();
        //                 $img_url = $path['file_name'];
        //                 $data = array(
        //                     'title' => $filetitle,
        //                     'file_url' => $img_url,
        //                     'date' => $ndate
        //                 );
        //                 $success = $this->notice_model->Application_Apply_Update($data);
        //                 // $this->session->set_flashdata('feedback','Successfully Updated');
        //                 // redirect("notice/All_notice");
        //                 echo "Successfully Added";
        //             }
        //         }
        //     }
        // } else {
        //     redirect(base_url(), 'refresh');
        // }
    }

    public function Add_R_Status()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('rid');
            $value = $this->input->post('rvalue');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $data = array();
            $data = array(
                'resignation_status' => $value
            );
            $success = $this->resignation_model->updateResignationStatus($id, $data);
            if ($value == 'Approve') {

                echo "Resignation Approved";
            } else {
                echo "Resignation Not Approved";
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function ResignationAppbyid()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $emid = $this->input->get('emid');
            $data['resignationapplyvalue'] = $this->resignation_model->GetResignationApply($id);
            /*$leaveapplyvalue = $this->leave_model->GetEmLeaveApply($emid);*/
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function APPvalueDelet()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $success = $this->leave_model->DeletApply($id);
            redirect('resignation/Application');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Resignation_report()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['employee'] = $this->employee_model->emselect();
            $this->load->view('backend/resignation_report', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    /*Approve and update Resignation status*/
    public function approveResignationStatus()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $employeeId = $this->input->post('employeeId');
            $id = $this->input->post('rid');
            $value = $this->input->post('rvalue');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();

            $data = array();
            $data = array(
                'resignation_status' => $value
            );
            $success = $this->leave_model->updateResignationStatus($id, $data);
            if ($value == 'Approve') {

                echo "Updated successfully";
            }
        } else {
            echo " Not Updated successfully";
        }
    }
}
