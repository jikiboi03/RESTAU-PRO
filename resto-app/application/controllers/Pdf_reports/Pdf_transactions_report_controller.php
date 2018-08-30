<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_transactions_report_controller extends CI_Controller {

	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Store_config/Store_config_model','store');
	  $this->load->model('Products/Products_model','products');
	  $this->load->model('Packages/Packages_model','packages');

	  $this->load->model('Trans_details/Trans_details_model','trans_details');

	  $this->load->model('Transactions/Transactions_model','transactions');

	  $this->load->model('Users/Users_model','users');
	}

	public function index($status)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || ($this->session->userdata('administrator') == "0" && $this->session->userdata('cashier') == "0"))
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get total net sales data -------------------------------------------------------------------------------------------------------------

		$total_net_sales = $this->transactions->get_total_net_sales_by_status($status);
		
		$total_net_sales_str = 'Php ' . number_format($total_net_sales, 2);

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		$dine_in_total = $this->transactions->get_count_trans_total($status, 'DINE-IN');
		$take_out_total = $this->transactions->get_count_trans_total($status, 'TAKE-OUT');

		$total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get menu items sold today -----------------------------------------------------------------------------------------------------------

		$individual_products_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type(0, $status));
		$packages_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type(1, $status));

		$total_menu_items_sold = $individual_products_sold + $packages_sold;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily discounts rendered today --------------------------------------------------------------------------------------------------

		$discounts_rendered_total = $this->transactions->get_total_discounts_rendered_by_status($status);

		$gross_total = $discounts_rendered_total + $total_net_sales;

		if ($gross_total == 0)
		{
		    $discounts_gross_percentage = 0;
		}
		else
		{
		    $discounts_gross_percentage = ($discounts_rendered_total / $gross_total) * 100;    
		}
		

		$discounts_rendered_total_str = 'Php ' . number_format($discounts_rendered_total, 2);
		$discounts_gross_percentage_str = '[ ' . number_format($discounts_gross_percentage, 1) . ' % ]  of the Total Gross Sales [ Php ' . number_format($gross_total, 2) . ' ]';



		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData($status); // load and fetch data
		
		$data['title'] = 'Transactions Report';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('TransID', 'Status', 'Date', 'O.Type', 'S.Gross', 'Discount', 'TotalDue', 'Staff', 'Receipt#');


		$data['status'] = $status;

		$data['total_net_sales_str'] = $total_net_sales_str;

		$data['total_trans_count'] = $total_trans_count;
		$data['dine_in_total'] = $dine_in_total;
		$data['take_out_total'] = $take_out_total;

		$data['total_menu_items_sold'] = $total_menu_items_sold;
		$data['individual_products_sold'] = $individual_products_sold;
		$data['packages_sold'] = $packages_sold;      

		$data['discounts_rendered_total_str'] = $discounts_rendered_total_str;
		$data['discounts_gross_percentage_str'] = $discounts_gross_percentage_str;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_transactions_view', $data);
	}

	public function index_annual($status, $year)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || $this->session->userdata('administrator') == "0")
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get total net sales data -------------------------------------------------------------------------------------------------------------

		$total_net_sales = $this->transactions->get_total_net_sales_by_status_annual($status, $year);
		
		$total_net_sales_str = 'Php ' . number_format($total_net_sales, 2);

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		$dine_in_total = $this->transactions->get_count_trans_total_annual($status, 'DINE-IN', $year);
		$take_out_total = $this->transactions->get_count_trans_total_annual($status, 'TAKE-OUT', $year);

		$total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get menu items sold ----------------------------------------------------------------------------------------------------------------

		$individual_products_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type_annual(0, $status, $year));
		$packages_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type_annual(1, $status, $year));

		$total_menu_items_sold = $individual_products_sold + $packages_sold;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily discounts rendered today --------------------------------------------------------------------------------------------------

		$discounts_rendered_total = $this->transactions->get_total_discounts_rendered_by_status_annual($status, $year);

		$gross_total = $discounts_rendered_total + $total_net_sales;

		if ($gross_total == 0)
		{
		    $discounts_gross_percentage = 0;
		}
		else
		{
		    $discounts_gross_percentage = ($discounts_rendered_total / $gross_total) * 100;    
		}
		

		$discounts_rendered_total_str = 'Php ' . number_format($discounts_rendered_total, 2);
		$discounts_gross_percentage_str = '[ ' . number_format($discounts_gross_percentage, 1) . ' % ]  of the Total Gross Sales [ Php ' . number_format($gross_total, 2) . ' ]';



		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData_annual($status, $year); // load and fetch data
		
		$data['title'] = 'Annual ( ' . $year . ' ) Transactions Report';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('TransID', 'Status', 'Date', 'O.Type', 'S.Gross', 'Discount', 'TotalDue', 'Staff', 'Receipt#');


		$data['status'] = $status;

		$data['total_net_sales_str'] = $total_net_sales_str;

		$data['total_trans_count'] = $total_trans_count;
		$data['dine_in_total'] = $dine_in_total;
		$data['take_out_total'] = $take_out_total;

		$data['total_menu_items_sold'] = $total_menu_items_sold;
		$data['individual_products_sold'] = $individual_products_sold;
		$data['packages_sold'] = $packages_sold;      

		$data['discounts_rendered_total_str'] = $discounts_rendered_total_str;
		$data['discounts_gross_percentage_str'] = $discounts_gross_percentage_str;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_transactions_view', $data);
	}

	public function index_monthly($status, $year, $month)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || $this->session->userdata('administrator') == "0")
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get total net sales data -------------------------------------------------------------------------------------------------------------

		$total_net_sales = $this->transactions->get_total_net_sales_by_status_monthly($status, $year, $month);
		
		$total_net_sales_str = 'Php ' . number_format($total_net_sales, 2);

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		$dine_in_total = $this->transactions->get_count_trans_total_monthly($status, 'DINE-IN', $year, $month);
		$take_out_total = $this->transactions->get_count_trans_total_monthly($status, 'TAKE-OUT', $year, $month);

		$total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get menu items sold today -----------------------------------------------------------------------------------------------------------

		$individual_products_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type_monthly(0, $status, $year, $month));
		$packages_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type_monthly(1, $status, $year, $month));

		$total_menu_items_sold = $individual_products_sold + $packages_sold;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily discounts rendered today --------------------------------------------------------------------------------------------------

		$discounts_rendered_total = $this->transactions->get_total_discounts_rendered_by_status_monthly($status, $year, $month);

		$gross_total = $discounts_rendered_total + $total_net_sales;

		if ($gross_total == 0)
		{
		    $discounts_gross_percentage = 0;
		}
		else
		{
		    $discounts_gross_percentage = ($discounts_rendered_total / $gross_total) * 100;    
		}
		

		$discounts_rendered_total_str = 'Php ' . number_format($discounts_rendered_total, 2);
		$discounts_gross_percentage_str = '[ ' . number_format($discounts_gross_percentage, 1) . ' % ]  of the Total Gross Sales [ Php ' . number_format($gross_total, 2) . ' ]';

		$dateObj   = DateTime::createFromFormat('!m', $month);
		$monthName = $dateObj->format('F'); // March


		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData_monthly($status, $year, $month); // load and fetch data
		
		$data['title'] = 'Monthly ( ' . $monthName . ' ' . $year . ' ) Transactions Report';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('TransID', 'Status', 'Date', 'O.Type', 'S.Gross', 'Discount', 'TotalDue', 'Staff', 'Receipt#');


		$data['status'] = $status;

		$data['total_net_sales_str'] = $total_net_sales_str;

		$data['total_trans_count'] = $total_trans_count;
		$data['dine_in_total'] = $dine_in_total;
		$data['take_out_total'] = $take_out_total;

		$data['total_menu_items_sold'] = $total_menu_items_sold;
		$data['individual_products_sold'] = $individual_products_sold;
		$data['packages_sold'] = $packages_sold;      

		$data['discounts_rendered_total_str'] = $discounts_rendered_total_str;
		$data['discounts_gross_percentage_str'] = $discounts_gross_percentage_str;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_transactions_view', $data);
	}

	public function index_custom($status, $date_from, $date_to)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || $this->session->userdata('administrator') == "0")
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get total net sales data -------------------------------------------------------------------------------------------------------------

		$total_net_sales = $this->transactions->get_total_net_sales_by_status_custom($status, $date_from, $date_to);
		
		$total_net_sales_str = 'Php ' . number_format($total_net_sales, 2);

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		$dine_in_total = $this->transactions->get_count_trans_total_custom($status, 'DINE-IN', $date_from, $date_to);
		$take_out_total = $this->transactions->get_count_trans_total_custom($status, 'TAKE-OUT', $date_from, $date_to);

		$total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get menu items sold today -----------------------------------------------------------------------------------------------------------

		$individual_products_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type_custom(0, $status, $date_from, $date_to));
		$packages_sold = 1 * ($this->trans_details->count_all_sold_status_by_prod_type_custom(1, $status, $date_from, $date_to));

		$total_menu_items_sold = $individual_products_sold + $packages_sold;

		// -------------------------------------------------------------------------------------------------------------------------------------


		// get daily discounts rendered today --------------------------------------------------------------------------------------------------

		$discounts_rendered_total = $this->transactions->get_total_discounts_rendered_by_status_custom($status, $date_from, $date_to);

		$gross_total = $discounts_rendered_total + $total_net_sales;

		if ($gross_total == 0)
		{
		    $discounts_gross_percentage = 0;
		}
		else
		{
		    $discounts_gross_percentage = ($discounts_rendered_total / $gross_total) * 100;    
		}
		

		$discounts_rendered_total_str = 'Php ' . number_format($discounts_rendered_total, 2);
		$discounts_gross_percentage_str = '[ ' . number_format($discounts_gross_percentage, 1) . ' % ]  of the Total Gross Sales [ Php ' . number_format($gross_total, 2) . ' ]';



		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData_custom($status, $date_from, $date_to); // load and fetch data
		
		$data['title'] = 'Custom ( ' . $date_from . ' - ' . $date_to . ' ) Transactions Report';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('TransID', 'Status', 'Date', 'O.Type', 'S.Gross', 'Discount', 'TotalDue', 'Staff', 'Receipt#');


		$data['status'] = $status;

		$data['total_net_sales_str'] = $total_net_sales_str;

		$data['total_trans_count'] = $total_trans_count;
		$data['dine_in_total'] = $dine_in_total;
		$data['take_out_total'] = $take_out_total;

		$data['total_menu_items_sold'] = $total_menu_items_sold;
		$data['individual_products_sold'] = $individual_products_sold;
		$data['packages_sold'] = $packages_sold;      

		$data['discounts_rendered_total_str'] = $discounts_rendered_total_str;
		$data['discounts_gross_percentage_str'] = $discounts_gross_percentage_str;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_transactions_view', $data);
	}

	// Load table data from file
	public function LoadData($status) 
	{
		$list = $this->transactions->get_all_trans_by_status($status);
		$data = array();

		foreach ($list as $transactions) {
		    $row = array();

		    $row[] = 'S' . $transactions->trans_id;
		    $row[] = $transactions->status;
		    $row[] = substr($transactions->datetime,0,10);

		    $row[] = $transactions->order_type;

		    $gross = $this->trans_details->get_trans_gross($transactions->trans_id);
		    $discount = $transactions->discount;
		    $total_due = ($gross - $discount);

		    $row[] = $gross;
		    $row[] = $discount;
		    // $row[] = $transactions->disc_type;
		    $row[] = number_format($total_due, 2);
		    
		    $row[] = $this->users->get_username($transactions->user_id);
		    
		    if ($transactions->receipt_no == 10000000)
		    {
		    	$row[] = 'n/a';
		    }
		    else
		    {
		    	$row[] = $transactions->receipt_no;
		    }

		    $data[] = $row;
		}

		return $data;
	}

	// Load table data from file
	public function LoadData_annual($status, $year) 
	{
		$list = $this->transactions->get_all_trans_by_status_annual($status, $year);
		$data = array();

		foreach ($list as $transactions) {
		    $row = array();

		    $row[] = 'S' . $transactions->trans_id;
		    $row[] = $transactions->status;
		    $row[] = substr($transactions->datetime,0,10);

		    $row[] = $transactions->order_type;

		    $gross = $this->trans_details->get_trans_gross($transactions->trans_id);
		    $discount = $transactions->discount;
		    $total_due = ($gross - $discount);

		    $row[] = $gross;
		    $row[] = $discount;
		    // $row[] = $transactions->disc_type;
		    $row[] = number_format($total_due, 2);
		    
		    $row[] = $this->users->get_username($transactions->user_id);
		    
		    if ($transactions->receipt_no == 1000000)
		    {
		    	$row[] = 'n/a';
		    }
		    else
		    {
		    	$row[] = $transactions->receipt_no;
		    }

		    $data[] = $row;
		}

		return $data;
	}

	// Load table data from file
	public function LoadData_monthly($status, $year, $month) 
	{
		$list = $this->transactions->get_all_trans_by_status_monthly($status, $year, $month);
		$data = array();

		foreach ($list as $transactions) {
		    $row = array();

		    $row[] = 'S' . $transactions->trans_id;
		    $row[] = $transactions->status;
		    $row[] = substr($transactions->datetime,0,10);

		    $row[] = $transactions->order_type;

		    $gross = $this->trans_details->get_trans_gross($transactions->trans_id);
		    $discount = $transactions->discount;
		    $total_due = ($gross - $discount);

		    $row[] = $gross;
		    $row[] = $discount;
		    // $row[] = $transactions->disc_type;
		    $row[] = number_format($total_due, 2);
		    
		    $row[] = $this->users->get_username($transactions->user_id);
		    
		    if ($transactions->receipt_no == 1000000)
		    {
		    	$row[] = 'n/a';
		    }
		    else
		    {
		    	$row[] = $transactions->receipt_no;
		    }

		    $data[] = $row;
		}

		return $data;
	}

	// Load table data from file
	public function LoadData_custom($status, $date_from, $date_to) 
	{
		$list = $this->transactions->get_all_trans_by_status_custom($status, $date_from, $date_to);
		$data = array();

		foreach ($list as $transactions) {
		    $row = array();

		    $row[] = 'S' . $transactions->trans_id;
		    $row[] = $transactions->status;
		    $row[] = substr($transactions->datetime,0,10);

		    $row[] = $transactions->order_type;

		    $gross = $this->trans_details->get_trans_gross($transactions->trans_id);
		    $discount = $transactions->discount;
		    $total_due = ($gross - $discount);

		    $row[] = $gross;
		    $row[] = $discount;
		    // $row[] = $transactions->disc_type;
		    $row[] = number_format($total_due, 2);
		    
		    $row[] = $this->users->get_username($transactions->user_id);
		    
		    if ($transactions->receipt_no == 1000000)
		    {
		    	$row[] = 'n/a';
		    }
		    else
		    {
		    	$row[] = $transactions->receipt_no;
		    }

		    $data[] = $row;
		}

		return $data;
	}

}
