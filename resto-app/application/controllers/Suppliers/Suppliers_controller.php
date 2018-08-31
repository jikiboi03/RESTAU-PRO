<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Suppliers/Suppliers_model','suppliers');
    }

    public function index()						
    {
        if($this->session->userdata('administrator') == '0')
        {
            redirect('error500');
        }

        $this->load->helper('url');							

        $data['title'] = '<i class="fa fa-truck"></i> Suppliers';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('suppliers/suppliers_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->suppliers->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $suppliers) {
            $no++;
            $row = array();
            $row[] = 'SU' . $suppliers->supplier_id;
            $row[] = '<b>' . $suppliers->name . '</b>';
            $row[] = $suppliers->address;
            
            $row[] = $suppliers->city;
            $row[] = $suppliers->contact;
            $row[] = $suppliers->email;

            $row[] = $suppliers->encoded;

            //add html for action
            $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_item('."'".$suppliers->supplier_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_item('."'".$suppliers->supplier_id."'".', '."'".$suppliers->name."'".')"><i class="fa fa-trash"></i></a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->suppliers->count_all(),
                        "recordsFiltered" => $this->suppliers->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($supplier_id)
    {
        $data = $this->suppliers->get_by_id($supplier_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
                'removed' => 0
            );
        $insert = $this->suppliers->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
            );
        $this->suppliers->update(array('supplier_id' => $this->input->post('supplier_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a suppliers
    public function ajax_delete($supplier_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->suppliers->update(array('supplier_id' => $supplier_id), $data);
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
                $duplicates = $this->suppliers->get_duplicates($this->input->post('name'));

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'name';
                    $data['error_string'][] = 'item name already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('address') == '')
        {
            $data['inputerror'][] = 'address';
            $data['error_string'][] = 'Address is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('city') == '')
        {
            $data['inputerror'][] = 'city';
            $data['error_string'][] = 'City is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('contact') == '')
        {
            $data['inputerror'][] = 'contact';
            $data['error_string'][] = 'Contact is required';
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
        $list = $this->suppliers->get_api_datatables();
        $data = array();
        
        foreach ($list as $suppliers) {

            $row = array();
            $row['supplier_id'] = $suppliers->supplier_id;
            $row['name'] = $suppliers->name;
            $row['address'] = $suppliers->address;

            $row['city'] = $suppliers->city;
            $row['contact'] = $suppliers->contact;
            $row['email'] = $suppliers->email;

            $row['encoded'] = $suppliers->encoded;

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
        
        foreach ($array as $suppliers) {

            $row = array();
            $row['supplier_id'] = $suppliers['supplier_id'];
            $row['name'] = $suppliers['name'];
            $row['descr'] = $suppliers['descr'];
            
            $row['item_type'] = $suppliers['item_type'];

            $row['encoded'] = $suppliers['encoded'];

            $data[] = $row;
        }
        


        //sample gi update nako ni
        // bag ong edit
        //sample
        //output to json format
        echo json_encode($data);
    }
 }