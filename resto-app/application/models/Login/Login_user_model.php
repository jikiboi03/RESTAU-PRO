<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Login_user_model extends CI_Model{

		var $table = 'users';
		
		function can_login($username, $password)
		{
			//$hash = password_verify($password);
			//$hash = password_hash($password,PASSWORD_BCRYPT);
		
			$this->db->from('users');
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			
			$this->db->where('removed', 0);

			$query = $this->db->get();
			// $this->db->where('username', $username);
			// $this->db->where('password', $password);
			// $query = $this->db->get('users');
			//SELECT * FROM users WHERE username = '$username' AND password = '$password'

			if($query->num_rows() > 0){
				return $res = $query->result();
			}else{
				return false;
			}
		}
	}