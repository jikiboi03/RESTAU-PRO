<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'vendor/mike42/autoload.php');
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class Dashboard_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Store_config/Store_config_model','store');
        $this->load->model('Products/Products_model','products');
        $this->load->model('Packages/Packages_model','packages');

        $this->load->model('Trans_details/Trans_details_model','trans_details');
        $this->load->model('Store_config/Store_config_model','store');

        $this->load->model('Transactions/Transactions_model','transactions');
        $this->load->model('Readings/S_readings_model','s_readings');
        $this->load->model('Readings/X_readings_model','x_readings');

        $this->load->model('Logs/Trans_logs_model','trans_logs');
        $this->load->model('Pos/Pos_model','pos');

    }

    public function index()
    {						
        if ($this->session->userdata('user_id') == '')
        {
            redirect('error500');
        }
        
        $this->load->helper('url');

        $store = $this->store->get_by_id(1); // set 1 as ID since there is only 1 config entry

        // get today's date and yesterday
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $today) ) ));


        // get daily net sales data -------------------------------------------------------------------------------------------------------------

        $today_net_sales = $this->transactions->get_daily_net_sales($today);

        $yesterday_net_sales = $this->transactions->get_daily_net_sales($yesterday);


        if ($yesterday_net_sales > $today_net_sales) // if yesterday net sales is higher
        {
            if ($yesterday_net_sales == 0)
            {
                if ($today_net_sales == 0) // if both today and yesterday is zero
                {
                    $percent_net_sales = 0;    
                }
                else
                {
                    $percent_net_sales = 100;
                }
            }
            else
            {
                $percent_net_sales = ((1 - ($today_net_sales / $yesterday_net_sales)) * 100);
            }
            
            $percent_net_sales_str = '[ ' . number_format($percent_net_sales, 1) . ' % ] Lower than yesterday\'s ' . '[ ₱ ' . number_format($yesterday_net_sales, 2) . ' ]';
        }
        else // if yesterday net sales is lower (higher today)
        {
            if ($today_net_sales == 0)
            {
                if ($yesterday_net_sales == 0) // if both today and yesterday is zero
                {
                    $percent_net_sales = 0;    
                }
                else
                {
                    $percent_net_sales = 100;
                }
            }
            else
            {
                if ($yesterday_net_sales == 0) // if both today and yesterday is zero
                {
                    $percent_net_sales = 100;    
                }
                else
                {
                    $percent_net_sales = (100 - (($yesterday_net_sales / $today_net_sales) * 100));
                }
            }

            $percent_net_sales_str = '[ ' . number_format($percent_net_sales, 1) . ' % ] Higher than yesterday\'s ' . '[ ₱ ' . number_format($yesterday_net_sales, 2) . ' ]';
        }
        
        $today_net_sales_str = '₱ ' . number_format($today_net_sales, 2);

        // -------------------------------------------------------------------------------------------------------------------------------------


        // get daily transaction count data ----------------------------------------------------------------------------------------------------

        $dine_in_today = $this->transactions->get_count_trans_today($today, 'DINE-IN');
        $take_out_today = $this->transactions->get_count_trans_today($today, 'TAKE-OUT');

        $total_trans_count_today = $dine_in_today + $take_out_today;

        // -------------------------------------------------------------------------------------------------------------------------------------


        // get menu items sold today -----------------------------------------------------------------------------------------------------------

        $individual_products_sold_today = 1 * ($this->trans_details->count_all_sold_today_by_prod_type(0));
        $packages_sold_today = 1 * ($this->trans_details->count_all_sold_today_by_prod_type(1));

        $total_menu_items_sold_today = $individual_products_sold_today + $packages_sold_today;

        // -------------------------------------------------------------------------------------------------------------------------------------


        // get daily discounts rendered today --------------------------------------------------------------------------------------------------

        $discounts_rendered_today = $this->transactions->get_daily_discounts_rendered($today);

        $gross_total_today = $discounts_rendered_today + $today_net_sales;

        if ($gross_total_today == 0)
        {
            $discounts_gross_percentage = 0;
        }
        else
        {
            $discounts_gross_percentage = ($discounts_rendered_today / $gross_total_today) * 100;    
        }
        

        $discounts_rendered_today_str = '₱ ' . number_format($discounts_rendered_today, 2);
        $discounts_gross_percentage_str = '[ ' . number_format($discounts_gross_percentage, 1) . ' % ]  of Total Gross Sales [ ₱ ' . number_format($gross_total_today, 2) . ' ]';

        // -------------------------------------------------------------------------------------------------------------------------------------


        // get cancelled transactions today --------------------------------------------------------------------------------------------------

        $cancelled_trans_today = $this->transactions->get_count_trans_today_status($today, 'CANCELLED');
        $voided_menu_items_today = $this->trans_logs->get_total_void_today($today);
        

        $voided_menu_items_today_str = 'Voided Menu Items [ ' . $voided_menu_items_today . ' ]';



        $data['store'] = $store;

        $data['today_net_sales_str'] = $today_net_sales_str;
        $data['percent_net_sales_str'] = $percent_net_sales_str;

        $data['total_trans_count_today'] = $total_trans_count_today;
        $data['dine_in_today'] = $dine_in_today;
        $data['take_out_today'] = $take_out_today;

        $data['total_menu_items_sold_today'] = $total_menu_items_sold_today;
        $data['individual_products_sold_today'] = $individual_products_sold_today;
        $data['packages_sold_today'] = $packages_sold_today;      

        $data['discounts_rendered_today_str'] = $discounts_rendered_today_str;
        $data['discounts_gross_percentage_str'] = $discounts_gross_percentage_str;

        $data['cancelled_trans_today'] = $cancelled_trans_today;
        $data['voided_menu_items_today_str'] = $voided_menu_items_today_str;

        $data['title'] = '<i class="fa fa-tachometer"></i> Dashboard';	
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('template/dashboard_body',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }

    public function ajax_list() // get all that belongs to this ID via foreign key
    {
        // get best selling list -------------------------------------------------

        $min_price = $this->store->get_store_bs_price(1);

        $best_selling = $this->products->get_best_selling($min_price);
        $best_selling_prod_array = array();
        $best_selling_pack_array = array();

        foreach ($best_selling as $bp_products) // different storage for products and package since index is used to get the rank
        {
            $best_selling_prod_array[] = $bp_products->prod_id;
            $best_selling_pack_array[] = $bp_products->pack_id;
        }
        //------------------------------------------------------------------------

        $list = $this->trans_details->get_datatables_sold_today();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $trans_details) {
            $no++;
            $row = array();
            
            if ($trans_details->prod_type == 1) // if prod_type is package
            {
                $item_id = 'G' . $trans_details->pack_id;
                $item_name = $this->packages->get_package_name($trans_details->pack_id);
                $item_type = 'PACKAGE';
                $item_price = $this->packages->get_package_price($trans_details->pack_id);

                if (in_array($trans_details->pack_id, $best_selling_pack_array))
                {
                    $item_sold = '( <i class="fa fa-star"></i> Rank: ' . (array_search($trans_details->pack_id, $best_selling_pack_array) + 1) . " ) &nbsp;&nbsp;&nbsp;&nbsp; <b>" . $trans_details->sold . "</b>";    
                }
                else
                {
                    $item_sold = '<b>' . $trans_details->sold . '</b>';
                }
            }
            else if ($trans_details->prod_type == 0) // if prod_type is individual product
            {
                $item_id = 'P' . $trans_details->prod_id;
                $item_name = $this->products->get_product_name($trans_details->prod_id);
                $item_type = 'PRODUCT';
                $item_price = $this->products->get_product_price($trans_details->prod_id);

                if (in_array($trans_details->prod_id, $best_selling_prod_array))
                {
                    $item_sold = '( <i class="fa fa-star"></i> Rank: ' . (array_search($trans_details->prod_id, $best_selling_prod_array) + 1) . " ) &nbsp;&nbsp;&nbsp;&nbsp; <b>" . $trans_details->sold . "</b>";    
                }
                else
                {
                    $item_sold = '<b>' . $trans_details->sold . '</b>';
                }
            }

            $row[] = $item_id;
            $row[] = $item_name;
            $row[] = $item_type;

            $row[] = $item_price;

            $row[] = $item_sold;

            $total_item_sales = ($item_price * $trans_details->sold);

            $row[] = "₱ " . number_format($total_item_sales, 2);

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->trans_details->count_all_sold_today(),
                        "recordsFiltered" => $this->trans_details->count_filtered_sold_today(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function set_s_reading()
    {
        $pos_no = 1;
        $cashier_username = $this->session->userdata('username');
        $cashier_id = $this->session->userdata('user_id');
        $today = date('Y-m-d');

        // ------------------------- COUNTS -------------------------------------------------------------------------------
        $trans_count_dine_in = $this->transactions->get_count_trans_shift($today, 'DINE-IN', $cashier_id);
        $trans_count_take_out = $this->transactions->get_count_trans_shift($today, 'TAKE-OUT', $cashier_id);

        $trans_count_total = ($trans_count_dine_in + $trans_count_take_out);

        $trans_count_cleared = $this->transactions->get_count_trans_shift_status($today, 'CLEARED', $cashier_id);
        $trans_count_cancelled = $this->transactions->get_count_trans_shift_status($today, 'CANCELLED', $cashier_id);
        $trans_count_refunded = $this->transactions->get_count_trans_shift_status($today, 'REFUNDED', $cashier_id);

        $void_items_count = $this->trans_logs->get_total_void_shift($today, $cashier_username);

        // ------------------------- AMOUNT -------------------------------------------------------------------------------
        $net_sales = $this->transactions->get_daily_net_sales_shift($today, $cashier_id);
        $discounts_rendered_sc = $this->transactions->get_daily_discounts_rendered_shift($today, $cashier_id, 1);
        $discounts_rendered_pwd = $this->transactions->get_daily_discounts_rendered_shift($today, $cashier_id, 2);
        $discounts_rendered_promo = $this->transactions->get_daily_discounts_rendered_shift($today, $cashier_id, 0);

        $discounts_rendered_total = ($discounts_rendered_sc + $discounts_rendered_pwd + $discounts_rendered_promo);
        $gross_sales = $discounts_rendered_total + $net_sales;

        $cancelled_sales = $this->transactions->get_daily_sales_by_status_shift($today, $cashier_id, 'CANCELLED');
        $refunded_sales = $this->transactions->get_daily_sales_by_status_shift($today, $cashier_id, 'REFUNDED');

        $vat_sales = 0;
        $vat_amount = 0;
        $vat_exempt = 0;


        // ------------------------- RANGE --------------------------------------------------------------------------------
        $start_rcpt_no = $this->transactions->get_start_rcpt($today, $cashier_id);
        $end_rcpt_no = $this->transactions->get_end_rcpt($today, $cashier_id);


        // ------------------- STRING CONVERSION --------------------------------------------------------------------------
        $net_sales_str = number_format($net_sales, 2);
        $disc_sc_str = number_format($discounts_rendered_sc, 2);
        $disc_pwd_str = number_format($discounts_rendered_pwd, 2);
        $disc_promo_str = number_format($discounts_rendered_promo, 2);
        $disc_total_str = number_format($discounts_rendered_total, 2);
        $gross_sales_str = number_format($gross_sales, 2);

        $cancelled_sales_str = number_format($cancelled_sales, 2);
        $refunded_sales_str = number_format($refunded_sales, 2);

        $vat_sales_str = number_format($vat_sales, 2);
        $vat_amount_str = number_format($vat_amount, 2);
        $vat_exempt_str = number_format($vat_exempt, 2);

        // insert data
        $data = array(
                'pos_no' => $pos_no,
                'cashier_username' => $cashier_username,
                'date' => $today,
                'trans_count_dine_in' => $trans_count_dine_in,
                'trans_count_take_out' => $trans_count_take_out,
                'trans_count_total' => $trans_count_total,
                'trans_count_cleared' => $trans_count_cleared,
                'trans_count_cancelled' => $trans_count_cancelled,
                'trans_count_refunded' => $trans_count_refunded,
                'void_items_count' => $void_items_count,
                'net_sales' => $net_sales,
                'discounts_rendered_sc' => $discounts_rendered_sc,
                'discounts_rendered_pwd' => $discounts_rendered_pwd,
                'discounts_rendered_promo' => $discounts_rendered_promo,
                'discounts_rendered_total' => $discounts_rendered_total,
                'gross_sales' => $gross_sales,
                'cancelled_sales' => $cancelled_sales,
                'refunded_sales' => $refunded_sales,
                'vat_sales' => $vat_sales,
                'vat_amount' => $vat_amount,
                'vat_exempt' => $vat_exempt,
                'start_rcpt_no' => $start_rcpt_no,
                'end_rcpt_no' => $end_rcpt_no

            );
        $reading_no = $this->s_readings->save($data);


        $this->print_readings('S-READING', $reading_no, $pos_no, $cashier_username, $trans_count_dine_in, $trans_count_take_out, $trans_count_total, $trans_count_cleared, $trans_count_cancelled, $trans_count_refunded, $void_items_count, $net_sales_str, $disc_sc_str, $disc_pwd_str, $disc_promo_str, $disc_total_str, $gross_sales_str, $cancelled_sales_str, $refunded_sales_str, $vat_sales_str, $vat_amount_str, $vat_exempt_str, $start_rcpt_no, $end_rcpt_no);

        echo json_encode(array("status" => TRUE));
    }

    public function set_x_reading()
    {
        $pos_no = 1;
        $cashier_username = $this->session->userdata('username');
        $cashier_id = $this->session->userdata('user_id');
        $today = date('Y-m-d');

        // ------------------------- COUNTS -------------------------------------------------------------------------------
        $trans_count_dine_in = $this->transactions->get_count_trans_today($today, 'DINE-IN');
        $trans_count_take_out = $this->transactions->get_count_trans_today($today, 'TAKE-OUT');

        $trans_count_total = ($trans_count_dine_in + $trans_count_take_out);

        $trans_count_cleared = $this->transactions->get_count_trans_today_status($today, 'CLEARED');
        $trans_count_cancelled = $this->transactions->get_count_trans_today_status($today, 'CANCELLED');
        $trans_count_refunded = $this->transactions->get_count_trans_today_status($today, 'REFUNDED');

        $void_items_count = $this->trans_logs->get_total_void_today($today);

        // ------------------------- AMOUNT -------------------------------------------------------------------------------
        $net_sales = $this->transactions->get_daily_net_sales($today);
        $discounts_rendered_sc = $this->transactions->get_daily_discounts_rendered_type($today, 1);
        $discounts_rendered_pwd = $this->transactions->get_daily_discounts_rendered_type($today, 2);
        $discounts_rendered_promo = $this->transactions->get_daily_discounts_rendered_type($today, 0);

        $discounts_rendered_total = ($discounts_rendered_sc + $discounts_rendered_pwd + $discounts_rendered_promo);
        $gross_sales = $discounts_rendered_total + $net_sales;

        $cancelled_sales = $this->transactions->get_daily_sales_by_status($today, 'CANCELLED');
        $refunded_sales = $this->transactions->get_daily_sales_by_status($today, 'REFUNDED');

        $vat_sales = 0;
        $vat_amount = 0;
        $vat_exempt = 0;


        // ------------------------- RANGE --------------------------------------------------------------------------------
        $start_rcpt_no = $this->transactions->get_start_rcpt($today, 0);
        $end_rcpt_no = $this->transactions->get_end_rcpt($today, 0);


        // ------------------- STRING CONVERSION --------------------------------------------------------------------------
        $net_sales_str = number_format($net_sales, 2);
        $disc_sc_str = number_format($discounts_rendered_sc, 2);
        $disc_pwd_str = number_format($discounts_rendered_pwd, 2);
        $disc_promo_str = number_format($discounts_rendered_promo, 2);
        $disc_total_str = number_format($discounts_rendered_total, 2);
        $gross_sales_str = number_format($gross_sales, 2);

        $cancelled_sales_str = number_format($cancelled_sales, 2);
        $refunded_sales_str = number_format($refunded_sales, 2);

        $vat_sales_str = number_format($vat_sales, 2);
        $vat_amount_str = number_format($vat_amount, 2);
        $vat_exempt_str = number_format($vat_exempt, 2);

        // insert data
        $data = array(
                'pos_no' => $pos_no,
                'cashier_username' => $cashier_username,
                'date' => $today,
                'trans_count_dine_in' => $trans_count_dine_in,
                'trans_count_take_out' => $trans_count_take_out,
                'trans_count_total' => $trans_count_total,
                'trans_count_cleared' => $trans_count_cleared,
                'trans_count_cancelled' => $trans_count_cancelled,
                'trans_count_refunded' => $trans_count_refunded,
                'void_items_count' => $void_items_count,
                'net_sales' => $net_sales,
                'discounts_rendered_sc' => $discounts_rendered_sc,
                'discounts_rendered_pwd' => $discounts_rendered_pwd,
                'discounts_rendered_promo' => $discounts_rendered_promo,
                'discounts_rendered_total' => $discounts_rendered_total,
                'gross_sales' => $gross_sales,
                'cancelled_sales' => $cancelled_sales,
                'refunded_sales' => $refunded_sales,
                'vat_sales' => $vat_sales,
                'vat_amount' => $vat_amount,
                'vat_exempt' => $vat_exempt,
                'start_rcpt_no' => $start_rcpt_no,
                'end_rcpt_no' => $end_rcpt_no

            );
        $reading_no = $this->x_readings->save($data);

        $this->print_readings('X-READING', $reading_no, $pos_no, $cashier_username, $trans_count_dine_in, $trans_count_take_out, $trans_count_total, $trans_count_cleared, $trans_count_cancelled, $trans_count_refunded, $void_items_count, $net_sales_str, $disc_sc_str, $disc_pwd_str, $disc_promo_str, $disc_total_str, $gross_sales_str, $cancelled_sales_str, $refunded_sales_str, $vat_sales_str, $vat_amount_str, $vat_exempt_str, $start_rcpt_no, $end_rcpt_no);

        echo json_encode(array("status" => TRUE));
    }

    public function print_readings($reading_type, $reading_no, $pos_no, $cashier_username, $trans_count_dine_in, $trans_count_take_out, $trans_count_total, $trans_count_cleared, $trans_count_cancelled, $trans_count_refunded, $void_items_count, $net_sales_str, $disc_sc_str, $disc_pwd_str, $disc_promo_str, $disc_total_str, $gross_sales_str, $cancelled_sales_str, $refunded_sales_str, $vat_sales_str, $vat_amount_str, $vat_exempt_str, $start_rcpt_no, $end_rcpt_no)
    {

        /* Open the printer; this will change depending on how it is connected */
        $connector = new WindowsPrintConnector("epsontmu");
        $printer = new Printer($connector);

        // $logo = EscposImage::load("cafe.png", false);

        // ========================================= PRINTING SECTION ===========================================================

        // fetch config data
        $store = $this->store->get_by_id(1); // set 1 as ID since there is only 1 config entry

        /* Information for the receipt */
        $branch_id = $store->branch_id;
        $store_name = wordwrap($store->name . ' B#: ' . $branch_id, 35, "\n");
        $address = wordwrap($store->address, 35, "\n");
        $city = wordwrap($store->city, 35, "\n");
        $tin = wordwrap($store->tin, 35, "\n");
        $telephone = wordwrap('Tel#: ' . $store->telephone, 35, "\n");
        $mobile = wordwrap('Cel#: ' . $store->mobile, 35, "\n");
        $date = date('D, j F Y h:i A'); // format: Wed, 4 July 2018 11:20 AM
        $today = date('Y-m-d');

        /* Print top logo */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        // $printer -> graphics($logo);

        /* Name of shop */
        $printer -> text($store_name . "\n");
        $printer -> text($address . "\n");
        $printer -> text($city . "\n");
        $printer -> text($telephone . "\n");
        $printer -> text($mobile . "\n");
        $printer -> text($tin . "\n");

        $printer -> text(str_pad("", 30, '*', STR_PAD_BOTH) . "\n");
        /* Title of receipt */
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($reading_type . "\n");
        $printer -> selectPrintMode();

        $printer -> text(str_pad("", 30, '*', STR_PAD_BOTH) . "\n");

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text(new item($reading_type . '#: ' . $reading_no, ''));
        $printer -> text(new item('POS#: ' . $pos_no, ''));
        $printer -> text(new item('Cashier: ' . $cashier_username, ''));
        $printer -> text(new item('Date: ' . $today, ''));

        $printer -> text(str_pad("COUNT", 35, '=', STR_PAD_BOTH) . "\n");

        $printer -> text(new item('TotalTrans: ', $trans_count_total));
        $printer -> text(new item('DineIn: ', $trans_count_dine_in));
        $printer -> text(new item('TakeOut: ', $trans_count_take_out));
        $printer -> text(str_pad("", 35, '-', STR_PAD_BOTH) . "\n");
        $printer -> text(new item('Cleared: ', $trans_count_cleared));
        $printer -> text(new item('Cancelled: ', $trans_count_cancelled));
        $printer -> text(new item('Refunded: ', $trans_count_refunded));
        $printer -> text(str_pad("", 35, '-', STR_PAD_BOTH) . "\n");
        $printer -> text(new item('VoidItems: ', $void_items_count));

        $printer -> text(str_pad("VALUE", 35, '=', STR_PAD_BOTH) . "\n");
        
        /* Items */
        $printer -> setEmphasis(true);
        $printer -> text(new item('', 'Php'));
        $printer -> setEmphasis(false);

        $printer -> text(new item('GrossSales: ', $gross_sales_str));
        $printer -> text(str_pad("", 35, '-', STR_PAD_BOTH) . "\n");
        $printer -> text(new item('DiscountSC: ', $disc_sc_str));
        $printer -> text(new item('DiscountPWD: ', $disc_pwd_str));
        $printer -> text(new item('DiscountPromo: ', $disc_promo_str));
        $printer -> text(new item('DiscountTotal: ', $disc_total_str));
        $printer -> text(str_pad("", 35, '-', STR_PAD_BOTH) . "\n");
        $printer -> text(new item('Cancelled: ', $cancelled_sales_str));
        $printer -> text(new item('Refunded: ', $refunded_sales_str));

        $printer -> text(str_pad("", 35, '-', STR_PAD_BOTH) . "\n");

        $printer -> setEmphasis(true);
        $printer -> text(new item('NetSales: ', $net_sales_str));
        $printer -> setEmphasis(false);

        $printer -> text(str_pad("VAT", 35, '=', STR_PAD_BOTH) . "\n");

        $printer -> text(new item('VATSales: ', $vat_sales_str));
        $printer -> text(new item('VATAmount: ', $vat_amount_str));
        $printer -> text(new item('VATExcempt: ', $vat_exempt_str));

        $printer -> text(str_pad("RECEIPT", 35, '=', STR_PAD_BOTH) . "\n");

        $printer -> text(new item('StartRcpt: ', $start_rcpt_no));
        $printer -> text(new item('EndRecpt: ', $end_rcpt_no));

        /* Footer */
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text($date . "\n");

        $printer -> feed();
        $printer -> text(str_pad("", 35, '_', STR_PAD_BOTH) . "\n");
        
        /* Cut the receipt and open the cash drawer */
        $printer -> cut();

        $printer -> pulse();

        $printer -> close();
    }

    // ================================================ API GET REQUEST METHOD ============================================


    public function ajax_api_pos_list()
    {
        $list = $this->pos->get_api_datatables();
        $data = array();
        
        foreach ($list as $pos) {
            
            $row = array();
            $row['pos_id'] = $pos->pos_id;
            $row['pos_name'] = $pos->pos_name;
            $row['hardware_id'] = $pos->hardware_id;
            $row['software_id'] = $pos->software_id;
            $row['receipt_count'] = $pos->receipt_count;
            $row['activated'] = $pos->activated;
 
            $data[] = $row;
        }
 
        //output to json format
        echo json_encode($data);
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
        $rightCols = 10;
        $leftCols = 25;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;

        $sign = ($this -> dollarSign ? 'Php ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}
