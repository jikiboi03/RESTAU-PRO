<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pack_discounts_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pack_discounts/Pack_discounts_model','pack_discounts');
        $this->load->model('Packages/Packages_model','packages');
    }

    public function index()						
    {
        if($this->session->userdata('user_id') == '')
        {
            redirect('error500');
        }

        $this->load->helper('url');

        $packages_list = $this->packages->get_packages();
        
        $data['packages'] = $packages_list;						

        $data['title'] = '<i class="fa fa-tags"></i> Package Discounts';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('pack_discounts/pack_discounts_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->pack_discounts->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pack_discounts) {
            $no++;
            $row = array();

            $new_price = $pack_discounts->new_price;
            $package_price = $this->packages->get_package_price($pack_discounts->pack_id);

            $row[] = 'PD' . $pack_discounts->pd_id;
            $row[] = 'G' . $pack_discounts->pack_id;
            
            $package_name = $this->packages->get_package_name($pack_discounts->pack_id);
            $row[] = $package_name;

            $row[] = "Original Price: " . $package_price . " " . $pack_discounts->remarks;

            $row[] = $pack_discounts->date_start;
            $row[] = $pack_discounts->date_end;

            $row[] = $pack_discounts->status;
            
            $less_amount = ($package_price - $new_price);

            $row[] = '<b>' . number_format($new_price, 2) . '</b>';

            $row[] = "<b>( -" . number_format($less_amount, 2) . " )</b>";

            //add html for action
            $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_pack_discount('."'".$pack_discounts->pd_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_pack_discount('."'".$pack_discounts->pd_id."'".', '."'".$package_name."'".')"><i class="fa fa-trash"></i></a>';

            $row[] = $pack_discounts->encoded;                      
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->pack_discounts->count_all(),
                        "recordsFiltered" => $this->pack_discounts->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($pd_id)
    {
        $data = $this->pack_discounts->get_by_id($pd_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'pack_id' => $this->input->post('pack_id'),
                'remarks' => $this->input->post('remarks'),
                'date_start' => $this->input->post('date_start'),
                'date_end' => $this->input->post('date_end'),
                'status' => $this->input->post('status'),
                'new_price' => $this->input->post('new_price'),
                
                'removed' => 0
            );
        $insert = $this->pack_discounts->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'pack_id' => $this->input->post('pack_id'),
                'remarks' => $this->input->post('remarks'),
                'date_start' => $this->input->post('date_start'),
                'date_end' => $this->input->post('date_end'),
                'status' => $this->input->post('status'),
                'new_price' => $this->input->post('new_price')
            );
        $this->pack_discounts->update(array('pd_id' => $this->input->post('pd_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a pack_discounts
    public function ajax_delete($pd_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->pack_discounts->update(array('pd_id' => $pd_id), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('pack_id') == '')
        {
            $data['inputerror'][] = 'pack_id';
            $data['error_string'][] = 'Package is required';
            $data['status'] = FALSE;
        }
        // validation for duplicates
        else
        {
            $new_name = $this->input->post('pack_id');
            // check if name has a new value or not
            if ($this->input->post('current_name') != $new_name)
            {
                // validate if name already exist in the databaase table
                $duplicates = $this->pack_discounts->get_duplicates($new_name);

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'pack_id';
                    $data['error_string'][] = 'Package discount already registered';
                    $data['status'] = FALSE;
                }
            }
        }
        
        // if($this->input->post('status') == '')
        // {
        //     $data['inputerror'][] = 'status';
        //     $data['error_string'][] = 'Discount status is required';
        //     $data['status'] = FALSE;
        // }

        if($this->input->post('new_price') == '')
        {
            $data['inputerror'][] = 'new_price';
            $data['error_string'][] = 'Discounted price is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }


    // ================================================ API GET REQUEST METHOD ============================================


    // public function ajax_api_list()
    // {
    //     $list = $this->pack_discounts->get_api_datatables();
    //     $data = array();
        
    //     foreach ($list as $pack_discounts) {
            
    //         $row = array();
    //         $row['pd_id'] = $pack_discounts->pd_id;
    //         $row['name'] = $pack_discounts->name;
    //         $row['descr'] = $pack_discounts->descr;

    //         $row['encoded'] = $pack_discounts->encoded;
 
    //         $data[] = $row;
    //     }
 
    //     //output to json format
    //     echo json_encode($data);
    // }


    // ================================================ API POST REQUEST METHOD ==========================================
 }