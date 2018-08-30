<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('template/dashboard_header');
		$this->load->view('template/dashboard_sidebar');
		$this->load->view('index');
		$this->load->view('template/dashboard_footer');
	}
}
