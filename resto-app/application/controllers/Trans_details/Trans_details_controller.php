<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'vendor/mike42/autoload.php');
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class Trans_details_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transactions/Transactions_model','transactions');

        $this->load->model('Products/Products_model','products');
        $this->load->model('Packages/Packages_model','packages');
        $this->load->model('Pack_details/Pack_details_model','pack_details');
        $this->load->model('Tables/Tables_model','tables');

        $this->load->model('Trans_details/Trans_details_model','trans_details');
        $this->load->model('Table_groups/Table_groups_model','table_groups');

        $this->load->model('Users/Users_model','users');

        $this->load->model('Discounts/Discounts_model','discounts');
        $this->load->model('Store_config/Store_config_model','store');

        $this->load->model('Pack_discounts/Pack_discounts_model','pack_discounts');
        $this->load->model('Prod_discounts/Prod_discounts_model','prod_discounts');

        $this->load->model('Logs/Trans_logs_model','trans_logs');
    }

    public function index($trans_id)						
    {
        if($this->session->userdata('user_id') == '' || ($this->session->userdata('administrator') == "0" && $this->session->userdata('cashier') == "0"))
        {
            redirect('error500');
        }

        $this->load->helper('url');

        $transactions_data = $this->transactions->get_by_id($trans_id);

        $gross_total = $this->trans_details->get_trans_gross($trans_id);

        $tables = $this->table_groups->get_table_group_tables($trans_id);

        if ($tables->num_rows() != 0)
        {
            $tables_data = array();

            foreach ($tables->result() as $tables_list) 
            {
                if ($tables_list->tbl_id == 0)
                {
                    $tables_data[] = 'No Table';
                }
                else
                {
                    $tables_data[] = $this->tables->get_table_name($tables_list->tbl_id);
                }
            }

            $table_str = implode(', ', $tables_data);
        }
        else
        {
            $table_str = 'n/a';
        }

        $discounts_data = $this->discounts->get_discounts();

        $managers_password = $this->store->get_store_config_password(1); // get manager's password
        
        $data['managers_password'] = $managers_password;

        $data['discounts'] = $discounts_data;
        
        $data['transaction'] = $transactions_data;
        $data['gross_total'] = $gross_total;
        $data['table_str'] = $table_str;

        $this->reset_is_updated($trans_id); // reset is_updated every page load


        $data['title'] = '<i class="fa fa-qrcode"></i> Transaction Details';
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('trans_details/trans_details_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }

    public function index_refund($trans_id) // accessed whenever refund process is activated                        
    {
        if($this->session->userdata('user_id') == '')
        {
            redirect('error500');
        }

        $this->load->helper('url');

        // copy items from trans_details to trans_details_refund table
        // $this->trans_details->copy_to_trans_details_refund($trans_id);


        $transactions_data = $this->transactions->get_by_id($trans_id);

        // $gross_total = $this->trans_details_refund->get_trans_gross($trans_id);

        $managers_password = $this->store->get_store_config_password(1); // get manager's password
        
        $data['managers_password'] = $managers_password;
        
        $data['transaction'] = $transactions_data;
        $data['gross_total'] = $gross_total;

        $data['title'] = '<i class="fa fa-qrcode"></i> Transaction Details';
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('trans_details/trans_details_refund_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }


   
    public function ajax_list($trans_id) // get all that belongs to this ID via foreign key
    {
        $list = $this->trans_details->get_datatables($trans_id);
        $data = array();
        $no = $_POST['start'];

        $item_count = 0; // initialize number of items counter
        $transactions_data = $this->transactions->get_by_id($trans_id);

        $status = $transactions_data->status;

        foreach ($list as $trans_details) {
            $no++;
            $row = array();

            if ($status == 'ONGOING')
            {
                if ($trans_details->prod_type == 1) // if prod_type is package
                {
                    $item_id = 'G' . $trans_details->pack_id;
                    $item_name = $this->packages->get_package_name($trans_details->pack_id);

                    $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="delete_trans_detail_pack('."'".$trans_id."'".', '."'".$trans_details->pack_id."'".')"><i class="fa fa-trash"></i></a>';
                }
                else if ($trans_details->prod_type == 0) // if prod_type is individual product
                {
                    $item_id = 'P' . $trans_details->prod_id;
                    $item_name = $this->products->get_product_name($trans_details->prod_id);

                    $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="delete_trans_detail_prod('."'".$trans_id."'".', '."'".$trans_details->prod_id."'".')"><i class="fa fa-trash"></i></a>';
                }
                else if ($trans_details->prod_type == 2) // if prod_type is package product
                {   
                    $item_id = 'P' . $trans_details->prod_id;
                    $item_name = $this->products->get_product_name($trans_details->prod_id);

                    $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="delete_trans_detail_prod('."'".$trans_id."'".', '."'".$trans_details->prod_id."'".')" disabled><i class="fa fa-trash"></i></a>';
                }    
            }
            else
            {
                if ($trans_details->prod_type == 1) // if prod_type is package
                {
                    $item_id = 'G' . $trans_details->pack_id;
                    $item_name = $this->packages->get_package_name($trans_details->pack_id);

                    $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="delete_trans_detail_pack('."'".$trans_id."'".', '."'".$trans_details->pack_id."'".')" disabled><i class="fa fa-trash"></i></a>';
                }
                else if ($trans_details->prod_type == 0) // if prod_type is individual product
                {
                    $item_id = 'P' . $trans_details->prod_id;
                    $item_name = $this->products->get_product_name($trans_details->prod_id);

                    $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="delete_trans_detail_prod('."'".$trans_id."'".', '."'".$trans_details->prod_id."'".')" disabled><i class="fa fa-trash"></i></a>';
                }
                else if ($trans_details->prod_type == 2) // if prod_type is package product
                {   
                    $item_id = 'P' . $trans_details->prod_id;
                    $item_name = $this->products->get_product_name($trans_details->prod_id);

                    $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="delete_trans_detail_prod('."'".$trans_id."'".', '."'".$trans_details->prod_id."'".')" disabled><i class="fa fa-trash"></i></a>';
                }
            }
            

            $row[] = $item_id;
            $row[] = '<b>' . $item_name . '</b>';

            $row[] = $trans_details->price;
            $row[] = $trans_details->qty;
            $row[] = '<b>' . $trans_details->total . '</b>';

            //add html for action
            $row[] = $void_btn;

            $prod_type = $trans_details->prod_type;
            
            if ($prod_type == 0 || $prod_type == 2) // if prod_type is individual product or package product only
            {
                $item_count += $trans_details->qty;
            }

            $row[] = $prod_type;
            $row[] = $trans_details->part_of;
            $row[] = $item_count;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->trans_details->count_all($trans_id),
                        "recordsFiltered" => $this->trans_details->count_filtered($trans_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_refund($trans_id) // get all that belongs to this ID via foreign key
    {
        $list = $this->trans_details_refund->get_datatables($trans_id);
        $data = array();
        $no = $_POST['start'];

        $item_count = 0; // initialize number of items counter
        $transactions_data = $this->transactions->get_by_id($trans_id);

        $status = $transactions_data->status;

        foreach ($list as $trans_details) {
            $no++;
            $row = array();

            if ($trans_details->prod_type == 1) // if prod_type is package
            {
                $item_id = 'G' . $trans_details->pack_id;
                $item_name = $this->packages->get_package_name($trans_details->pack_id);

                $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="refund_trans_detail_pack('."'".$trans_id."'".', '."'".$trans_details->pack_id."'".')"><i class="fa fa-trash"></i></a>';
            }
            else if ($trans_details->prod_type == 0) // if prod_type is individual product
            {
                $item_id = 'P' . $trans_details->prod_id;
                $item_name = $this->products->get_product_name($trans_details->prod_id);

                $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="refund_trans_detail_prod('."'".$trans_id."'".', '."'".$trans_details->prod_id."'".')"><i class="fa fa-trash"></i></a>';
            }
            else if ($trans_details->prod_type == 2) // if prod_type is package product
            {   
                $item_id = 'P' . $trans_details->prod_id;
                $item_name = $this->products->get_product_name($trans_details->prod_id);

                $void_btn = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Void" onclick="refund_trans_detail_prod_pack('."'".$trans_id."'".', '."'".$trans_details->prod_id."'".')" disabled><i class="fa fa-trash"></i></a>';
            }  
            

            $row[] = $item_id;
            $row[] = '<b>' . $item_name . '</b>';

            $row[] = $trans_details->price;
            $row[] = $trans_details->qty;
            $row[] = '<b>' . $trans_details->total . '</b>';

            //add html for action
            $row[] = $void_btn;

            $prod_type = $trans_details->prod_type;
            
            if ($prod_type == 0 || $prod_type == 2) // if prod_type is individual product or package product only
            {
                $item_count += $trans_details->qty;
            }

            $row[] = $prod_type;
            $row[] = $trans_details->part_of;
            $row[] = $item_count;

            $row[] = $trans_details->refunded;
    
            $data[] = $row;
        }
    
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->trans_details_refund->count_all($trans_id),
                        "recordsFiltered" => $this->trans_details_refund->count_filtered($trans_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    // public function ajax_edit($trans_id, $prod_id)
    // {
    //     $data = $this->trans_details->get_by_id($trans_id, $prod_id);
    //     echo json_encode($data);
    // }
 
    public function ajax_set_payment() // set payment function
    {
        $trans_id = $this->input->post('trans_id');

        $receipt_no = $this->transactions->get_last_receipt_no() + 1; // set transaction's receipt number (add 1 to max receipt value)

        $method = $this->input->post('method');
        if ($method == 'Cash') // if method is Cash
        {
            $cash_amt = $this->input->post('cash_amt');
        }
        else // if Credit Card or Cash Card
        {
            $cash_amt = $this->input->post('amount_due'); // if method is not cash, set cash as amount due (result: no change amount)
        }

        $card_number = $this->input->post('card_number');
        if ($card_number == '') // set as n/a if empty
        {
            $card_number = 'n/a';
        }

        $cust_name = $this->input->post('cust_name');
        if ($cust_name == '') // set as n/a if empty
        {
            $cust_name = 'n/a';
        }

        $this->_validate_payment();

        $data = array(
                'status' => 'CLEARED',

                'cash_amt' => $cash_amt,
                'change_amt' => ($cash_amt - $this->input->post('amount_due')),

                'method' => $method,
                
                'card_number' => $card_number,
                'cust_name' => $cust_name,

                'cashier_id' => $this->session->userdata('user_id'),

                'receipt_no' => $receipt_no

            );
        $this->transactions->update(array('trans_id' => $trans_id), $data);
        
        

        $trans_details_items = $this->trans_details->get_trans_detail_items($trans_id); // get all trans_details items (products, packages, package products)

        foreach ($trans_details_items as $items) // update sold of each items
        {
            $qty = $items->qty; // get qty to use as sold value to update

            if ($items->prod_type == 0) // if prod_type is individual product
            {
                $this->products->update_sold_prod($items->prod_id, $qty);
            }
            else if ($items->prod_type == 1) // if prod_type is package
            {
                $this->packages->update_sold_pack($items->pack_id, $qty);
            }
            else if ($items->prod_type == 2) // if prod_type is package product
            {
                $this->products->update_sold_pack_prod($items->prod_id, $qty);
            }
        }

        $this->set_transaction_receipt($trans_id, "payment", $receipt_no); // print receipt upon clearing out the transaction

        $this->table_groups->delete_by_trans_id($trans_id);


        // add transaction to trans_logs record --------------------------------------------------------

        $log_type = 'Payment';

        $details = 'Transaction payment S' . $trans_id . ' RCPT#: ' . $receipt_no;

        $this->add_trans_log($log_type, $details, $this->session->userdata('username'));

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_set_discount() // set payment function
    {
        $trans_id = $this->input->post('trans_id');

        $cust_name = $this->input->post('cust_name');

        if ($cust_name == '') // set as n/a if empty
        {
            $cust_name = 'n/a';
        }

        $disc_type = $this->input->post('disc_type');
        $discount = $this->input->post('discount');
        $cust_disc_id = $this->input->post('cust_disc_id');

        if ($disc_type == 0)
        {
            $discount = 0;
            $cust_disc_id = 'n/a';
        }

        $this->_validate_discount();

        $data = array(
                'disc_type' => $disc_type,

                'discount' => $discount,

                'cust_disc_id' => $cust_disc_id,
                
                'cust_name' => $cust_name
            );
        $this->transactions->update(array('trans_id' => $trans_id), $data);


        // add transaction to trans_logs record --------------------------------------------------------

        $log_type = 'Discount';

        $details = 'Transaction discounted S' . $trans_id . ' by U' . $this->session->userdata('user_id');

        $this->add_trans_log($log_type, $details, $this->session->userdata('username'));

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_set_cancel($trans_id) // set cancel function
    {
        $status = 'CANCELLED';
        $cashier_id = $this->session->userdata('user_id');

        $data = array(
                'status' => $status,
                'cashier_id' => $cashier_id
            );
        $this->transactions->update(array('trans_id' => $trans_id), $data);

        $this->table_groups->delete_by_trans_id($trans_id);

        // add transaction to trans_logs record --------------------------------------------------------

        $log_type = 'Cancel';

        $details = 'Transaction cancelled S' . $trans_id . ' by U' . $this->session->userdata('user_id');

        $this->add_trans_log($log_type, $details, $this->session->userdata('username'));


        echo json_encode(array("status" => TRUE));
    }

    public function reset_is_updated($trans_id) // reset is_updated to false whenever page is loaded or refreshed
    {
        $is_updated = 0; // set to false

        $data = array(
                'is_updated' => $is_updated,
            );
        $this->transactions->update(array('trans_id' => $trans_id), $data);
    }
 
    // public function ajax_update()
    // {
    //     $this->_validate_qty_only();
    //     $data = array(
    //             'qty' => $this->input->post('qty'),
    //         );
        // $this->trans_details->update(array('trans_id' => $this->input->post('trans_id'), 'prod_id' => $this->input->post('current_prod_id')), $data); // update record with multiple where clause
        // echo json_encode(array("status" => TRUE));
    // }

    // delete a record
    public function ajax_delete_prod($trans_id, $prod_id)
    {
        $this->trans_details->delete_by_id_prod($trans_id, $prod_id);

        // add transaction to trans_logs record --------------------------------------------------------

        $log_type = 'Void';

        $details = 'Item void S' . $trans_id . ' by U' . $this->session->userdata('user_id') . ' - Product: P' . $prod_id;

        $this->add_trans_log($log_type, $details, $this->session->userdata('username'));

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete_pack($trans_id, $pack_id)
    {
        $this->trans_details->delete_by_id_pack($trans_id, $pack_id);

        // add transaction to trans_logs record --------------------------------------------------------

        $log_type = 'Void';

        $details = 'Item void S' . $trans_id . ' by U' . $this->session->userdata('user_id') . ' - Package: G' . $pack_id;

        $this->add_trans_log($log_type, $details, $this->session->userdata('username'));

        echo json_encode(array("status" => TRUE));
    }

    private function _validate_payment()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('method') == 'Cash') // if payment method is cash
        {
            if($this->input->post('cash_amt') == '')
            {
                $data['inputerror'][] = 'cash_amt';
                $data['error_string'][] = 'Cash amount is required';
                $data['status'] = FALSE;
            }
            else if($this->input->post('cash_amt') <= 0)
            {
                $data['inputerror'][] = 'cash_amt';
                $data['error_string'][] = 'Cash amount value should be greater than zero';
                $data['status'] = FALSE;
            }
            else if($this->input->post('cash_amt') < $this->input->post('amount_due'))
            {
                $data['inputerror'][] = 'cash_amt';
                $data['error_string'][] = 'Cash amount value should be equal or greater than amount due';
                $data['status'] = FALSE;
            }
        }
        // if payment method is credit card or cash card
        else
        {
            if($this->input->post('card_number') == '')
            {
                $data['inputerror'][] = 'card_number';
                $data['error_string'][] = 'Card number is required';
                $data['status'] = FALSE;
            }
            else if(strpos($this->input->post('card_number'), '\'') !== false)
            {
                $data['inputerror'][] = 'card_number';
                $data['error_string'][] = 'Invalid character input: ( \' )';
                $data['status'] = FALSE;
            }
            else if(strpos($this->input->post('card_number'), '"') !== false)
            {
                $data['inputerror'][] = 'card_number';
                $data['error_string'][] = 'Invalid character input: ( " )';
                $data['status'] = FALSE;
            }

            if(strpos($this->input->post('cust_name'), '\'') !== false)
            {
                $data['inputerror'][] = 'cust_name';
                $data['error_string'][] = 'Invalid character input: ( \' )';
                $data['status'] = FALSE;
            }
            else if(strpos($this->input->post('cust_name'), '"') !== false)
            {
                $data['inputerror'][] = 'cust_name';
                $data['error_string'][] = 'Invalid character input: ( " )';
                $data['status'] = FALSE;
            }  
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_discount()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('disc_type') == '')
        {
            $data['inputerror'][] = 'disc_type';
            $data['error_string'][] = 'Discount type is required';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('disc_type') != 0)
        {
            if($this->input->post('discount') == '')
            {
                $data['inputerror'][] = 'discount';
                $data['error_string'][] = 'Actual discount amount is required';
                $data['status'] = FALSE;
            }
            else if($this->input->post('discount') <= 0)
            {
                $data['inputerror'][] = 'discount';
                $data['error_string'][] = 'Actual discount amount should be greater than zero';
                $data['status'] = FALSE;
            }
            else if($this->input->post('discount') > $this->input->post('gross_total'))
            {
                $data['inputerror'][] = 'discount';
                $data['error_string'][] = 'Discount amount should be equal or less than gross_total';
                $data['status'] = FALSE;
            }

            if($this->input->post('cust_disc_id') == '')
            {
                $data['inputerror'][] = 'cust_disc_id';
                $data['error_string'][] = 'Customer ID number is required';
                $data['status'] = FALSE;
            }
            else if(strpos($this->input->post('cust_disc_id'), '\'') !== false)
            {
                $data['inputerror'][] = 'cust_disc_id';
                $data['error_string'][] = 'Invalid character input: ( \' )';
                $data['status'] = FALSE;
            }
            else if(strpos($this->input->post('cust_disc_id'), '"') !== false)
            {
                $data['inputerror'][] = 'cust_disc_id';
                $data['error_string'][] = 'Invalid character input: ( " )';
                $data['status'] = FALSE;
            }

            if(strpos($this->input->post('cust_name'), '\'') !== false)
            {
                $data['inputerror'][] = 'cust_name';
                $data['error_string'][] = 'Invalid character input: ( \' )';
                $data['status'] = FALSE;
            }
            else if(strpos($this->input->post('cust_name'), '"') !== false)
            {
                $data['inputerror'][] = 'cust_name';
                $data['error_string'][] = 'Invalid character input: ( " )';
                $data['status'] = FALSE;
            }
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }


    // ================================================ API GET REQUEST METHOD ============================================


    public function ajax_api_list($trans_id) // get all that belongs to this ID via foreign key
    {
        // ------------------------------------------- Details ----------------------------------------

        $transactions_data = $this->transactions->get_by_id($trans_id);

        $gross_total = $this->trans_details->get_trans_gross($trans_id);

        $details_data = array();

        $details_data['order_type'] = $transactions_data->order_type;
        $details_data['user_id'] = $transactions_data->user_id;

        $details_data['status'] = $transactions_data->status;

        $discount = $transactions_data->discount;

        $net_total = $gross_total - $discount;

        $details_data['gross_total'] = $gross_total;
        $details_data['discount'] = $discount;
        $details_data['net_total'] = $net_total;
        $details_data['is_billout_printed'] = $transactions_data->is_billout_printed;


        // ------------------------------------------- Products/Package ---------------------------------

        $list = $this->trans_details->get_api_datatables($trans_id);
        $prod_data = array();
        $pack_data = array();
        
        foreach ($list as $trans_details) {

            if ($trans_details->prod_type == 1) // if prod_type is package
            {
                $row = array();

                $item_id = $trans_details->pack_id;
                $item_name = $this->packages->get_package_name($trans_details->pack_id);
                $item_short_name = $this->packages->get_package_short_name($trans_details->pack_id);
                $img = $this->packages->get_package_img($trans_details->pack_id);

                $row['pack_id'] = $item_id;
                $row['name'] = $item_name;
                $row['short_name'] = $item_short_name;
                $row['img'] = $img;

                $row['price'] = $trans_details->price;
                $row['qty'] = $trans_details->qty;
                $row['total'] = $trans_details->total;


                // get package product list ---------------------------------------------------------
                $pack_prod_data = array();

                $pack_products = $this->pack_details->get_pack_detail_products($item_id);

                // get each product of the package -----------------------------------------------------              
                
                foreach ($pack_products as $pack_products_list)
                {
                    $pack_prod_row = array();

                    $pack_prod_id = $pack_products_list->prod_id;
                    $pack_prod_name = $this->products->get_product_name($pack_prod_id);
                    $pack_prod_short_name = $this->products->get_product_short_name($pack_prod_id);
                    $pack_prod_qty = ($pack_products_list->qty * $trans_details->qty); // multiply package product qty by pack_qty

                    $pack_prod_row['pack_prod_id'] = $pack_prod_id;
                    $pack_prod_row['pack_prod_name'] = $pack_prod_name;
                    $pack_prod_row['pack_prod_short_name'] = $pack_prod_short_name;
                    $pack_prod_row['pack_prod_qty'] = $pack_prod_qty;

                    $pack_prod_data[] = $pack_prod_row;
                }

                $row['package_products'] = $pack_prod_data;


                $pack_data[] = $row;

            }
            else if ($trans_details->prod_type == 0) // if prod_type is individual product
            {
                $row = array();

                $item_id = $trans_details->prod_id;
                $item_name = $this->products->get_product_name($trans_details->prod_id);
                $item_short_name = $this->products->get_product_short_name($trans_details->prod_id);
                $cat_id = $this->products->get_product_cat_id($trans_details->prod_id);
                $img = $this->products->get_product_img($trans_details->prod_id);

                $row['prod_id'] = $item_id;
                $row['name'] = $item_name;
                $row['short_name'] = $item_short_name;
                $row['cat_id'] = $cat_id;
                $row['img'] = $img;

                $row['price'] = $trans_details->price;
                $row['qty'] = $trans_details->qty;
                $row['total'] = $trans_details->total;

                $prod_data[] = $row;
            }
        }

        // ------------------------------------------- Tables ---------------------------------

        $tables = $this->table_groups->get_table_group_tables($trans_id);
        $tables_data = array();

        if ($tables->num_rows() != 0)
        {
            foreach ($tables->result() as $tables_list) 
            {
                $row = array();

                $row['table_id'] = $tables_list->tbl_id;

                if ($tables_list->tbl_id == 0)
                {
                    $row['name'] = 'No Table';
                }
                else
                {
                    $row['name'] = $this->tables->get_table_name($tables_list->tbl_id);
                }

                $tables_data[] = $row;
            }
        }
 
        $output = array(
                        "details" => $details_data,
                        "products" => $prod_data,
                        "packages" => $pack_data,
                        "tables" => $tables_data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_api_list_by_receipt_no($receipt_no) // get all that belongs to this ID via foreign key
    {
        // ------------------------------------------- Details ----------------------------------------

        $transactions_data = $this->transactions->get_by_receipt_no($receipt_no);

        if ($transactions_data == null)
        {
            echo json_encode(null); // if receipt no is not found
        }
        else
        {
            $trans_id = $transactions_data->trans_id;

            $gross_total = $this->trans_details->get_trans_gross($trans_id);

            $details_data = array();

            $details_data['order_type'] = $transactions_data->order_type;
            $details_data['user_id'] = $transactions_data->user_id;

            $details_data['status'] = $transactions_data->status;

            $discount = $transactions_data->discount;

            $net_total = $gross_total - $discount;

            $details_data['gross_total'] = $gross_total;
            $details_data['discount'] = $discount;
            $details_data['net_total'] = $net_total;
            $details_data['is_billout_printed'] = $transactions_data->is_billout_printed;
            $details_data['receipt_no'] = $transactions_data->receipt_no;


            // ------------------------------------------- Products/Package ---------------------------------

            $list = $this->trans_details->get_api_datatables($trans_id);
            $prod_data = array();
            $pack_data = array();
            
            foreach ($list as $trans_details) {

                if ($trans_details->prod_type == 1) // if prod_type is package
                {
                    $row = array();

                    $item_id = $trans_details->pack_id;
                    $item_name = $this->packages->get_package_name($trans_details->pack_id);
                    $item_short_name = $this->packages->get_package_short_name($trans_details->pack_id);
                    $img = $this->packages->get_package_img($trans_details->pack_id);

                    $row['pack_id'] = $item_id;
                    $row['name'] = $item_name;
                    $row['short_name'] = $item_short_name;
                    $row['img'] = $img;

                    $row['price'] = $trans_details->price;
                    $row['qty'] = $trans_details->qty;
                    $row['total'] = $trans_details->total;


                    // get package product list ---------------------------------------------------------
                    $pack_prod_data = array();

                    $pack_products = $this->pack_details->get_pack_detail_products($item_id);

                    // get each product of the package -----------------------------------------------------              
                    
                    foreach ($pack_products as $pack_products_list)
                    {
                        $pack_prod_row = array();

                        $pack_prod_id = $pack_products_list->prod_id;
                        $pack_prod_name = $this->products->get_product_name($pack_prod_id);
                        $pack_prod_short_name = $this->products->get_product_short_name($pack_prod_id);
                        $pack_prod_qty = ($pack_products_list->qty * $trans_details->qty); // multiply package product qty by pack_qty

                        $pack_prod_row['pack_prod_id'] = $pack_prod_id;
                        $pack_prod_row['pack_prod_name'] = $pack_prod_name;
                        $pack_prod_row['pack_prod_short_name'] = $pack_prod_short_name;
                        $pack_prod_row['pack_prod_qty'] = $pack_prod_qty;

                        $pack_prod_data[] = $pack_prod_row;
                    }

                    $row['package_products'] = $pack_prod_data;


                    $pack_data[] = $row;

                }
                else if ($trans_details->prod_type == 0) // if prod_type is individual product
                {
                    $row = array();

                    $item_id = $trans_details->prod_id;
                    $item_name = $this->products->get_product_name($trans_details->prod_id);
                    $item_short_name = $this->products->get_product_short_name($trans_details->prod_id);
                    $cat_id = $this->products->get_product_cat_id($trans_details->prod_id);
                    $img = $this->products->get_product_img($trans_details->prod_id);

                    $row['prod_id'] = $item_id;
                    $row['name'] = $item_name;
                    $row['short_name'] = $item_short_name;
                    $row['cat_id'] = $cat_id;
                    $row['img'] = $img;

                    $row['price'] = $trans_details->price;
                    $row['qty'] = $trans_details->qty;
                    $row['total'] = $trans_details->total;

                    $prod_data[] = $row;
                }
            }

            // ------------------------------------------- Tables ---------------------------------

            $tables = $this->table_groups->get_table_group_tables($trans_id);
            $tables_data = array();

            if ($tables->num_rows() != 0)
            {
                foreach ($tables->result() as $tables_list) 
                {
                    $row = array();

                    $row['table_id'] = $tables_list->tbl_id;

                    if ($tables_list->tbl_id == 0)
                    {
                        $row['name'] = 'No Table';
                    }
                    else
                    {
                        $row['name'] = $this->tables->get_table_name($tables_list->tbl_id);
                    }

                    $tables_data[] = $row;
                }
            }
            
            $output = array(
                            "details" => $details_data,
                            "products" => $prod_data,
                            "packages" => $pack_data,
                            "tables" => $tables_data,
                    );
            //output to json format
            echo json_encode($output);
        }
    }


    // ================================================ API POST REQUEST METHOD ============================================


    public function ajax_set_payment_api() // set payment function (OVER THE COUNTER TRANSACTIONS USING TABLET)
    {

        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);
        // $ready = $request->ready;
        $array = json_decode(json_encode($request), true);
        
        $line_items = array();

        foreach ($array as $transaction) 
        {
            foreach ($transaction['details'] as $details)
            {
                // insert new transaction ------------------------------------------------

                $discount = $details['discount'];
                $disc_type = $details['disc_type']; // discount type id

                $order_type = $details['order_type'];

                $method = $details['method'];

                $cash_amt = $details['cash_amt'];

                $card_number = $details['card_number'];
                $cust_name = $details['cust_name'];

                $user_id = $details['user_id'];
                $staff_username = $this->users->get_username($user_id);

                $cashier_id = $details['cashier_id'];
                
                $amount_due = $details['amount_due'];

                $receipt_no = $details['receipt_no'];


                if ($method == 'Cash') // if method is Cash
                {
                    $cash_amt = $cash_amt;
                }
                else // if Credit Card or Cash Card
                {
                    $cash_amt = $amount_due; // if method is not cash, set cash as amount due (result: no change amount)
                }

                if ($card_number == '') // set as n/a if empty
                {
                    $card_number = 'n/a';
                }

                if ($cust_name == '') // set as n/a if empty
                {
                    $cust_name = 'n/a';
                }

                $data = array(
                        'datetime' => date("Y-m-d H:i:s"),

                        'discount' => $discount,
                        'disc_type' => $disc_type,

                        'status' => 'CLEARED',

                        'order_type' => $order_type,

                        'method' => $method,

                        'cash_amt' => $cash_amt,
                        'change_amt' => ($cash_amt - $amount_due),

                        'card_number' => $card_number,
                        'cust_name' => $cust_name,

                        'user_id' => $user_id,
                        'cashier_id' => $cashier_id,

                        'receipt_no' => $receipt_no
                    );
                    
                $insert = $this->transactions->save($data);
            }
            
            // end insert new transaction ------------------------------------------------

            $trans_id = $insert; // get the new trans_id

            // get each product for trans_details  ------------------------------------------------

            foreach ($transaction['products'] as $products)
            {
                $prod_id = $products['prod_id'];
                $prod_name = $this->products->get_product_short_name($prod_id);
                $prod_price = $this->products->get_product_price($prod_id);
                $prod_qty = $products['qty'];

                // check if product is discounted
                $check_discount = $this->prod_discounts->get_by_prod_id($prod_id);

                if ($check_discount != null)
                {
                    $new_price = $check_discount->new_price;

                    $prod_price = $new_price;

                    $prod_name = $prod_name . "*"; // discounted product indicator
                }

                $prod_total = ($prod_price * $prod_qty);

                // insert new product to trans_details ---------------------------------------------

                $data_products = array(
                    'trans_id' => $trans_id,
                    'prod_id' => $prod_id,

                    'prod_type' => 0, // 0 - individual product

                    'price' => $prod_price,
                    'qty' => $prod_qty,

                    'total' => $prod_total
                );
                $this->trans_details->save($data_products);

                // add line item to line_items array
                $line_items[] = new item($prod_qty . " " . $prod_name . " @" . $prod_price, number_format($prod_total, 2));
            }

            // get each package for trans_details  ------------------------------------------------

            foreach ($transaction['packages'] as $packages)
            {
                $pack_id = $packages['pack_id'];
                $pack_name = $this->packages->get_package_short_name($pack_id);
                $pack_price = $this->packages->get_package_price($pack_id);
                $pack_qty = $packages['qty'];

                // check if product is discounted
                $check_discount = $this->pack_discounts->get_by_pack_id($pack_id);

                if ($check_discount != null)
                {
                    $new_price = $check_discount->new_price;

                    $pack_price = $new_price;

                    $pack_name = $pack_name . "*"; // discounted product indicator
                }

                $pack_total = ($pack_price * $pack_qty);

                // insert new package to trans_details ---------------------------------------------

                $data_packages = array(
                    'trans_id' => $trans_id,
                    'pack_id' => $pack_id,

                    'prod_type' => 1, // 1 - package

                    'price' => $pack_price,
                    'qty' => $pack_qty,

                    'total' => $pack_total
                );
                $this->trans_details->save($data_packages);

                // add line item to line_items array
                $line_items[] = new item($pack_qty . " " . $pack_name . " @" . $pack_price, number_format($pack_total, 2));

                // get package product list ---------------------------------------------------------

                $pack_products = $this->pack_details->get_pack_detail_products($pack_id);

                // get each product of the package -----------------------------------------------------              
                
                foreach ($pack_products as $pack_products_list)
                {
                    $pack_prod_id = $pack_products_list->prod_id;
                    $pack_prod_name = $this->products->get_product_short_name($pack_prod_id);
                    $pack_prod_qty = ($pack_products_list->qty * $pack_qty); // multiply package product qty by pack_qty

                    // insert new product to trans_details (from package products) ------------------------

                    $data_pack_products = array(
                        'trans_id' => $trans_id,
                        'prod_id' => $pack_prod_id,

                        'prod_type' => 2, // 2 - package product

                        'price' => 0,
                        'qty' => $pack_prod_qty,

                        'total' => 0,
                        'part_of' => $pack_id 
                    );
                    $this->trans_details->save($data_pack_products);

                    // add line item to line_items array
                    $line_items[] = new item("   " . $pack_prod_qty . " " . $pack_prod_name, "");
                }
            }

            // get each table for table_groups -------------------------------------------------------------

            $line_tables = array();

            foreach ($transaction['tables'] as $tables)
            {
                // insert new table to table_groups -------------------------------------------------------
                $tbl_id = $tables['tbl_id'];

                if ($tbl_id != 0)
                {
                    $tbl_name = $this->tables->get_table_name($tbl_id);    
                }
                else
                {
                    $tbl_name = 'No Table';
                }
                

                $data_tables = array(
                    'trans_id' => $trans_id,
                    'tbl_id' => $tbl_id,
                );
                $this->table_groups->save($data_tables);

                $line_tables[] = $tbl_name;
            }

            if (sizeof($line_tables) != 0)
            {
                $table_str = implode(', ', $line_tables);
            }
            else
            {
                $table_str = 'n/a';
            }

        }

        echo json_encode(array("status" => TRUE));
        
        
        $this->table_groups->delete_by_trans_id($trans_id);

        $trans_details_items = $this->trans_details->get_trans_detail_items($trans_id); // get all trans_details items (products, packages, package products)

        foreach ($trans_details_items as $items) // update sold of each items
        {
            $qty = $items->qty; // get qty to use as sold value to update

            if ($items->prod_type == 0) // if prod_type is individual product
            {
                $this->products->update_sold_prod($items->prod_id, $qty);
            }
            else if ($items->prod_type == 1) // if prod_type is package
            {
                $this->packages->update_sold_pack($items->pack_id, $qty);
            }
            else if ($items->prod_type == 2) // if prod_type is package product
            {
                $this->products->update_sold_pack_prod($items->prod_id, $qty);
            }
        }

        echo json_encode(array("status" => TRUE));
    }


    // ================================================ PRINT RECEIPT SECTION ==============================================


    public function set_transaction_receipt($trans_id, $print_type, $receipt_no) // setting transaction receipt via trans_id (can be used to print bill out or final receipts)
    {
        $transactions_data = $this->transactions->get_by_id($trans_id);

        $gross_total = $this->trans_details->get_trans_gross($trans_id);

        $order_type = $transactions_data->order_type;

        $user_id = $transactions_data->user_id;
        $staff_username = $this->users->get_username($user_id);

        $cashier_id = $transactions_data->cashier_id;

        if ($cashier_id != 0)
        {
            $cashier_username = $this->users->get_username($cashier_id);    
        }
        else
        {
            $cashier_username = 'n/a';   
        }
        

        $discount = $transactions_data->discount;
        $disc_type = $transactions_data->disc_type;

        if ($disc_type != 0)
        {
            $disc_type_name = $this->discounts->get_discount_name($disc_type);
        }
        else
        {
            $disc_type_name = 'n/a';   
        }

        $net_total = $gross_total - $discount;

        $cash_amt = $transactions_data->cash_amt;
        $change_amt = $transactions_data->change_amt;

        // ------------------------------------------- Products/Package ---------------------------------

        $trans_details_items = $this->trans_details->get_trans_detail_items($trans_id); // get all trans_details items (products, packages, package products)

        $line_items = array();

        foreach ($trans_details_items as $items) // get each line item details to print
        {
            if ($items->prod_type == 0) // if prod_type is individual product
            {
                $prod_id = $items->prod_id;
                $prod_name = $this->products->get_product_short_name($prod_id);
                $prod_price = $items->price;
                $prod_qty = $items->qty;

                $prod_total = ($prod_price * $prod_qty);

                // add line item to line_items array
                $line_items[] = new item($prod_qty . " " . $prod_name . " @" . $prod_price, number_format($prod_total, 2));
            }
            else if ($items->prod_type == 1) // if prod_type is package
            {
                $pack_id = $items->pack_id;
                $pack_name = $this->packages->get_package_short_name($pack_id);
                $pack_price = $items->price;
                $pack_qty = $items->qty;

                $pack_total = ($pack_price * $pack_qty);

                // add line item to line_items array
                $line_items[] = new item($pack_qty . " " . $pack_name . " @" . $pack_price, number_format($pack_total, 2));
            }
            else if ($items->prod_type == 2) // if prod_type is package product
            {
                $pack_prod_id = $items->prod_id;
                $pack_prod_name = $this->products->get_product_short_name($pack_prod_id);
                $pack_prod_qty = $items->qty;

                // add line item to line_items array
                $line_items[] = new item("   " . $pack_prod_qty . " " . $pack_prod_name, "");
            }
        }

        // ------------------------------------------- Tables ---------------------------------

        $tables = $this->table_groups->get_table_group_tables($trans_id);
        $line_tables = array();

        if ($tables->num_rows() != 0)
        {
            foreach ($tables->result() as $tables_list) 
            {
                $tbl_id = $tables_list->tbl_id;

                if ($tbl_id == 0)
                {
                    $tbl_name = 'No Table';
                }
                else
                {
                    $tbl_name = $this->tables->get_table_name($tbl_id);
                }

                $line_tables[] = $tbl_name;
            }
        }
        
        if (sizeof($line_tables) != 0)
        {
            $table_str = implode(', ', $line_tables);
        }
        else
        {
            $table_str = 'n/a';
        }

        // printing payment type receipts
        if ($print_type == "payment")
        {
            $this->print_payment_receipt($line_items, $order_type, $trans_id, $staff_username, $cashier_username, $table_str, $gross_total, $discount, $disc_type_name, $cash_amt, $change_amt, $receipt_no);
        }
        else // billout receipts
        {
            $data = array(
                    'is_billout_printed' => 1, // set is_billout_printed to true when bill out is printed
                );
            $this->transactions->update(array('trans_id' => $trans_id), $data);

            $this->print_bill_out_receipt($line_items, $order_type, $trans_id, $staff_username, $table_str, $gross_total, $discount, $disc_type_name);
        }
        
    }



    // ================================================ RECEIPT FORMATTING SECTION ============================================================


    public function print_payment_receipt($line_items, $order_type, $trans_id, $staff_username, $cashier_username, $table_str, $gross_total, $discount, $disc_type_name, $cash_amt, $change_amt, $receipt_no)
    {

        /* Open the printer; this will change depending on how it is connected */
        $connector = new WindowsPrintConnector("epsontmu");
        $printer = new Printer($connector);

        // $logo = EscposImage::load("cafe.png", false);


        // fetch config data
        $store = $this->store->get_by_id(1); // set 1 as ID since there is only 1 config entry


        /* Information for the receipt */
        $store_name = wordwrap($store->name, 15, "\n");
        $address = wordwrap($store->address, 25, "\n");
        $city = wordwrap($store->city, 25, "\n");
        $tin = wordwrap($store->tin, 25, "\n");
        $telephone = wordwrap('Tel#: ' . $store->telephone, 25, "\n");
        $mobile = wordwrap('Cel#: ' . $store->mobile, 25, "\n");
        $date = date('D, j F Y h:i A'); // format: Wed, 4 July 2018 11:20 AM
        $vat = ($store->vat / 100);

        $items = $line_items;
        
        $total_sales = ($gross_total / (1 + $vat));

        $vat_amount = ($gross_total - $total_sales);

        $amount_due = ($gross_total - $discount);


        // string variables
        $total_sales_str = new item('Total Sales', number_format($total_sales, 2));
        $vat_str = new item('Vat', number_format($vat_amount, 2));

        $discount_str = new item('Less: ' . $disc_type_name, "-" . number_format($discount, 2));

        $amount_due_str = new item('Amount Due       Php', number_format($amount_due, 2));
        $cash_amt_str = new item('CASH             Php', number_format($cash_amt, 2));
        $change_amt_str = new item('CHANGE           Php', number_format($change_amt, 2));

        $printer -> pulse();

        /* Print top logo */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        // $printer -> graphics($logo);

        /* Name of shop */
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($store_name . "\n");
        $printer -> selectPrintMode();
        $printer -> text($address . "\n");
        $printer -> text($city . "\n");
        $printer -> text($telephone . "\n");
        $printer -> text($mobile . "\n");
        $printer -> text($tin . "\n");

        $printer -> text(str_pad("", 30, '*', STR_PAD_BOTH) . "\n");
        $printer -> text($table_str . "\n");
        $printer -> text(str_pad("", 30, '*', STR_PAD_BOTH) . "\n");

        /* Title of receipt */
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($order_type . "\n");
        $printer -> selectPrintMode();

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text(new item('Transaction#: ' . $trans_id, ''));
        $printer -> text(new item('Receipt#: ' . $receipt_no, ''));
        $printer -> text(new item('Staff: ' . $staff_username, ''));
        $printer -> text(new item('Cashier: ' . $cashier_username, ''));

        $printer -> text(str_pad("", 33, '=', STR_PAD_BOTH) . "\n");

        /* Items */
        $printer -> setEmphasis(true);
        $printer -> text(new item('', 'Php'));
        $printer -> setEmphasis(false);
        foreach ($items as $item) {
            $printer -> text($item);
        }

        $printer -> text(str_pad("", 33, '=', STR_PAD_BOTH) . "\n");

        $printer -> setEmphasis(true);
        $printer -> text($total_sales_str);
        /* Tax and total */
        $printer -> text($vat_str);


        if ($discount != 0) // print only if there is a discount (not zero)
        {
            $printer -> text($discount_str);
        }

        $printer -> setEmphasis(false);

        $printer -> setEmphasis(true);
        $printer -> text(new item('', '========='));
        
        $printer -> text($amount_due_str);

        // ------------------------------------------ PAYMENT RECEIPT PRINTS --------------------------------------------------

        $printer -> text($cash_amt_str);
        $printer -> text($change_amt_str);        

        $printer -> setEmphasis(false);
        
        // --------------------------------------------------------------------------------------------------------------------

        /* Footer */
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text($date . "\n");

        $printer -> feed();
        $printer -> text("Innotech Solutions\n");
        $printer -> text("Thank You Come Again\n");
        $printer -> text(str_pad("", 33, '_', STR_PAD_BOTH) . "\n");
        
        /* Cut the receipt and open the cash drawer */
        $printer -> cut();

        $printer -> close();
    }

    public function print_bill_out_receipt($line_items, $order_type, $trans_id, $staff_username, $table_str, $gross_total, $discount, $disc_type_name)
    {
        /* Open the printer; this will change depending on how it is connected */
        $connector = new WindowsPrintConnector("epsontmu");
        $printer = new Printer($connector);

        // $logo = EscposImage::load("cafe.png", false);


        // fetch config data
        $store = $this->store->get_by_id(1); // set 1 as ID since there is only 1 config entry


        /* Information for the receipt */
        $store_name = wordwrap("BILL OUT", 15, "\n");

        $date = date('D, j F Y h:i A'); // format: Wed, 4 July 2018 11:20 AM
        $vat = ($store->vat / 100);

        $items = $line_items;
        
        $total_sales = ($gross_total / (1 + $vat));

        $vat_amount = ($gross_total - $total_sales);

        $amount_due = ($gross_total - $discount);

        // string variables
        $total_sales_str = new item('Total Sales', number_format($total_sales, 2));
        $vat_str = new item('Vat', number_format($vat_amount, 2));

        $discount_str = new item('Less: ' . $disc_type_name, "-" . number_format($discount, 2));

        $amount_due_str = new item('Amount Due       Php', number_format($amount_due, 2));

        /* Print top logo */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        // $printer -> graphics($logo);

        /* Name of shop */
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($store_name . "\n");
        $printer -> selectPrintMode();

        $printer -> text(str_pad("", 30, '*', STR_PAD_BOTH) . "\n");
        $printer -> text($table_str . "\n");
        $printer -> text(str_pad("", 30, '*', STR_PAD_BOTH) . "\n");

        /* Title of receipt */
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($order_type . "\n");
        $printer -> selectPrintMode();

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text(new item('Transaction#: ' . $trans_id, ''));
        $printer -> text(new item('Staff: ' . $staff_username, ''));
        // $printer -> text(new item('Cashier: ' . $cashier_username, ''));

        $printer -> text(str_pad("", 33, '=', STR_PAD_BOTH) . "\n");

        /* Items */
        $printer -> setEmphasis(true);
        $printer -> text(new item('', 'Php'));
        $printer -> setEmphasis(false);
        foreach ($items as $item) {
            $printer -> text($item);
        }

        $printer -> text(str_pad("", 33, '=', STR_PAD_BOTH) . "\n");

        $printer -> setEmphasis(true);
        $printer -> text($total_sales_str);
        /* Tax and total */
        $printer -> text($vat_str);


        if ($discount != 0) // print only if there is a discount (not zero)
        {
            $printer -> text($discount_str);
        }

        $printer -> setEmphasis(false);

        $printer -> setEmphasis(true);
        $printer -> text(new item('', '========='));
        
        $printer -> text($amount_due_str);

        // ------------------------------------------ PAYMENT RECEIPT PRINTS -------------------------------------------------- 

        $printer -> setEmphasis(false);
        
        // --------------------------------------------------------------------------------------------------------------------

        /* Footer */
        $printer -> feed();

        $printer -> text(str_pad("", 33, '_', STR_PAD_BOTH) . "\n");
        
        /* Cut the receipt and open the cash drawer */
        $printer -> cut();

        $printer -> close();

        echo json_encode(array("status" => TRUE));
    }

    public function add_trans_log($log_type, $details, $user_name)
    {
        $data = array(

                'user_fullname' => $user_name,
                'log_type' => $log_type,
                'details' => $details
            );
        $insert = $this->trans_logs->save($data);
    }
 }



 /* A wrapper to do organise item names & prices into columns */
 class item
 {
     private $name;
     private $price;
     private $dollarSign;

     public function __construct($name = '', $price = '', $dollarSign = false)
     {
         $this -> name = $name;
         $this -> price = $price;
         $this -> dollarSign = $dollarSign;
     }

     public function __toString()
     {
         $rightCols = 9;
         $leftCols = 24;
         if ($this -> dollarSign) {
             $leftCols = $leftCols / 2 - $rightCols / 2;
         }
         $left = str_pad($this -> name, $leftCols) ;

         $sign = ($this -> dollarSign ? 'Php ' : '');
         $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
         return "$left$right\n";
     }
 }