<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products/Products_model','products');
        $this->load->model('Categories/Categories_model','categories');
        $this->load->model('Prod_details/Prod_details_model','prod_details');

        $this->load->model('Prod_discounts/Prod_discounts_model','prod_discounts');
        $this->load->model('Store_config/Store_config_model','store');
    }

    public function index()						
    {
        // if($this->session->userdata('administrator') == '0')
        // {
        //     redirect('error500');
        // }

        $this->load->helper('url');

        $categories_data = $this->categories->get_categories();
        
        $data['categories'] = $categories_data;

        $data['title'] = '<i class="fa fa-cube"></i> Products';
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('products/products_view',$data);
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
            $best_selling_array[] = $bp_products->prod_id;
        }
        //------------------------------------------------------------------------

        $list = $this->products->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
            $no++;
            $row = array();
            $row[] = 'P' . $products->prod_id;

            $row[] = $products->name;
            $row[] = '<b>' . $products->short_name . '</b>'; // 12 char short name
            $row[] = $products->descr;

            $row[] = $this->categories->get_category_name($products->cat_id); // get name instead of id

            $row[] = $products->price;
        

            if (in_array($products->prod_id, $best_selling_array))
            {
                $row[] = '( <i class="fa fa-star"></i> Rank: ' . (array_search($products->prod_id, $best_selling_array) + 1) . " ) &nbsp;&nbsp;&nbsp;&nbsp; <b>" . $products->sold . '</b>';    
            }
            else
            {
                $row[] = '<b>' . $products->sold . '</b>';
            }


            $row[] = $products->encoded;

            if($this->session->userdata('administrator') == '0')
            {
                //add html for action
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_product('."'".$products->prod_id."'".')" disabled><i class="fa fa-eye"></i> </a>

                <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_product('."'".$products->prod_id."'".')" disabled><i class="fa fa-pencil-square-o"></i></a>
                          
                          <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_product('."'".$products->prod_id."'".', '."'".$products->name."'".')" disabled><i class="fa fa-trash"></i></a>';

            }
            else
            {
                //add html for action
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_product('."'".$products->prod_id."'".')"><i class="fa fa-eye"></i> </a>

                <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit_product('."'".$products->prod_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                          
                          <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_product('."'".$products->prod_id."'".', '."'".$products->name."'".')"><i class="fa fa-trash"></i></a>';                
            }
            

            // get number of rows found / check if it has details data
            $row[] = $this->prod_details->check_if_found($products->prod_id)->num_rows();

 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->products->count_all(),
                        "recordsFiltered" => $this->products->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($prod_id)
    {
        $data = $this->products->get_by_id($prod_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'short_name' => $this->input->post('short_name'),
                'descr' => $this->input->post('descr'),
                'cat_id' => $this->input->post('cat_id'),
                'price' => $this->input->post('price'),
                'img' => '',
                'sold' => 0,
                'removed' => 0
            );
        $insert = $this->products->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'short_name' => $this->input->post('short_name'),
                'descr' => $this->input->post('descr'),
                'cat_id' => $this->input->post('cat_id'),
                'price' => $this->input->post('price'),
            );
        $this->products->update(array('prod_id' => $this->input->post('prod_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a products
    public function ajax_delete($prod_id)
    {
        $data = array(
                'removed' => 1
            );
        $this->products->update(array('prod_id' => $prod_id), $data);
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
            $data['error_string'][] = 'Product name is required';
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
                $duplicates = $this->products->get_duplicates($new_name);

                if ($duplicates->num_rows() != 0)
                {
                    $data['inputerror'][] = 'name';
                    $data['error_string'][] = 'Product name already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('short_name') == '')
        {
            $data['inputerror'][] = 'short_name';
            $data['error_string'][] = 'Product short name is required';
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
                $duplicates_short_name = $this->products->get_sn_duplicates($new_short_name);

                if ($duplicates_short_name->num_rows() != 0)
                {
                    $data['inputerror'][] = 'short_name';
                    $data['error_string'][] = 'Product short name already registered';
                    $data['status'] = FALSE;
                }
            }
        }

        if($this->input->post('cat_id') == '')
        {
            $data['inputerror'][] = 'cat_id';
            $data['error_string'][] = 'Product category is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('price') == '')
        {
            $data['inputerror'][] = 'price';
            $data['error_string'][] = 'Product price is required';
            $data['status'] = FALSE;
        }
        else if($this->input->post('price') <= 0)
        {
            $data['inputerror'][] = 'price';
            $data['error_string'][] = 'Product price should be greater than zero';
            $data['status'] = FALSE;
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
        $list = $this->products->get_api_datatables();
        $data = array();

        $min_price = $this->store->get_store_bs_price(1);

        $best_selling = $this->products->get_best_selling($min_price);
        $best_selling_array = array();

        foreach ($best_selling as $bp_products) {
            $best_selling_array[] = $bp_products->prod_id;

            // echo json_encode($bp_products->prod_id);
        }
        
        foreach ($list as $products) {
        
            $row = array();
            $row['prod_id'] = $products->prod_id;

            $row['name'] = $products->name;
            $row['short_name'] = $products->short_name;
            $row['descr'] = $products->descr;

            $row['cat_id'] = $products->cat_id;
            $row['cat_name'] = $this->categories->get_category_name($products->cat_id); // get name instead of id


            $prod_price = $products->price;

            // check if product is discounted
            $check_discount = $this->prod_discounts->get_by_prod_id($products->prod_id);

            if ($check_discount == null)
            {
                $is_discounted = false;
                $less_price = 0;
            }
            else
            {
                $new_price = $check_discount->new_price;

                $is_discounted = true;
                $less_price = ($prod_price - $new_price);

                $prod_price = $new_price;
            }

            $row['is_discounted'] = $is_discounted;

            $row['price'] = $prod_price;

            $row['less_price'] = $less_price;            


            $row['sold'] = $products->sold;

            $row['encoded'] = $products->encoded;

            $row['img'] = $products->img;

            // get number of rows found / check if it has details data
            $row['item_count'] = $this->prod_details->check_if_found($products->prod_id)->num_rows();

            if (in_array($products->prod_id, $best_selling_array))
            {
                $row['is_best_selling'] = true;
                $row['rank'] = (array_search($products->prod_id, $best_selling_array) + 1);
            }
            else
            {
                $row['is_best_selling'] = false;
                $row['rank'] = 'n/a';
            }

 
            $data[] = $row;
        }
 
        //output to json format
        echo json_encode($data);
    }


    // ================================================ API POST REQUEST METHOD ============================================


    public function ajax_input_test($prod_id)
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);
        // $ready = $request->ready;
        $array = json_decode(json_encode($request), true);
        
        foreach ($array as $items) {
            $data = array(
                'name' => $items['name'],
            );
        }
        
        $this->products->update(array('prod_id' => $prod_id), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_input_test_insert()
    {
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);
        // $ready = $request->ready;
        $array = json_decode(json_encode($request), true);
        
        foreach ($array as $items) 
        {
            $data = array(
                'name' => $items['name'],
                'descr' => $items['descr'],
                'cat_id' => $items['cat_id'],
                'price' => $items['price'],
                'img' => '',
                'sold' => 0,
                'removed' => 0
            );
            
            $insert = $this->products->save($data);
        }
        echo json_encode(array("status" => TRUE));
    }
 }