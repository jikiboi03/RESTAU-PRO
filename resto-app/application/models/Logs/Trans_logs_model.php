<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Trans_logs_model extends CI_Model {
 
    var $table = 'trans_logs';

    var $column_order = array('log_id','log_type','details','user_fullname','date_time'); //set 

    var $column_search = array('log_id','log_type','details','user_fullname','date_time'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('log_id' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
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

        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();

        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function get_total_void_shift($date, $username)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Void');

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_by_user($username)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Void');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_by_user_annual($username, $year)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Void');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_by_user_monthly($username, $year, $month)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Void');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_by_user_custom($username, $date_from, $date_to)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Void');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_cancelled_by_user($username)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Cancel');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_cancelled_by_user_annual($username, $year)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Cancel');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_cancelled_by_user_monthly($username, $year, $month)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Cancel');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_cancelled_by_user_custom($username, $date_from, $date_to)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Cancel');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_refunded_by_user($username)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Refund');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_refunded_by_user_annual($username, $year)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Refund');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_refunded_by_user_monthly($username, $year, $month)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Refund');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_refunded_by_user_custom($username, $date_from, $date_to)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);

        $this->db->where('user_fullname', $username);
        $this->db->where('log_type', 'Refund');

        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_today($date)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('log_type', 'Void');

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void()
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('log_type', 'Void');
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_annual($year)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('log_type', 'Void');

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_monthly($year, $month)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('log_type', 'Void');

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_void_custom($date_from, $date_to)
    {
        $this->db->select('COUNT(log_id) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('log_type', 'Void');

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('date_time >=', $date_from);
        $this->db->where('date_time <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }
}