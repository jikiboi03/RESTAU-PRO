<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Logs/Logs_model','logs');
    }

    public function index()
    {
        if($this->session->userdata('user_id') == '')
        {
          redirect('error500');
        }

        $this->load->helper('url');							
        											
        $data['title'] = '<i class="fa fa-history"></i> System Logs';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('logs/logs_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->logs->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $logs) {
            $no++;
            $row = array();
            $row[] = 'L' . $logs->log_id;
            
            $row[] = $logs->log_type;
            $row[] = str_replace("%20", " ", $logs->details);

            $row[] = $logs->user_fullname;

            $row[] = $logs->date_time;            
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->logs->count_all(),
                        "recordsFiltered" => $this->logs->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_add($log_type, $details)
    {
        $username = $this->session->userdata('username');

        $data = array(

                'user_fullname' => $username,
                'log_type' => $log_type,
                'details' => $details
            );
        $insert = $this->logs->save($data);
        echo json_encode(array("status" => TRUE));
    }
 

 }