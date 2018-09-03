<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Units/Units_model','units');
    }

    public function index()						
    {
        if($this->session->userdata('administrator') == '0')
        {
            redirect('error500');
        }

        $this->load->helper('url');							

        $data['title'] = '<i class="fa fa-balance-scale"></i> Units';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('units/units_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->units->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $units) {
            $no++;
            $row = array();
            $row[] = 'I' . $units->unit_id;
            $row[] = '<b>' . $units->name . '</b>';
            $row[] = $units->descr;
            
            $row[] = $units->pcs;

            $row[] = $units->encoded;

            //add html for action
            $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_item('."'".$units->unit_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_item('."'".$units->unit_id."'".', '."'".$units->name."'".')"><i class="fa fa-trash"></i></a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->units->count_all(),
                        "recordsFiltered" => $this->units->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($unit_id)
    {
        $data = $this->units->get_by_id($unit_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'descr' => $this->input->post('descr'),
                'pcs' => $this->input->post('pcs'),
                'removed' => 0
            );
        $insert = $this->units->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'descr' => $this->input->post('descr'),
                'pcs' => $this->input->post('pcs'),
            );
        $this->units->update(array('unit_id' => $this->input->post('unit_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a units
    public function ajax_delete($unit_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->units->update(array('unit_id' => $unit_id), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('name') == '')
        {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'item name is required';
            $data['status'] = FALSE;
        }
        // validation for duplicates
        else
        {
            $new_name = $this->input->post('name');
            // check if name has a new value or not
            if ($this->input->post('current_name') != $new_name)
            {
                // validate if name already exist in the databaase table
                $duplicates = $this->units->get_duplicates($this->input->post('name'));

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'name';
                    $data['error_string'][] = 'Unit name already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('pcs') == '')
        {
            $data['inputerror'][] = 'pcs';
            $data['error_string'][] = 'Unit equivalent qty in pcs is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }



    // ================================================ API GET REQUEST METHOD ============================================


    public function ajax_api_list()
    {
        $list = $this->units->get_api_datatables();
        $data = array();
        
        foreach ($list as $units) {

            $row = array();
            $row['unit_id'] = $units->unit_id;
            $row['name'] = $units->name;
            $row['descr'] = $units->descr;
            
            $row['pcs'] = $units->pcs;

            $row['encoded'] = $units->encoded;

            $data[] = $row;
        }
    
        //output to json format
        echo json_encode($data);
    }


    // ================================================ API POST REQUEST METHOD ============================================


    public function ajax_input()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);
        // $ready = $request->ready;
        $array = json_decode(json_encode($request), true);

        $data = array();
        
        foreach ($array as $units) {

            $row = array();
            $row['unit_id'] = $units['unit_id'];
            $row['name'] = $units['name'];
            $row['descr'] = $units['descr'];
            
            $row['pcs'] = $units['pcs'];

            $row['encoded'] = $units['encoded'];

            $data[] = $row;
        }
        


        //sample gi update nako ni
        // bag ong edit
        //sample
        //output to json format
        echo json_encode($data);
    }
 }