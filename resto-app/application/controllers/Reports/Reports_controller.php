<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('cis/cis_model','cis');
        // $this->load->model('barangays/barangays_model','barangays');
    }

   public function index()						/** Note: ayaw ilisi ang sequence sa page load sa page **/
   {
        // check if logged in and admin
        if($this->session->userdata('administrator') == '0')
        {
          redirect('error500');
        }
        
        $this->load->helper('url');

        // get today's date and yesterday
        $today = date('Y-m-d');
        $current_year = date('Y');
        $current_month = date('m');


        $data['today'] = $today;
        $data['current_year'] = $current_year;
        $data['current_month'] = $current_month;
        											
        $data['title'] = '<i class="fa fa-file"></i> Generate Document Reports';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('reports/reports_view',$data);   //Kani lang ang ilisi kung mag dungag mo ug Page
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

   }

   // public function ajax_set_report()
   // {
   //   // for receipt
   //   ini_set('memory_limit', '256M');
   //   // load library
   //   $this->load->library('pdf');
   //   $pdf = $this->pdf->load();
   //   // retrieve data from model
   //   // $data['inventory'] = $this->inventory->get_products_data();
   //   // $data['inventory_sum'] = $this->inventory->get_inventory_data_sum();

   //   $data['print_date'] = date('Y-m-d');

   //   // boost the memory limit if it's low ;)
   //   $html = $this->load->view('reports/cis_report', $data, true);
     
   //   // render the view into HTML
   //   $pdf->WriteHTML($html);
   //   // write the HTML into the PDF
   //   $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
   //   $pdf->Output("$output", 'I');
   //   // save to file because we can exit();
   //   // - See more at: http://webeasystep.com/blog/view_article/codeigniter_tutorial_pdf_to_create_your_reports#sthash.QFCyVGLu.dpuf
   //   // update stocks
   // }
   
    
 }