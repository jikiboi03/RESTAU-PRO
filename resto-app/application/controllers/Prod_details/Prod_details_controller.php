<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prod_details_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Items/Items_model','items');
        $this->load->model('Products/Products_model','products');
        $this->load->model('Categories/Categories_model','categories');

        $this->load->model('Prod_details/Prod_details_model','prod_details');
    }

    public function index($prod_id)						
    {
        if($this->session->userdata('user_id') == '')
        {
            redirect('error500');
        }

        $this->load->helper('url');

        $product_data = $this->products->get_by_id($prod_id);
        $items_list = $this->items->get_items();
        
        $data['product'] = $product_data;
        $data['items'] = $items_list;

        $data['title'] = 'Product Details';
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('prod_details/prod_details_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list($prod_id) // get all that belongs to this ID via foreign key
    {
        $list = $this->prod_details->get_datatables($prod_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $prod_details) {
            $no++;
            $row = array();
            $row[] = 'I' . $prod_details->item_id;

            $item_name = $this->items->get_item_name($prod_details->item_id);
            $row[] = $item_name;

            $row[] = $this->items->get_item_descr($prod_details->item_id);

            $row[] = $prod_details->qty;

            $row[] = $prod_details->encoded;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_prod_detail_qty('."'".$prod_id."'".', '."'".$prod_details->item_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_prod_detail('."'".$prod_id."'".', '."'".$prod_details->item_id."'".')"><i class="fa fa-trash"></i></a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->prod_details->count_all($prod_id),
                        "recordsFiltered" => $this->prod_details->count_filtered($prod_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($prod_id, $item_id)
    {
        $data = $this->prod_details->get_by_id($prod_id, $item_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'prod_id' => $this->input->post('prod_id'),
                'item_id' => $this->input->post('item_id'),
                'qty' => $this->input->post('qty'),
            );
        $insert = $this->prod_details->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate_qty_only();
        $data = array(
                'qty' => $this->input->post('qty'),
            );
        $this->prod_details->update(array('prod_id' => $this->input->post('prod_id'), 'item_id' => $this->input->post('current_item_id')), $data); // update record with multiple where clause
        echo json_encode(array("status" => TRUE));
    }

    // delete a record
    public function ajax_delete($prod_id, $item_id)
    {
        $this->prod_details->delete_by_id($prod_id, $item_id);
        echo json_encode(array("status" => TRUE));
    }


    // ================================================= IMAGE SECTION =====================================================


    public function do_upload() 
    {
        $prod_id = $this->input->post('prod_id');

        $version = 0;

        // try
        // {
        //     $img_name = $this->products->get_product_img($prod_id);

        //     $version = explode("_", $img_name)[1]; // get index 1 of the exploded img_name to increment
        // }
        // catch (Exception $e) {
        //     // json_encode 'Caught exception: ',  $e->getMessage(), "\n";
        // }

        if ($this->products->get_product_img($prod_id) != '')
        {
            $img_name = $this->products->get_product_img($prod_id);

            $version = explode("_", $img_name)[1]; // get index 1 of the exploded img_name to increment
        }

        $new_version = ($version + 1);

         $config['upload_path']   = 'uploads/products'; 
         $config['allowed_types'] = 'jpg|jpeg'; 
         $config['max_size']      = 2000; 
         $config['max_width']     = 5000; 
         $config['max_height']    = 5000;
         $new_name = $prod_id . '_' . $new_version . '_.jpg';
         $config['file_name'] = $new_name;
         $config['overwrite'] = TRUE;

         $this->load->library('upload', $config);
            
         if ( ! $this->upload->do_upload('userfile1')) // upload fail
         {
            $error = array('error' => $this->upload->display_errors() . '<a href="javascript:history.back()">Back to Product</a>'); 
            $this->load->view('upload_form', $error);
            // echo '<script type="text/javascript">alert("' . $error.toString() . '"); </script>';
         }
         else // upload success
         { 
            $data = array('upload_data' => $this->upload->data()); 
            
            $data = array(
                'img' => $new_name
            );
            $this->products->update(array('prod_id' => $prod_id), $data);
            redirect('/prod-details-page/' . $prod_id);
         } 
    }


    // ======================================= END IMAGE SECTION ===========================================================

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('item_id') == '')
        {
            $data['inputerror'][] = 'item_id';
            $data['error_string'][] = 'Product item is required';
            $data['status'] = FALSE;
        }
        // validation for duplicates
        else
        {
            $prod_id = $this->input->post('prod_id');
            $new_item_id = $this->input->post('item_id');
            // check if name has a new value or not
            if ($this->input->post('current_item_id') != $new_item_id)
            {
                // validate if name already exist in the databaase table
                $duplicates = $this->prod_details->get_duplicates($prod_id, $new_item_id);

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'item_id';
                    $data['error_string'][] = 'Product item already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('qty') == '')
        {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'Product item quantity is required';
            $data['status'] = FALSE;
        }
        else if($this->input->post('qty') <= 0)
        {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'Quantity value should be greater than zero';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_qty_only()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('qty') == '')
        {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'Product item quantity is required';
            $data['status'] = FALSE;
        }
        else if($this->input->post('qty') <= 0)
        {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'Quantity value should be greater than zero';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }


    // ================================================ API GET REQUEST METHOD ============================================


    public function ajax_api_list($prod_id) // get all that belongs to this ID via foreign key (api function)
    {
        $list = $this->prod_details->get_api_datatables($prod_id);
        $data = array();
        
        foreach ($list as $prod_details) {
            
            $row = array();
            $row['item_id'] = $prod_details->item_id;

            $item_name = $this->items->get_item_name($prod_details->item_id);
            $row['item_name'] = $item_name;

            $row['descr'] = $this->items->get_item_descr($prod_details->item_id);

            $row['qty'] = $prod_details->qty;

            $row['encoded'] = $prod_details->encoded;

            $data[] = $row;
        }
 
        //output to json format
        echo json_encode($data);
    }


    // ================================================ API POST REQUEST METHOD ============================================
 }