<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products/Products_model','products');
        $this->load->model('Packages/Packages_model','packages');
        $this->load->model('Pack_details/Pack_details_model','pack_details');

        $this->load->model('Pack_discounts/Pack_discounts_model','pack_discounts');
        $this->load->model('Store_config/Store_config_model','store');
    }

    public function index()						
    {
        // if($this->session->userdata('administrator') == '0')
        // {
        //     redirect('error500');
        // }

        $this->load->helper('url');							

        $data['title'] = '<i class="fa fa-cubes"></i> Packages';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('packages/packages_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        // get best selling list -------------------------------------------------

        $min_price = $this->store->get_store_bs_price(1);

        $best_selling = $this->products->get_best_selling($min_price);
        $best_selling_array = array();

        foreach ($best_selling as $bp_products) 
        {
            $best_selling_array[] = $bp_products->pack_id;
        }
        //------------------------------------------------------------------------

        $list = $this->packages->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $packages) {
            $no++;
            $row = array();
            $row[] = 'G' . $packages->pack_id;

            $row[] = $packages->name;
            $row[] = '<b>' . $packages->short_name . '</b>';
            $row[] = $packages->descr;

            $row[] = $packages->price;
            

            if (in_array($packages->pack_id, $best_selling_array))
            {
                $row[] = '( <i class="fa fa-star"></i> Rank: ' . (array_search($packages->pack_id, $best_selling_array) + 1) . " ) &nbsp;&nbsp;&nbsp;&nbsp; <b>" . $packages->sold . '</b>';    
            }
            else
            {
                $row[] = '<b>' . $packages->sold . '</b>';
            }

            $row[] = $packages->encoded;

            if($this->session->userdata('administrator') == '0')
            {
                //add html for action
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_package('."'".$packages->pack_id."'".')" disabled><i class="fa fa-eye"></i> </a>

                <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_package('."'".$packages->pack_id."'".')" disabled><i class="fa fa-pencil-square-o"></i></a>
                          
                          <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_package('."'".$packages->pack_id."'".', '."'".$packages->name."'".')" disabled><i class="fa fa-trash"></i></a>';
            }
            else
            {
                //add html for action
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_package('."'".$packages->pack_id."'".')"><i class="fa fa-eye"></i> </a>

                <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_package('."'".$packages->pack_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                          
                          <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_package('."'".$packages->pack_id."'".', '."'".$packages->name."'".')"><i class="fa fa-trash"></i></a>';   
            }

            

            // get number of rows found / check if it has details data
            $row[] = $this->pack_details->check_if_found($packages->pack_id)->num_rows();


            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->packages->count_all(),
                        "recordsFiltered" => $this->packages->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($pack_id)
    {
        $data = $this->packages->get_by_id($pack_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'short_name' => $this->input->post('short_name'),
                'descr' => $this->input->post('descr'),
                'price' => $this->input->post('price'),
                'img' => '',
                'sold' => 0,
                'removed' => 0
            );
        $insert = $this->packages->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'short_name' => $this->input->post('short_name'),
                'descr' => $this->input->post('descr'),
                'price' => $this->input->post('price'),
            );
        $this->packages->update(array('pack_id' => $this->input->post('pack_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a packages
    public function ajax_delete($pack_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->packages->update(array('pack_id' => $pack_id), $data);
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
            $data['error_string'][] = 'Package name is required';
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
                $duplicates = $this->packages->get_duplicates($new_name);

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'name';
                    $data['error_string'][] = 'Package name already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('short_name') == '')
        {
            $data['inputerror'][] = 'short_name';
            $data['error_string'][] = 'Package short name is required';
            $data['status'] = FALSE;
        }
        // validation for duplicates
        else
        {
            $new_short_name = $this->input->post('short_name');
            // check if name has a new value or not
            if ($this->input->post('current_short_name') != $new_short_name)
            {
                // validate if name already exist in the databaase table
                $duplicates_short_name = $this->packages->get_sn_duplicates($new_short_name);

                if ($duplicates_short_name->num_rows() != 0)
                {
                    $data['inputerror'][] = 'short_name';
                    $data['error_string'][] = 'Package short name already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('price') == '')
        {
            $data['inputerror'][] = 'price';
            $data['error_string'][] = 'Package price is required';
            $data['status'] = FALSE;
        }
        else if($this->input->post('price') <= 0)
        {
            $data['inputerror'][] = 'price';
            $data['error_string'][] = 'Package price should be greater than zero';
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
        $list = $this->packages->get_api_datatables();
        $data = array();

        $min_price = $this->store->get_store_bs_price(1);

        $best_selling = $this->products->get_best_selling($min_price);
        $best_selling_array = array();

        foreach ($best_selling as $bp_products) {
            $best_selling_array[] = $bp_products->pack_id;

            // echo json_encode($bp_products->pack_id);
        }
        
        foreach ($list as $packages) {

            $row = array();
            $row['pack_id'] = $packages->pack_id;

            $row['name'] = $packages->name;
            $row['short_name'] = $packages->short_name;
            $row['descr'] = $packages->descr;


            $pack_price = $packages->price;

            // check if product is discounted
            $check_discount = $this->pack_discounts->get_by_pack_id($packages->pack_id);

            if ($check_discount == null)
            {
                $is_discounted = false;
                $less_price = 0;
            }
            else
            {
                $new_price = $check_discount->new_price;

                $is_discounted = true;
                $less_price = ($pack_price - $new_price);

                $pack_price = $new_price;
            }

            $row['is_discounted'] = $is_discounted;

            $row['price'] = $pack_price;

            $row['less_price'] = $less_price;


            $row['sold'] = $packages->sold;

            $row['encoded'] = $packages->encoded;

            $row['img'] = $packages->img;

            // get number of rows found / check if it has details data
            $row['prod_count'] = $this->pack_details->check_if_found($packages->pack_id)->num_rows();

            if (in_array($packages->pack_id, $best_selling_array))
            {
                $row['is_best_selling'] = true;
                $row['rank'] = (array_search($packages->pack_id, $best_selling_array) + 1);
            }
            else
            {
                $row['is_best_selling'] = false;
                $row['rank'] = 'n/a';
            }


            // get package product list ---------------------------------------------------------
            $pack_prod_data = array();

            $pack_products = $this->pack_details->get_pack_detail_products($packages->pack_id);

            // get each product of the package -----------------------------------------------------              
            
            foreach ($pack_products as $pack_products_list)
            {
                $pack_prod_row = array();

                $pack_prod_id = $pack_products_list->prod_id;
                $pack_prod_name = $this->products->get_product_name($pack_prod_id);
                $pack_prod_short_name = $this->products->get_product_short_name($pack_prod_id);
                $pack_prod_qty = $pack_products_list->qty; // multiply package product qty by pack_qty

                $pack_prod_row['pack_prod_id'] = $pack_prod_id;
                $pack_prod_row['pack_prod_name'] = $pack_prod_name;
                $pack_prod_row['pack_prod_short_name'] = $pack_prod_short_name;
                $pack_prod_row['pack_prod_qty'] = $pack_prod_qty;

                $pack_prod_data[] = $pack_prod_row;
            }

            $row['package_products'] = $pack_prod_data;


            $data[] = $row;
        }
    
        //output to json format
        echo json_encode($data);
    }   


    // ================================================ API POST REQUEST METHOD ============================================
 }