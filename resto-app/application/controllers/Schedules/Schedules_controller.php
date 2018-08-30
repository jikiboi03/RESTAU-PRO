<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Schedules/Schedules_model','schedules');
    }

   public function index()						/** Note: ayaw ilisi ang sequence sa page load sa page **/
   {
      if($this->session->userdata('user_id') == '')
      {
        redirect('error500');
      }
      
   	  $this->load->helper('url');							
   													
   	  $data['title'] = 'Schedules Information List';					
      $this->load->view('template/dashboard_header',$data);
      $this->load->view('schedules/schedules_view',$data);   //Kani lang ang ilisi kung mag dungag mo ug Page
      $this->load->view('template/dashboard_navigation');
      $this->load->view('template/dashboard_footer');

   }
   
    public function ajax_list()
    {
        $list = $this->schedules->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $schedules) {
            $no++;
            $row = array();
            $row[] = 'S' . $schedules->sched_id;
            $row[] = $schedules->title;
            $row[] = $schedules->date;
            $row[] = $schedules->time;
            $row[] = $schedules->remarks;
            $row[] = $schedules->username;

            $today = date("Y-m-d");

            if ($schedules->date == $today) // if schedule is today
            {
                $row[] = 'Today';
            }
            else if ($schedules->date < $today) // if schedule is today
            {
                $row[] = 'Ended';    
            }
            else
            {
                $row[] = 'Incoming';   
            }

            $row[] = $schedules->encoded;

            //add html for action
            $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_schedule('."'".$schedules->sched_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_schedule('."'".$schedules->sched_id."'".')"><i class="fa fa-trash"></i></a>';


 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->schedules->count_all(),
                        "recordsFiltered" => $this->schedules->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($sched_id)
    {
        $data = $this->schedules->get_by_id($sched_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'title' => $this->input->post('title'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'remarks' => $this->input->post('remarks'),
                'username' => $this->session->userdata('username')
            );
        $insert = $this->schedules->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'title' => $this->input->post('title'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'remarks' => $this->input->post('remarks')
            );
        $this->schedules->update(array('sched_id' => $this->input->post('sched_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a schedule record
    public function ajax_delete($sched_id)
    {
        $this->schedules->delete_by_id($sched_id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('title') == '')
        {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'Schedule title is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('date') == '')
        {
            $data['inputerror'][] = 'date';
            $data['error_string'][] = 'Schedule date is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('time') == '')
        {
            $data['inputerror'][] = 'time';
            $data['error_string'][] = 'Schedule time is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('remarks') == '')
        {
            $data['inputerror'][] = 'remarks';
            $data['error_string'][] = 'Schedule remarks is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 }