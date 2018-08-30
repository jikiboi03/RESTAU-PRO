<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prod_discounts_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prod_discounts/Prod_discounts_model','prod_discounts');
        $this->load->model('Products/Products_model','products');
    }

    public function index()						
    {
        if($this->session->userdata('user_id') == '')
        {
            redirect('error500');
        }

        $this->load->helper('url');

        $products_list = $this->products->get_products();
        
        $data['products'] = $products_list;						

        $data['title'] = '<i class="fa fa-tags"></i> Product Discounts';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('prod_discounts/prod_discounts_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->prod_discounts->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $prod_discounts) {
            $no++;
            $row = array();

            $new_price = $prod_discounts->new_price;
            $product_price = $this->products->get_product_price($prod_discounts->prod_id);

            $row[] = 'PD' . $prod_discounts->pd_id;
            $row[] = 'P' . $prod_discounts->prod_id;
            
            $product_name = $this->products->get_product_name($prod_discounts->prod_id);
            $row[] = $product_name;

            $row[] = "Original Price: " . $product_price . " " . $prod_discounts->remarks;

            $row[] = $prod_discounts->date_start;
            $row[] = $prod_discounts->date_end;

            $row[] = $prod_discounts->status;
            
            $less_amount = ($product_price - $new_price);

            $row[] = '<b>' . number_format($new_price) . '</b>';

            $row[] = "<b>( -" . number_format($less_amount, 2) . " )</b>";

            //add html for action
            $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_prod_discount('."'".$prod_discounts->pd_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_prod_discount('."'".$prod_discounts->pd_id."'".', '."'".$product_name."'".')"><i class="fa fa-trash"></i></a>';

            $row[] = $prod_discounts->encoded;                      
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->prod_discounts->count_all(),
                        "recordsFiltered" => $this->prod_discounts->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($pd_id)
    {
        $data = $this->prod_discounts->get_by_id($pd_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'prod_id' => $this->input->post('prod_id'),
                'remarks' => $this->input->post('remarks'),
                'date_start' => $this->input->post('date_start'),
                'date_end' => $this->input->post('date_end'),
                'status' => $this->input->post('status'),
                'new_price' => $this->input->post('new_price'),
                
                'removed' => 0
            );
        $insert = $this->prod_discounts->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'prod_id' => $this->input->post('prod_id'),
                'remarks' => $this->input->post('remarks'),
                'date_start' => $this->input->post('date_start'),
                'date_end' => $this->input->post('date_end'),
                'status' => $this->input->post('status'),
                'new_price' => $this->input->post('new_price')
            );
        $this->prod_discounts->update(array('pd_id' => $this->input->post('pd_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a prod_discounts
    public function ajax_delete($pd_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->prod_discounts->update(array('pd_id' => $pd_id), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('prod_id') == '')
        {
            $data['inputerror'][] = 'prod_id';
            $data['error_string'][] = 'Product is required';
            $data['status'] = FALSE;
        }
        // validation for duplicates
        else
        {
            $new_name = $this->input->post('prod_id');
            // check if name has a new value or not
            if ($this->input->post('current_name') != $new_name)
            {
                // validate if name already exist in the databaase table
                $duplicates = $this->prod_discounts->get_duplicates($new_name);

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'prod_id';
                    $data['error_string'][] = 'Product discount already registered';
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
    //     $list = $this->prod_discounts->get_api_datatables();
    //     $data = array();
        
    //     foreach ($list as $prod_discounts) {
            
    //         $row = array();
    //         $row['pd_id'] = $prod_discounts->pd_id;
    //         $row['name'] = $prod_discounts->name;
    //         $row['descr'] = $prod_discounts->descr;

    //         $row['encoded'] = $prod_discounts->encoded;
 
    //         $data[] = $row;
    //     }
 
    //     //output to json format
    //     echo json_encode($data);
    // }


    // ================================================ API POST REQUEST METHOD ==========================================
 }