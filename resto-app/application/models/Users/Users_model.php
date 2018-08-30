<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	var $table = 'users';
	var $column_order = array('user_id','user_type','username','lastname','firstname','middlename','date_registered', null); //set column field database for datatable orderable
	var $column_search = array('user_id','username','lastname','firstname','middlename'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('user_id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		//$this->db->where('removed', 0);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);

		// get only records that are not currently removed
        $this->db->where('removed', '0');
		$query = $this->db->get();
		return $query->result();
	}

	function get_api_datatables()
	{        
	    $this->db->from($this->table);

	    $this->db->where('removed', '0');
	    
	    $query = $this->db->get();
	    return $query->result();
	}

	function get_api_datatables_annual($year)
	{        
	    $this->db->from($this->table);

	    $this->db->where('removed', '0');

	    $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('date_registered <=', $date_to);
	    
	    $query = $this->db->get();
	    return $query->result();
	}

	function get_api_datatables_monthly($year, $month)
	{        
	    $this->db->from($this->table);

	    $this->db->where('removed', '0');
	    
	    $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('date_registered <=', $date_to);
	    
	    $query = $this->db->get();
	    return $query->result();
	}

	function get_api_datatables_custom($date_to)
	{        
	    $this->db->from($this->table);

	    $this->db->where('removed', '0');
	    
	    $date_to = $date_to . ' 23:59:59';

        $this->db->where('date_registered <=', $date_to);
	    
	    $query = $this->db->get();
	    return $query->result();
	}

	// check for duplicates in the database table for validation - fullname
    function get_duplicates($lastname, $firstname, $middlename)
    {
        $this->db->from($this->table);
        $this->db->where('lastname',$lastname);
        $this->db->where('firstname',$firstname);
        $this->db->where('middlename',$middlename);

        $query = $this->db->get();

        return $query;
    }

    // check for duplicates in the database table for validation - username
    function get_username_duplicates($username)
    {
        $this->db->from($this->table);
        $this->db->where('username',$username);

        $query = $this->db->get();

        return $query;
    }

    // check for admin count (administrator is '1')
    function get_admin_count()
    {
        $this->db->from($this->table);
        $this->db->where('administrator','1');

        $query = $this->db->get();

        return $query;
    }

    function get_cashier_users()
    {        
        $this->db->from($this->table);

        $this->db->where('cashier', 1);
        $this->db->where('removed', 0);
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_staff_users()
    {        
        $this->db->from($this->table);

        $this->db->where('staff', 1);
        $this->db->where('removed', 0);
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_type_count($user_type) // get count based on user_type
    {        
        $this->db->from($this->table);

        $this->db->where($user_type, 1);
        $this->db->where('removed', 0);

        return $this->db->count_all_results();
    }

    function get_user_type_count_annual($user_type, $year) // get count based on user_type
    {        
        $this->db->from($this->table);

        $this->db->where($user_type, 1);
        $this->db->where('removed', 0);

        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('date_registered <=', $date_to);

        return $this->db->count_all_results();
    }

    function get_user_type_count_monthly($user_type, $year, $month) // get count based on user_type
    {        
        $this->db->from($this->table);

        $this->db->where($user_type, 1);
        $this->db->where('removed', 0);

        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('date_registered <=', $date_to);

        return $this->db->count_all_results();
    }

    function get_user_type_count_custom($user_type, $date_to) // get count based on user_type
    {        
        $this->db->from($this->table);

        $this->db->where($user_type, 1);
        $this->db->where('removed', 0);

        $date_to = $date_to . ' 23:59:59';

        $this->db->where('date_registered <=', $date_to);

        return $this->db->count_all_results();
    }

	function count_filtered()
	{
		$this->_get_datatables_query();

		// get only records that are not currently removed
        $this->db->where('removed', '0');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		// get only records that are not currently removed
        $this->db->where('removed', '0');
		return $this->db->count_all_results();
	}

	public function count_all_annual($year)
	{
		$this->db->from($this->table);

		// get only records that are not currently removed
        $this->db->where('removed', '0');

        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('date_registered <=', $date_to);

		return $this->db->count_all_results();
	}

	public function count_all_monthly($year, $month)
	{
		$this->db->from($this->table);

		// get only records that are not currently removed
        $this->db->where('removed', '0');

        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('date_registered <=', $date_to);

		return $this->db->count_all_results();
	}

	public function count_all_custom($date_to)
	{
		$this->db->from($this->table);

		// get only records that are not currently removed
        $this->db->where('removed', '0');

        $date_to = $date_to . ' 23:59:59';

        $this->db->where('date_registered <=', $date_to);

		return $this->db->count_all_results();
	}

	public function get_by_id($user_id)
	{
		$this->db->from($this->table);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();

		return $query->row();
	}

	// check if the user is administrator ('1')
	public function get_user_admin($user_id)
	{
		$this->db->select('administrator');
		$this->db->from($this->table);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();

		$row = $query->row();

		return $row->administrator;
	}

	// check if the user is cashier ('1')
	public function get_user_cashier($user_id)
	{
		$this->db->select('cashier');
		$this->db->from($this->table);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();

		$row = $query->row();

		return $row->cashier;
	}

	// check if the user is staff ('1')
	public function get_user_staff($user_id)
	{
		$this->db->select('staff');
		$this->db->from($this->table);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();

		$row = $query->row();

		return $row->staff;
	}

	// get username
	public function get_username($user_id)
	{
		$this->db->select('username');
		$this->db->from($this->table);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();

		$row = $query->row();

		return $row->username;
	}

    // check if the user is administrator ('1')
	public function get_user_lastname($user_id)
	{
		$this->db->select('lastname');
		$this->db->from($this->table);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();

		$row = $query->row();

		return $row->lastname;
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
}
