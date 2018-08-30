<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tables_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tables/Tables_model','tables');
        $this->load->model('Table_groups/Table_groups_model','table_groups');
    }

    public function index()						
    {
        if($this->session->userdata('administrator') == "0" && $this->session->userdata('cashier') == "0")
        {
            redirect('error500');
        }

        $this->load->helper('url');

        // $categories_data = $this->categories->get_categories();
        
        // $data['categories'] = $categories_data;

        $data['title'] = '<i class="fa fa-table"></i> Tables';
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('tables/tables_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->tables->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $tables) {
            $no++;
            $row = array();
            $row[] = 'T' . $tables->tbl_id;
            $row[] = '<b>' . $tables->name . '</b>';

            $if_occupied = $this->table_groups->check_if_found($tables->tbl_id);

            if ($if_occupied->num_rows() != 0)
            {
                $status = "Occupied";

                $trans_id = $if_occupied->row()->trans_id;

                $trans_btn = '<a class="btn btn-md btn-warning" href="trans-details-page/'.$trans_id.'"> Go to Transaction: S' . $trans_id . '</a>';
            }
            else
            {
                if ($tables->status == 0)
                {
                    $status = "Available";
                }
                else if ($tables->status == 1)
                {
                    $status = "Reserved";
                }
                else if ($tables->status == 2)
                {
                    $status = "Unavailable";
                }

                $trans_btn = '';
            }

            $row[] = $status;

            $row[] = $trans_btn;

            $row[] = $tables->encoded;

            if($this->session->userdata('administrator') == '0')
            {
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_table('."'".$tables->tbl_id."'".')" disabled><i class="fa fa-pencil-square-o"></i></a>
                          
                          <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_table('."'".$tables->tbl_id."'".', '."'".$tables->name."'".')" disabled><i class="fa fa-trash"></i></a>';
            }
            else
            {
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_table('."'".$tables->tbl_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                          
                          <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_table('."'".$tables->tbl_id."'".', '."'".$tables->name."'".')"><i class="fa fa-trash"></i></a>';
            }

 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->tables->count_all(),
                        "recordsFiltered" => $this->tables->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($tbl_id)
    {
        $data = $this->tables->get_by_id($tbl_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'status' => 0, // 0 = available/vacant, 1 = occupied, 2 = reserved, 3 = unavailable

                'removed' => 0
            );
        $insert = $this->tables->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status'), // 0 = available/vacant, 1 = occupied, 2 = reserved, 3 = unavailable
            );
        $this->tables->update(array('tbl_id' => $this->input->post('tbl_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a tables
    public function ajax_delete($tbl_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->tables->update(array('tbl_id' => $tbl_id), $data);
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
            $data['error_string'][] = 'Table name is required';
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
                $duplicates = $this->tables->get_duplicates($this->input->post('name'));

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'name';
                    $data['error_string'][] = 'Table name already registered';
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


    public function ajax_api_list() // using associative array to set index names instead
    {
        $list = $this->tables->get_api_datatables();
        $data = array();
        
        foreach ($list as $tables) {
        
            $row = array();
            $row['tbl_id'] = $tables->tbl_id;
            $row['name'] = $tables->name;

            $if_occupied = $this->table_groups->check_if_found($tables->tbl_id);

            if ($if_occupied->num_rows() != 0)
            {
                $status = "Occupied";
            }
            else
            {
                if ($tables->status == 0)
                {
                    $status = "Available";
                }
                else if ($tables->status == 1)
                {
                    $status = "Reserved";
                }
                else if ($tables->status == 2)
                {
                    $status = "Unavailable";
                }
            }

            $row['status'] = $status;

            $row['encoded'] = $tables->encoded;    
 
            $data[] = $row;
        }
 
        //output to json format
        echo json_encode($data);
    }


    // // ================================================ API POST REQUEST METHOD ============================================


    // public function ajax_input_test($tbl_id)
    // {
    //     $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
    //     $request = json_decode($stream_clean);
    //     // $ready = $request->ready;
    //     $array = json_decode(json_encode($request), true);
        
    //     foreach ($array as $items) {
    //         $data = array(
    //             'name' => $items['name'],
    //         );
    //     }
        
    //     $this->tables->update(array('tbl_id' => $tbl_id), $data);
    //     echo json_encode(array("status" => TRUE));
    // }

    // public function ajax_input_test_insert()
    // {
    //     $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
    //     $request = json_decode($stream_clean);
    //     // $ready = $request->ready;
    //     $array = json_decode(json_encode($request), true);
        
    //     foreach ($array as $items) 
    //     {
    //         $data = array(
    //             'name' => $items['name'],
    //             'descr' => $items['descr'],
    //             'cat_id' => $items['cat_id'],
    //             'price' => $items['price'],
    //             'img' => '',
    //             'sold' => 0,
    //             'removed' => 0
    //         );
            
    //         $insert = $this->tables->save($data);
    //     }
    //     echo json_encode(array("status" => TRUE));
    // }
 }
