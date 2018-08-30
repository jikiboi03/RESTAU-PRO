<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

   public function index()
   {
      $this->load->view('template/dashboard_header');
      $this->load->view('template/dashboard_sidebar');
      $this->load->view('index');
      $this->load->view('template/dashboard_footer');
   }



   	///////nag update ko diri
}
