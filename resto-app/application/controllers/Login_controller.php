<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Login_controller extends CI_Controller{ 				/** Note: ayaw ilisi ang sequence sa page load sa page **/	
		public function __construct()
		{
		    parent::__construct();
		    $this->load->model('Login/Login_user_model','login_model');
		    $this->load->model('Logs/Logs_model','logs');
		}

	   public function index()
	   {						
	   	  $this->load->helper('url');							
	      $this->load->view('login_view');
	   }

	   public function login_validation()
	   {

	   	$this->load->library('form_validation');
	   	$this->form_validation->set_rules('username','Username','required');
	   	$this->form_validation->set_rules('password', 'Password','required');
	
		if($this->form_validation->run())
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			

			$result = $this->login_model->can_login($username, $password);

			if($result != false)
			{
				$new_array = array();
				foreach($result as $row)
				{
					$new_array = array(
					'user_id' => $row->user_id,
					'username' => $row->username,
					'lastname' => $row->lastname,
					'firstname' => $row->firstname,
					'middlename' => $row->middlename,
					'email' => $row->email,
					'administrator' => $row->administrator,
					'cashier' => $row->cashier,
					'staff' => $row->staff);

					$this->session->set_userdata($new_array);
				}

				// set login log ------------------------------------------------------------------
				$log_type = 'Login';
				
				if ($this->session->userdata('administrator') == 0)
				{
					$details = 'System user login as Staff';
				}
				else
				{
					$details = 'System user login as Administrator';	
				}
				// set log
				$this->ajax_add_log($log_type, $details);

				// go to dashboard
				redirect(base_url().'dashboard');
			}
			else
			{
				$this->session->set_flashdata('error', '<strong>Login Error!</strong><br />Invalid Username and Password');
				redirect('/');
				
			}
		}
		else{
			$this->session->set_flashdata('error', '<strong>Login Error!</strong><br />Enter your username and Password');
			redirect('/');//false
		}
			
	   }

	   public function enter(){
	   	if($this->session->userdata('username') != ''){
	   		$data['username'] = $this->session->userdata('username');
	   	}else{
	   		redirect('/');
	   	}

	   }

	   public function logout()
	   {
	   		// set login log ------------------------------------------------------------------
	   		$log_type = 'Logout';
	   		
	   		if ($this->session->userdata('administrator') == 0)
	   		{
	   			$details = 'System user logout as Staff';
	   		}
	   		else
	   		{
	   			$details = 'System user logout as Administrator';	
	   		}
	   		// set log
	   		$this->ajax_add_log($log_type, $details);

	   		$this->session->sess_destroy();
	   		redirect('/');
	   }

	   public function ajax_add_log($log_type, $details)
	   {
	       $user_fullname = $this->session->userdata('lastname') . ', ' . $this->session->userdata('firstname');

	       $data = array(

	               'user_fullname' => $user_fullname,
	               'log_type' => $log_type,
	               'details' => $details
	           );
	       $insert = $this->logs->save($data);
	   }

	}