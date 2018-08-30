<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_dashboard_report_controller extends CI_Controller {

	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Store_config/Store_config_model','store');
	  $this->load->model('Products/Products_model','products');
	  $this->load->model('Packages/Packages_model','packages');

	  $this->load->model('Trans_details/Trans_details_model','trans_details');

	  $this->load->model('Transactions/Transactions_model','transactions');

	  $this->load->model('Logs/Trans_logs_model','trans_logs');
	}

	public function index()
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || ($this->session->userdata('administrator') == "0" && $this->session->userdata('cashier') == "0"))
		{
          redirect('error500');
        }

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
		    
		    $percent_net_sales_str = '[ ' . number_format($percent_net_sales, 1) . ' % ] Lower than yesterday\'s ' . '[ Php ' . number_format($yesterday_net_sales, 2) . ' ]';
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
		            $percent_net_sales = (($yesterday_net_sales / $today_net_sales) * 100);
		        }
		    }

		    $percent_net_sales_str = '[ ' . number_format($percent_net_sales, 1) . ' % ] Higher than yesterday\'s ' . '[ Php ' . number_format($yesterday_net_sales, 2) . ' ]';
		}
		
		$today_net_sales_str = 'Php ' . number_format($today_net_sales, 2);

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
		

		$discounts_rendered_today_str = 'Php ' . number_format($discounts_rendered_today, 2);
		$discounts_gross_percentage_str = '[ ' . number_format($discounts_gross_percentage, 1) . ' % ]  of the Total Gross Sales [ Php ' . number_format($gross_total_today, 2) . ' ]';

		// -------------------------------------------------------------------------------------------------------------------------------------


        // get cancelled transactions today --------------------------------------------------------------------------------------------------

        $cancelled_trans_today = $this->transactions->get_count_trans_today_status($today, 'CANCELLED');
        $voided_menu_items_today = $this->trans_logs->get_total_void_today($today);
        

        $voided_menu_items_today_str = 'Voided Menu Items [ ' . $voided_menu_items_today . ' ]';



		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData(); // load and fetch data
		
		$data['title'] = 'Daily Statistics Report';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('ID', 'Name', 'Type', 'Price', 'Sold', 'Sales');


		// $data['store'] = $store;

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

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_dashboard_view', $data);
	}

	// Load table data from file
	public function LoadData() 
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

		$list = $this->trans_details->get_reports_sold_today();
		$data = array();

		foreach ($list as $trans_details) {
		    $row = array();
		    
		    if ($trans_details->prod_type == 1) // if prod_type is package
		    {
		        $item_id = 'G' . $trans_details->pack_id;
		        $item_name = $this->packages->get_package_name($trans_details->pack_id);
		        $item_type = 'PACKAGE';
		        $item_price = $this->packages->get_package_price($trans_details->pack_id);

		        if (in_array($trans_details->pack_id, $best_selling_pack_array))
		        {
		            $item_sold = '( R: ' . (array_search($trans_details->pack_id, $best_selling_pack_array) + 1) . " ) " . $trans_details->sold;    
		        }
		        else
		        {
		            $item_sold = $trans_details->sold;
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
		            $item_sold = '( R: ' . (array_search($trans_details->prod_id, $best_selling_prod_array) + 1) . " ) " . $trans_details->sold;    
		        }
		        else
		        {
		            $item_sold = $trans_details->sold;
		        }
		    }

		    $row[] = $item_id;
		    $row[] = $item_name;
		    $row[] = $item_type;

		    $row[] = $item_price;

		    $row[] = $item_sold;

		    $total_item_sales = ($item_price * $trans_details->sold);

		    $row[] = number_format($total_item_sales, 2);

		    $data[] = $row;
		}

		return $data;
	}

}
