<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Categories/Categories_model','categories');
    }

    public function index()						
    {
        if($this->session->userdata('administrator') == '0')
        {
            redirect('error500');
        }

        $this->load->helper('url');							

        $data['title'] = '<i class="fa fa-braille"></i> Categories';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('categories/categories_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->categories->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $categories) {
            $no++;
            $row = array();
            $row[] = 'C' . $categories->cat_id;
            $row[] = '<b>' . $categories->name . '</b>';
            $row[] = $categories->descr;

            $row[] = $categories->encoded;

            //add html for action
            $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_category('."'".$categories->cat_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_category('."'".$categories->cat_id."'".', '."'".$categories->name."'".')"><i class="fa fa-trash"></i></a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->categories->count_all(),
                        "recordsFiltered" => $this->categories->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($cat_id)
    {
        $data = $this->categories->get_by_id($cat_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'descr' => $this->input->post('descr'),
                
                'removed' => 0
            );
        $insert = $this->categories->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'descr' => $this->input->post('descr'),
            );
        $this->categories->update(array('cat_id' => $this->input->post('cat_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a categories
    public function ajax_delete($cat_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->categories->update(array('cat_id' => $cat_id), $data);
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
            $data['error_string'][] = 'Category name is required';
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
                $duplicates = $this->categories->get_duplicates($this->input->post('name'));

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'name';
                    $data['error_string'][] = 'Category name already registered';
                    $data['status'] = FALSE;
                }
            }
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
        $list = $this->categories->get_api_datatables();
        $data = array();
        
        foreach ($list as $categories) {
            
            $row = array();
            $row['cat_id'] = $categories->cat_id;
            $row['name'] = $categories->name;
            $row['descr'] = $categories->descr;

            $row['encoded'] = $categories->encoded;
 
            $data[] = $row;
        }
 
        //output to json format
        echo json_encode($data);
    }


    // ================================================ API POST REQUEST METHOD ==========================================
 }