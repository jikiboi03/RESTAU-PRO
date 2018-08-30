<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trans_logs_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Logs/Trans_logs_model','trans_logs');
    }

    public function index()
    {
        if($this->session->userdata('user_id') == '')
        {
          redirect('error500');
        }

        $this->load->helper('url');							
        											
        $data['title'] = '<i class="fa fa-history"></i> Transaction Logs';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('logs/trans_logs_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->trans_logs->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $trans_logs) {
            $no++;
            $row = array();
            $row[] = 'TL' . $trans_logs->log_id;
            
            $row[] = $trans_logs->log_type;
            $row[] = str_replace("%20", " ", $trans_logs->details);

            $row[] = '<b>' . $trans_logs->user_fullname . '</b>';

            $row[] = $trans_logs->date_time;            
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->trans_logs->count_all(),
                        "recordsFiltered" => $this->trans_logs->count_filtered(),
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
        $insert = $this->trans_logs->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_add_api()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);
        // $ready = $request->ready;
        $array = json_decode(json_encode($request), true);
        
        foreach ($array as $log_details) 
        {
            $username = $log_details['username'];
            $log_type = $log_details['log_type'];
            $details = $log_details['details'];
        }

        $data = array(

                'user_fullname' => $username,
                'log_type' => $log_type,
                'details' => $details
            );
        $insert = $this->trans_logs->save($data);
        echo json_encode(array("status" => TRUE));
    }
        
 }