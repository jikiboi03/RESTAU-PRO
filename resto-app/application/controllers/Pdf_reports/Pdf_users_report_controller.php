<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_users_report_controller extends CI_Controller {

	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Store_config/Store_config_model','store');
	  $this->load->model('Products/Products_model','products');
	  $this->load->model('Packages/Packages_model','packages');

	  $this->load->model('Trans_details/Trans_details_model','trans_details');

	  $this->load->model('Transactions/Transactions_model','transactions');

	  $this->load->model('Users/Users_model','users');
	  $this->load->model('Logs/Trans_logs_model','trans_logs');
	}

	public function index($user_type)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || $this->session->userdata('administrator') == "0")
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		// $dine_in_total = $this->transactions->get_count_trans_total($status, 'DINE-IN');
		// $take_out_total = $this->transactions->get_count_trans_total($status, 'TAKE-OUT');

		// $total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------

		// users count  ----------------------------------------------------------------------------------------------------

		$admin_users = $this->users->get_user_type_count('administrator');
		$cashier_users = $this->users->get_user_type_count('cashier');
		$staff_users = $this->users->get_user_type_count('staff');

		$total_user_privileges = $admin_users + $cashier_users + $staff_users;

		$total_users = $this->users->count_all();

		// -------------------------------------------------------------------------------------------------------------------------------------

		// void count  ----------------------------------------------------------------------------------------------------

		$void_total = $this->trans_logs->get_total_void();

		// -------------------------------------------------------------------------------------------------------------------------------------

		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData($user_type); // load and fetch data
		
		$data['title'] = 'Users Report ( ' . strtoupper($user_type) . ' )';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('UserID', 'UserName', 'UserType', 'A', 'C', 'S', 'Staff', 'Cashier', 'Total', 'Void', 'Cancel', 'Refund');

		$data['total_users'] = $total_users;
		$data['total_user_privileges'] = $total_user_privileges;
		$data['total_users_str'] = 'Admin [ ' . $admin_users . ' ] | Cashier [ ' . $cashier_users . ' ] | Staff [ ' . $staff_users . ' ]';

		$data['void_total'] = $void_total;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_users_view', $data);
	}

	public function index_annual($user_type, $year)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || $this->session->userdata('administrator') == "0")
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		// $dine_in_total = $this->transactions->get_count_trans_total($status, 'DINE-IN');
		// $take_out_total = $this->transactions->get_count_trans_total($status, 'TAKE-OUT');

		// $total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------

		// users count  ----------------------------------------------------------------------------------------------------

		$admin_users = $this->users->get_user_type_count_annual('administrator', $year);
		$cashier_users = $this->users->get_user_type_count_annual('cashier', $year);
		$staff_users = $this->users->get_user_type_count_annual('staff', $year);

		$total_user_privileges = $admin_users + $cashier_users + $staff_users;

		$total_users = $this->users->count_all_annual($year);

		// -------------------------------------------------------------------------------------------------------------------------------------

		// void count  ----------------------------------------------------------------------------------------------------

		$void_total = $this->trans_logs->get_total_void_annual($year);

		// -------------------------------------------------------------------------------------------------------------------------------------

		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData_annual($user_type, $year); // load and fetch data
		
		$data['title'] = 'Annual ( ' . $year . ' ) Users Report ( ' . strtoupper($user_type) . ' )';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('UserID', 'UserName', 'UserType', 'A', 'C', 'S', 'Staff', 'Cashier', 'Total', 'Void', 'Cancel', 'Refund');

		$data['total_users'] = $total_users;
		$data['total_user_privileges'] = $total_user_privileges;
		$data['total_users_str'] = 'Admin [ ' . $admin_users . ' ] | Cashier [ ' . $cashier_users . ' ] | Staff [ ' . $staff_users . ' ]';

		$data['void_total'] = $void_total;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_users_view', $data);
	}

	public function index_monthly($user_type, $year, $month)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || $this->session->userdata('administrator') == "0")
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		// $dine_in_total = $this->transactions->get_count_trans_total($status, 'DINE-IN');
		// $take_out_total = $this->transactions->get_count_trans_total($status, 'TAKE-OUT');

		// $total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------

		// users count  ----------------------------------------------------------------------------------------------------

		$admin_users = $this->users->get_user_type_count_monthly('administrator', $year, $month);
		$cashier_users = $this->users->get_user_type_count_monthly('cashier', $year, $month);
		$staff_users = $this->users->get_user_type_count_monthly('staff', $year, $month);

		$total_user_privileges = $admin_users + $cashier_users + $staff_users;

		$total_users = $this->users->count_all_monthly($year, $month);

		// -------------------------------------------------------------------------------------------------------------------------------------

		// void count  ----------------------------------------------------------------------------------------------------

		$void_total = $this->trans_logs->get_total_void_monthly($year, $month);

		// -------------------------------------------------------------------------------------------------------------------------------------

		$dateObj   = DateTime::createFromFormat('!m', $month);
		$monthName = $dateObj->format('F'); // March

		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData_monthly($user_type, $year, $month); // load and fetch data
		
		$data['title'] = 'Monthly ( ' . $monthName . ' - ' . $year . ' ) Users Report ( ' . strtoupper($user_type) . ' )';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('UserID', 'UserName', 'UserType', 'A', 'C', 'S', 'Staff', 'Cashier', 'Total', 'Void', 'Cancel', 'Refund');

		$data['total_users'] = $total_users;
		$data['total_user_privileges'] = $total_user_privileges;
		$data['total_users_str'] = 'Admin [ ' . $admin_users . ' ] | Cashier [ ' . $cashier_users . ' ] | Staff [ ' . $staff_users . ' ]';

		$data['void_total'] = $void_total;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_users_view', $data);
	}

	public function index_custom($user_type, $date_from, $date_to)
	{
		// check if logged in and admin
		if($this->session->userdata('user_id') == '' || $this->session->userdata('administrator') == "0")
		{
          redirect('error500');
        }

        // get today's date and yesterday
        $today = date('Y-m-d');

		// get daily transaction count data ----------------------------------------------------------------------------------------------------

		// $dine_in_total = $this->transactions->get_count_trans_total($status, 'DINE-IN');
		// $take_out_total = $this->transactions->get_count_trans_total($status, 'TAKE-OUT');

		// $total_trans_count = $dine_in_total + $take_out_total;

		// -------------------------------------------------------------------------------------------------------------------------------------

		// users count  ----------------------------------------------------------------------------------------------------

		$admin_users = $this->users->get_user_type_count_custom('administrator', $date_to);
		$cashier_users = $this->users->get_user_type_count_custom('cashier', $date_to);
		$staff_users = $this->users->get_user_type_count_custom('staff', $date_to);

		$total_user_privileges = $admin_users + $cashier_users + $staff_users;

		$total_users = $this->users->count_all_custom($date_to);

		// -------------------------------------------------------------------------------------------------------------------------------------

		// void count  ----------------------------------------------------------------------------------------------------

		$void_total = $this->trans_logs->get_total_void_custom($date_from, $date_to);

		// -------------------------------------------------------------------------------------------------------------------------------------

		// ==================================== REPORT ESSENTIALS ========================================================


		$data['logo_img'] = $this->store->get_store_config_img(1);

		$data['comp_name'] = $this->store->get_store_config_name(1);

		$data['data'] = $this->LoadData_custom($user_type, $date_from, $date_to); // load and fetch data
		
		$data['title'] = 'Custom ( ' . $date_from . ' - ' . $date_to . ' ) Users Report ( ' . strtoupper($user_type) . ' )';

		$data['date_today'] = $today;

		$data['current_date'] = date('l, F j, Y', strtotime(date('Y-m-d')));

		$data['current_time'] = date("h:i:s A");

		$data['user_fullname'] = $this->session->userdata('firstname') .' '. $this->session->userdata('lastname');

		// column titles
		$data['header'] = array('UserID', 'UserName', 'UserType', 'A', 'C', 'S', 'Staff', 'Cashier', 'Total', 'Void', 'Cancel', 'Refund');

		$data['total_users'] = $total_users;
		$data['total_user_privileges'] = $total_user_privileges;
		$data['total_users_str'] = 'Admin [ ' . $admin_users . ' ] | Cashier [ ' . $cashier_users . ' ] | Staff [ ' . $staff_users . ' ]';

		$data['void_total'] = $void_total;

		$this->load->library('MYPDF');
		$this->load->view('reports/makepdf_users_view', $data);
	}

	// Load table data from file
	public function LoadData($user_type) 
	{
		$list = $this->users->get_api_datatables();
		$data = array();

		foreach ($list as $users) {
		    $row = array();

		    $row[] = 'U' . $users->user_id;
		    $row[] = $users->username;

		    // check if the user is admin
			if ($users->administrator == 1)
			{
				$row[] = 'ADMIN';
			}
			else if ($users->cashier == 1)
			{
				$row[] = 'CASHIER';
			}
			else
			{
				$row[] = 'STAFF';
			}


		    $is_admin = $users->administrator;
		    $is_cashier = $users->cashier;
		    $is_staff = $users->staff;

		    if ($is_admin == 1)
	    	{ 
	    		$row[] = 'Y'; 
	    	}
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    if ($is_cashier == 1)
		    { 
		    	$row[] = 'Y'; 
			}
		    else
		    { 
		    	$row[] = 'N'; 
			}

		    if ($is_staff == 1)
		    { 
		    	$row[] = 'Y'; 
		    }
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    $staff_trans_count = $this->transactions->get_count_trans_staff($users->user_id);
		    $cashier_trans_count = $this->transactions->get_count_trans_cashier($users->user_id);
		    $total_trans_count = ($staff_trans_count + $cashier_trans_count);

		    $row[] = $staff_trans_count;
		    $row[] = $cashier_trans_count;
		    $row[] = $total_trans_count;

		    $row[] = $this->trans_logs->get_total_void_by_user($users->username);
		    
		    $row[] = $this->trans_logs->get_total_cancelled_by_user($users->username);

		    $row[] = $this->trans_logs->get_total_refunded_by_user($users->username);

		    if ($user_type == 'All')
		    {
		    	$data[] = $row;
		    }
		    else if ($user_type == 'administrator' && $is_admin == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'cashier' && $is_cashier == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'staff' && $is_staff == 1)
		    {
		    	$data[] = $row;	
		    }
		    
		}

		return $data;
	}

	// Load table data from file
	public function LoadData_annual($user_type, $year) 
	{
		$list = $this->users->get_api_datatables_annual($year);
		$data = array();

		foreach ($list as $users) {
		    $row = array();

		    $row[] = 'U' . $users->user_id;
		    $row[] = $users->username;

		    // check if the user is admin
			if ($users->administrator == 1)
			{
				$row[] = 'ADMIN';
			}
			else if ($users->cashier == 1)
			{
				$row[] = 'CASHIER';
			}
			else
			{
				$row[] = 'STAFF';
			}


		    $is_admin = $users->administrator;
		    $is_cashier = $users->cashier;
		    $is_staff = $users->staff;

		    if ($is_admin == 1)
	    	{ 
	    		$row[] = 'Y'; 
	    	}
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    if ($is_cashier == 1)
		    { 
		    	$row[] = 'Y'; 
			}
		    else
		    { 
		    	$row[] = 'N'; 
			}

		    if ($is_staff == 1)
		    { 
		    	$row[] = 'Y'; 
		    }
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    $staff_trans_count = $this->transactions->get_count_trans_staff_annual($users->user_id, $year);
		    $cashier_trans_count = $this->transactions->get_count_trans_cashier_annual($users->user_id, $year);
		    $total_trans_count = ($staff_trans_count + $cashier_trans_count);

		    $row[] = $staff_trans_count;
		    $row[] = $cashier_trans_count;
		    $row[] = $total_trans_count;

		    $row[] = $this->trans_logs->get_total_void_by_user_annual($users->username, $year);
		    
		    $row[] = $this->trans_logs->get_total_cancelled_by_user_annual($users->username, $year);

		    $row[] = $this->trans_logs->get_total_refunded_by_user_annual($users->username, $year);

		    if ($user_type == 'All')
		    {
		    	$data[] = $row;
		    }
		    else if ($user_type == 'administrator' && $is_admin == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'cashier' && $is_cashier == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'staff' && $is_staff == 1)
		    {
		    	$data[] = $row;	
		    }
		}

		return $data;
	}

	// Load table data from file
	public function LoadData_monthly($user_type, $year, $month) 
	{
		$list = $this->users->get_api_datatables_monthly($year, $month);
		$data = array();

		foreach ($list as $users) {
		    $row = array();

		    $row[] = 'U' . $users->user_id;
		    $row[] = $users->username;

		    // check if the user is admin
			if ($users->administrator == 1)
			{
				$row[] = 'ADMIN';
			}
			else if ($users->cashier == 1)
			{
				$row[] = 'CASHIER';
			}
			else
			{
				$row[] = 'STAFF';
			}


		    $is_admin = $users->administrator;
		    $is_cashier = $users->cashier;
		    $is_staff = $users->staff;

		    if ($is_admin == 1)
	    	{ 
	    		$row[] = 'Y'; 
	    	}
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    if ($is_cashier == 1)
		    { 
		    	$row[] = 'Y'; 
			}
		    else
		    { 
		    	$row[] = 'N'; 
			}

		    if ($is_staff == 1)
		    { 
		    	$row[] = 'Y'; 
		    }
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    $staff_trans_count = $this->transactions->get_count_trans_staff_monthly($users->user_id, $year, $month);
		    $cashier_trans_count = $this->transactions->get_count_trans_cashier_monthly($users->user_id, $year, $month);
		    $total_trans_count = ($staff_trans_count + $cashier_trans_count);

		    $row[] = $staff_trans_count;
		    $row[] = $cashier_trans_count;
		    $row[] = $total_trans_count;

		    $row[] = $this->trans_logs->get_total_void_by_user_monthly($users->username, $year, $month);
		    
		    $row[] = $this->trans_logs->get_total_cancelled_by_user_monthly($users->username, $year, $month);

		    $row[] = $this->trans_logs->get_total_refunded_by_user_monthly($users->username, $year, $month);

		    if ($user_type == 'All')
		    {
		    	$data[] = $row;
		    }
		    else if ($user_type == 'administrator' && $is_admin == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'cashier' && $is_cashier == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'staff' && $is_staff == 1)
		    {
		    	$data[] = $row;	
		    }
		}

		return $data;
	}

	// Load table data from file
	public function LoadData_custom($user_type, $date_from, $date_to) 
	{
		$list = $this->users->get_api_datatables_custom($date_to);
		$data = array();

		foreach ($list as $users) {
		    $row = array();

		    $row[] = 'U' . $users->user_id;
		    $row[] = $users->username;

		    // check if the user is admin
			if ($users->administrator == 1)
			{
				$row[] = 'ADMIN';
			}
			else if ($users->cashier == 1)
			{
				$row[] = 'CASHIER';
			}
			else
			{
				$row[] = 'STAFF';
			}


		    $is_admin = $users->administrator;
		    $is_cashier = $users->cashier;
		    $is_staff = $users->staff;

		    if ($is_admin == 1)
	    	{ 
	    		$row[] = 'Y'; 
	    	}
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    if ($is_cashier == 1)
		    { 
		    	$row[] = 'Y'; 
			}
		    else
		    { 
		    	$row[] = 'N'; 
			}

		    if ($is_staff == 1)
		    { 
		    	$row[] = 'Y'; 
		    }
		    else
		    { 
		    	$row[] = 'N'; 
		    }

		    $staff_trans_count = $this->transactions->get_count_trans_staff_custom($users->user_id, $date_from, $date_to);
		    $cashier_trans_count = $this->transactions->get_count_trans_cashier_custom($users->user_id, $date_from, $date_to);
		    $total_trans_count = ($staff_trans_count + $cashier_trans_count);

		    $row[] = $staff_trans_count;
		    $row[] = $cashier_trans_count;
		    $row[] = $total_trans_count;

		    $row[] = $this->trans_logs->get_total_void_by_user_custom($users->username, $date_from, $date_to);
		    
		    $row[] = $this->trans_logs->get_total_cancelled_by_user_custom($users->username, $date_from, $date_to);

		    $row[] = $this->trans_logs->get_total_refunded_by_user_custom($users->username, $date_from, $date_to);

		    if ($user_type == 'All')
		    {
		    	$data[] = $row;
		    }
		    else if ($user_type == 'administrator' && $is_admin == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'cashier' && $is_cashier == 1)
		    {
		    	$data[] = $row;	
		    }
		    else if ($user_type == 'staff' && $is_staff == 1)
		    {
		    	$data[] = $row;	
		    }
		}

		return $data;
	}

}
