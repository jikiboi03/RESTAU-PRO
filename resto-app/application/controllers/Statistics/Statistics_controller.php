<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics_controller extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transactions/Transactions_model','transactions');

        $this->load->model('Products/Products_model','products');
        $this->load->model('Packages/Packages_model','packages');
        $this->load->model('Pack_details/Pack_details_model','pack_details');
        $this->load->model('Categories/Categories_model','categories');

        $this->load->model('Tables/Tables_model','tables');

        $this->load->model('Trans_details/Trans_details_model','trans_details');
        $this->load->model('Table_groups/Table_groups_model','table_groups');

        $this->load->model('Users/Users_model','users');
        $this->load->model('Store_config/Store_config_model','store');
    }

    public function index()
    {						
        if($this->session->userdata('administrator') == '0')
        {
            redirect('error500');
        }

        // ========================= FOR CATEGORY PRODUCTS CHART ==================================================

        $cat_list = $this->categories->get_categories();

        $cat_array = array();

        $row = array();
        $row['cat_id'] = 0;
        $row['name'] = 'Packages';

        $cat_prod_count = $this->packages->count_all();
        $row['cat_prod_count'] = $cat_prod_count;
        $cat_prod_sales = $this->trans_details->get_sales_pack();
        $row['cat_prod_sales'] = $cat_prod_sales;
        $cat_prod_sold = $this->trans_details->get_sold_pack();
        $row['cat_prod_sold'] = $cat_prod_sold;


        $cat_array[] = $row;

        foreach ($cat_list as $categories) {
            
            $row = array();
            $row['cat_id'] = $categories->cat_id;
            $row['name'] = $categories->name;

            $cat_prod_count = $this->products->get_cat_prod_count($categories->cat_id);
            $row['cat_prod_count'] = $cat_prod_count;
            $cat_prod_sales = $this->trans_details->get_sales_by_cat($categories->cat_id);
            $row['cat_prod_sales'] = $cat_prod_sales;
            $cat_prod_sold = $this->trans_details->get_sold_by_cat($categories->cat_id);
            $row['cat_prod_sold'] = $cat_prod_sold;

            $cat_array[] = $row;
        }

        $data['cat_array'] = $cat_array;


        // ========================= FOR TOP SELLING MENU CHART ==================================================


        $min_price = $this->store->get_store_bs_price(1);
        $bs_list = $this->products->get_best_selling($min_price);

        $bs_array = array();

        foreach ($bs_list as $bs_menu) {
            
            $row = array();

            if ($bs_menu->pack_id == 0)
            {
                $menu_id = 'P' . $bs_menu->prod_id;
                $menu_name = $this->products->get_product_short_name($bs_menu->prod_id);
                $menu_sales = $this->trans_details->get_total_prod_sales($bs_menu->prod_id);
            }
            else //  package menu item
            {
                $menu_id = 'G' . $bs_menu->pack_id;
                $menu_name = $this->packages->get_package_short_name($bs_menu->pack_id);
                $menu_sales = $this->trans_details->get_total_pack_sales($bs_menu->pack_id);
            }

            $row['menu_id'] = $menu_id;
            $row['menu_name'] = $menu_name;
            $row['menu_sold'] = $bs_menu->sold;
            $row['menu_sales'] = $menu_sales;

            $bs_array[] = $row;
        }

        $data['bs_array'] = $bs_array;


        // ========================= FOR CASHIER EMPLOYEE CHART ====================================================


        $cashier_list = $this->users->get_cashier_users();

        $cashier_array = array();

        foreach ($cashier_list as $cashier) {
            
            $row = array();

            $row['cashier_id'] = 'U' . $cashier->user_id;
            $row['cashier_user_name'] = $this->users->get_username($cashier->user_id);
            $row['cashier_trans_count'] = $this->transactions->get_count_trans_cashier($cashier->user_id);
            $row['cashier_net_sales'] = $this->transactions->get_total_net_sales_by_cashier($cashier->user_id);

            $cashier_array[] = $row;
        }

        $data['cashier_array'] = $cashier_array;


        // ========================= FOR STAFF EMPLOYEE CHART =====================================================


        $staff_list = $this->users->get_staff_users();

        $staff_array = array();

        foreach ($staff_list as $staff) {
            
            $row = array();

            $row['staff_id'] = 'U' . $staff->user_id;
            $row['staff_user_name'] = $this->users->get_username($staff->user_id);
            $row['staff_trans_count'] = $this->transactions->get_count_trans_staff($staff->user_id);
            $row['staff_net_sales'] = $this->transactions->get_total_net_sales_by_staff($staff->user_id);

            $staff_array[] = $row;
        }

        $data['staff_array'] = $staff_array;


        // ========================= FOR MONTHLY NET SALES CHART ==================================================


        $current_year = date('Y');

        $jan = $this->transactions->get_monthly_net_sales('01', $current_year);
        $feb = $this->transactions->get_monthly_net_sales('02', $current_year);
        $mar = $this->transactions->get_monthly_net_sales('03', $current_year);
        $apr = $this->transactions->get_monthly_net_sales('04', $current_year);

        $may = $this->transactions->get_monthly_net_sales('05', $current_year);
        $jun = $this->transactions->get_monthly_net_sales('06', $current_year);
        $jul = $this->transactions->get_monthly_net_sales('07', $current_year);
        $aug = $this->transactions->get_monthly_net_sales('08', $current_year);

        $sep = $this->transactions->get_monthly_net_sales('09', $current_year);
        $oct = $this->transactions->get_monthly_net_sales('10', $current_year);
        $nov = $this->transactions->get_monthly_net_sales('11', $current_year);
        $dec = $this->transactions->get_monthly_net_sales('12', $current_year);

        $year_total = ($jan + $feb + $mar + $apr + $may + $jun + $jul + $aug + $sep + $oct + $nov + $dec);



        $data['current_year'] = $current_year;

        $data['jan'] = $jan;
        $data['feb'] = $feb;
        $data['mar'] = $mar;
        $data['apr'] = $apr;

        $data['may'] = $may;
        $data['jun'] = $jun;
        $data['jul'] = $jul;
        $data['aug'] = $aug;

        $data['sep'] = $sep;
        $data['oct'] = $oct;
        $data['nov'] = $nov;
        $data['dec'] = $dec;

        $data['year_total'] = number_format($year_total, 2, '.', ',');

        $data['title'] = '<i class="fa fa-pie-chart"></i> <i class="fa fa-area-chart"></i> <i class="fa fa-bar-chart"></i> Statistics / Charts';
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('statistics/statistics_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }

    // public function ajax_list()
    // {
    // $list = $this->loans->get_datatables_top_list();
    // $data = array();
    // $no = $_POST['start'];
    // foreach ($list as $loans) {
    // $no++;
    // $row = array();
    // $row[] = 'C' . $loans->client_id;
    // $row[] = $this->clients->get_client_name($loans->client_id);

    // $row[] = number_format($loans->total_loans, 2, '.', ',');
    // $row[] = number_format($loans->paid, 2, '.', ',');
    // $row[] = number_format($loans->balance, 2, '.', ',');

    // $data[] = $row;
    // }

    // $output = array(
    // "draw" => $_POST['draw'],
    // "recordsTotal" => $this->loans->count_all_top_list(),
    // "recordsFiltered" => $this->loans->count_filtered_top_list(),
    // "data" => $data,
    // );
    // //output to json format
    // echo json_encode($output);
    // }

    }
