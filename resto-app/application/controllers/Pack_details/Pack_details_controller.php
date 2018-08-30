<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pack_details_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products/Products_model','products');
        $this->load->model('Packages/Packages_model','packages');
        $this->load->model('Categories/Categories_model','categories');

        $this->load->model('Pack_details/Pack_details_model','pack_details');
    }

    public function index($pack_id)						
    {
        if($this->session->userdata('user_id') == '')
        {
            redirect('error500');
        }

        $this->load->helper('url');

        $package_data = $this->packages->get_by_id($pack_id);
        $products_list = $this->products->get_products();
        
        $data['package'] = $package_data;
        $data['products'] = $products_list;

        $data['title'] = 'Package Details';
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('pack_details/pack_details_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list($pack_id) // get all that belongs to this ID via foreign key
    {
        $list = $this->pack_details->get_datatables($pack_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pack_details) {
            $no++;
            $row = array();
            $row[] = 'P' . $pack_details->prod_id;

            $product_name = $this->products->get_product_name($pack_details->prod_id);
            $row[] = $product_name;

            $row[] = $this->products->get_product_descr($pack_details->prod_id);

            $row[] = $pack_details->qty;

            $row[] = $pack_details->encoded;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_pack_detail_qty('."'".$pack_id."'".', '."'".$pack_details->prod_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_pack_detail('."'".$pack_id."'".', '."'".$pack_details->prod_id."'".')"><i class="fa fa-trash"></i></a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->pack_details->count_all($pack_id),
                        "recordsFiltered" => $this->pack_details->count_filtered($pack_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($pack_id, $prod_id)
    {
        $data = $this->pack_details->get_by_id($pack_id, $prod_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'pack_id' => $this->input->post('pack_id'),
                'prod_id' => $this->input->post('prod_id'),
                'qty' => $this->input->post('qty'),
            );
        $insert = $this->pack_details->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate_qty_only();
        $data = array(
                'qty' => $this->input->post('qty'),
            );
        $this->pack_details->update(array('pack_id' => $this->input->post('pack_id'), 'prod_id' => $this->input->post('current_prod_id')), $data); // update record with multiple where clause
        echo json_encode(array("status" => TRUE));
    }

    // delete a record
    public function ajax_delete($pack_id, $prod_id)
    {
        $this->pack_details->delete_by_id($pack_id, $prod_id);
        echo json_encode(array("status" => TRUE));
    }


    // ================================================= IMAGE SECTION =====================================================


    public function do_upload() 
    {
        $pack_id = $this->input->post('pack_id');

        $version = 0;

        // try
        // {
        //     $img_name = $this->packages->get_package_img($pack_id);

        //     $version = explode("_", $img_name)[1]; // get index 1 of the exploded img_name to increment
        // }
        // catch (Exception $e) {
        //     // json_encode 'Caught exception: ',  $e->getMessage(), "\n";
        // }

        if ($this->packages->get_package_img($pack_id) != '')
        {
            $img_name = $this->packages->get_package_img($pack_id);

            $version = explode("_", $img_name)[1]; // get index 1 of the exploded img_name to increment
        }

        $new_version = ($version + 1);

         $config['upload_path']   = 'uploads/packages'; 
         $config['allowed_types'] = 'jpg|jpeg'; 
         $config['max_size']      = 2000; 
         $config['max_width']     = 5000; 
         $config['max_height']    = 5000;
         $new_name = $pack_id . '_' . $new_version . '_.jpg';
         $config['file_name'] = $new_name;
         $config['overwrite'] = TRUE;

         $this->load->library('upload', $config);
            
         if ( ! $this->upload->do_upload('userfile1')) // upload fail
         {
            $error = array('error' => $this->upload->display_errors() . '<a href="javascript:history.back()">Back to Package</a>'); 
            $this->load->view('upload_form', $error);
            // echo '<script type="text/javascript">alert("' . $error.toString() . '"); </script>';
         }
         else // upload success
         { 
            $data = array('upload_data' => $this->upload->data()); 
            
            $data = array(
                'img' => $new_name
            );
            $this->packages->update(array('pack_id' => $pack_id), $data);
            redirect('/pack-details-page/' . $pack_id);
         } 
    }


    // ======================================= END IMAGE SECTION ===========================================================

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('prod_id') == '')
        {
            $data['inputerror'][] = 'prod_id';
            $data['error_string'][] = 'Package product is required';
            $data['status'] = FALSE;
        }
        // validation for duplicates
        else
        {
            $pack_id = $this->input->post('pack_id');
            $new_prod_id = $this->input->post('prod_id');
            // check if name has a new value or not
            if ($this->input->post('current_prod_id') != $new_prod_id)
            {
                // validate if name already exist in the databaase table
                $duplicates = $this->pack_details->get_duplicates($pack_id, $new_prod_id);

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'prod_id';
                    $data['error_string'][] = 'Package product already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('qty') == '')
        {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'Package product quantity is required';
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
            $data['error_string'][] = 'Package product quantity is required';
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


    public function ajax_api_list($pack_id) // get all that belongs to this ID via foreign key
    {
        $list = $this->pack_details->get_api_datatables($pack_id);
        $data = array();
        
        foreach ($list as $pack_details) {
        
            $row = array();
            $row['prod_id'] = $pack_details->prod_id;

            $product_name = $this->products->get_product_name($pack_details->prod_id);
            $row['product_name'] = $product_name;

            $row['descr'] = $this->products->get_product_descr($pack_details->prod_id);

            $row['qty'] = $pack_details->qty;

            $row['encoded'] = $pack_details->encoded;

            $data[] = $row;
        }
 
        //output to json format
        echo json_encode($data);
    }


    // ================================================ API POST REQUEST METHOD ============================================
 }