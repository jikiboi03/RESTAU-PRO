<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cis/Cis_model','cis');
    }

    // parameter page can be monthly, quarterly, deworming
    public function index($page)
    {
        if($this->session->userdata('user_id') == '')
        {
          redirect('error500');
        }

        if ($page == 'monthly')
        {
            // get last month
            $current_month = date('m');
            $year = date('Y'); // current year but can be changed to last year if current month is Jan

            if ($current_month == 1) // if current month is Jan, prev should be dec of prev year
            {
                $previous_month = 12;
                $year = $year - 1;
            }
            else
            {
                $previous_month = $current_month - 1;
            }

            $dateObj   = DateTime::createFromFormat('!m', $previous_month);
            $monthName = $dateObj->format('F'); // March

            $data['month_year'] = $monthName . ' ' . $year;
            $data['title'] = 'Monthly Checkup Notifications';

            $this->load->helper('url');                         
                                                        
            
            $this->load->view('template/dashboard_header',$data);
            $this->load->view('notifications/notifications_monthly_view',$data);
            $this->load->view('template/dashboard_navigation');
            $this->load->view('template/dashboard_footer');
        }
        else if ($page == 'quarterly')
        {
            // get last month
            $current_month = date('m');
            $year = date('Y'); // current year but can be changed to last year if current month is Jan

            if ($current_month < 4) // if current month is Jan-Mar which is 1st quarter, prev quarter should be 4th
            {
                $previous_quarter = '4th';
                $year = $year - 1;
            }
            else if ($current_month < 7) // if current month is Apr-Jun which is 2nd quarter, prev quarter should be 1st
            {
                $previous_quarter = '1st';
            }
            else if ($current_month < 10) // if current month is Jul-Sep which is 3rd quarter, prev quarter should be 2nd
            {
                $previous_quarter = '2nd';
            }
            else // if current month is Oct-Dec which is 4th quarter, prev quarter should be 3rd
            {
                $previous_quarter = '3rd';
            }
            $data['period_year'] = $previous_quarter . ' Quarter of ' . $year;
            $data['title'] = 'HVI (Quarterly Checkup) Notifications';

            $this->load->helper('url');                         
                                                        
            
            $this->load->view('template/dashboard_header',$data);
            $this->load->view('notifications/notifications_quarterly_view',$data);
            $this->load->view('template/dashboard_navigation');
            $this->load->view('template/dashboard_footer');
        }
        else if ($page == 'deworming')
        {
            // get last month
            $current_month = date('m');
            $year = date('Y'); // current year but can be changed to last year if current month is Jan

            if ($current_month < 7) // if current month is Jan-Jun which is 1st sem, prev sem should be 2nd
            {
                $reg_month = 12;
                $previous_sem = '2nd';
                $year = $year - 1;
            }
            else // if current month is Jul-Dec which is 2nd sem, prev sem should be 1st
            {
                $reg_month = 6;
                $previous_sem = '1st';
            }
            $data['period_year'] = $previous_sem . ' Semi-Annual of ' . $year;
            $data['title'] = 'Deworming Notifications';                   

            $this->load->helper('url');                         
                                                        
            
            $this->load->view('template/dashboard_header',$data);
            $this->load->view('notifications/notifications_deworming_view',$data);
            $this->load->view('template/dashboard_navigation');
            $this->load->view('template/dashboard_footer');
        }
        else // for severe nutrional status
        {
            $data['title'] = 'Severe Nutritional Status Notifications';                   

            $this->load->helper('url');                         
                                                        
            
            $this->load->view('template/dashboard_header',$data);
            $this->load->view('notifications/notifications_severe_view',$data);
            $this->load->view('template/dashboard_navigation');
            $this->load->view('template/dashboard_footer');
        }
    }
 }