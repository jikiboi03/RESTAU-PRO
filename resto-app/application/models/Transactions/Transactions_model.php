<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Transactions_model extends CI_Model {
 
    var $table = 'transactions';

    var $column_order = array('trans_id','datetime','order_type',null,'discount',null,'method','user_id',null); //set column field database for datatable orderable
    var $column_search = array('trans_id','datetime','order_type','discount','method','user_id'); //set column field database for datatable searchable

    var $order = array('trans_id' => 'desc'); // default order 
 
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
 
    function get_datatables($trans_status)
    {        
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);

        if ($trans_status == 0)
        {
            $this->db->where('status','ONGOING'); // if data is part of the object by ID    
        }
        else if ($trans_status == 1)
        {
            $this->db->where('status','CLEARED'); // if data is part of the object by ID       
        }
        else if ($trans_status == 2)
        {
            $this->db->where('status','CANCELLED'); // if data is part of the object by ID       
        }
        else if ($trans_status == 3)
        {
            $this->db->where('status','REFUNDED'); // if data is part of the object by ID       
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_api_datatables()
    {        
        $this->db->from($this->table);

        $this->db->order_by("trans_id", "desc");
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_trans_by_status($status)
    {        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }
        
        $this->db->order_by("trans_id", "desc");
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_trans_by_status_annual($status, $year)
    {        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $this->db->order_by("trans_id", "desc");
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_trans_by_status_monthly($status, $year, $month)
    {        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $this->db->order_by("trans_id", "desc");
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_trans_by_status_custom($status, $date_from, $date_to)
    {        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $this->db->order_by("trans_id", "desc");
        
        $query = $this->db->get();
        return $query->result();
    }

    function get_trans_status($trans_id)
    {
        $this->db->select('status');
        $this->db->from($this->table);
        $this->db->where('trans_id',$trans_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->status;
    }

    function get_last_receipt_no() // function to get the last receipt number to increment in every receipt generation
    {
        $this->db->select_max('receipt_no');
        $this->db->from($this->table);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->receipt_no;
    }

    function get_last_receipt_transaction_data() // function to get the last receipt number to increment in every receipt generation
    {
        $this->db->select('receipt_no, trans_id');
        $this->db->from($this->table);

        $this->db->order_by("receipt_no", "desc");
        $this->db->limit(1);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function get_total_net_sales_by_status($status)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_net_sales_by_status_annual($status, $year)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_net_sales_by_status_monthly($status, $year, $month)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_net_sales_by_status_custom($status, $date_from, $date_to)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    // get monthly net sales specified by month and year
    public function get_monthly_net_sales($month, $year)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $status = array('CLEARED', 'REFUNDED');
        $this->db->where_in('status', $status);

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    // get daily net sales
    public function get_daily_net_sales($date)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $status = array('CLEARED', 'REFUNDED');
        $this->db->where_in('status', $status);

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    // get shift net sales
    public function get_daily_net_sales_shift($date, $cashier_id) // disregarded refund status
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $status = array('CLEARED');
        $this->db->where_in('status', $status);

        $this->db->where('cashier_id', $cashier_id);

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    public function get_total_discounts_rendered_by_status($status)
    {
        $this->db->select('SUM(discount) AS discount');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }
        
        $query = $this->db->get();

        return $query->row()->discount + 0;
    }

    public function get_total_discounts_rendered_by_status_annual($status, $year)
    {
        $this->db->select('SUM(discount) AS discount');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->discount + 0;
    }

    public function get_total_discounts_rendered_by_status_monthly($status, $year, $month)
    {
        $this->db->select('SUM(discount) AS discount');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->discount + 0;
    }

    public function get_total_discounts_rendered_by_status_custom($status, $date_from, $date_to)
    {
        $this->db->select('SUM(discount) AS discount');    
        
        $this->db->from($this->table);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->discount + 0;
    }

    // get daily net sales
    public function get_daily_discounts_rendered($date)
    {
        $this->db->select('SUM(discount) AS discount');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->discount + 0;
    }

    // get daily net sales by discount type
    public function get_daily_discounts_rendered_type($date, $disc_type)
    {
        $this->db->select('SUM(discount) AS discount');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('status', 'CLEARED'); // transaction status should be cleared (paid by customer already)

        if ($disc_type != 0)
        {
            $this->db->where('disc_type', $disc_type); // can be SC or PWD
        }
        else
        {
            $this->db->where('disc_type !=', 1); // not equal to SC
            $this->db->where('disc_type !=', 2); // not equal to PWD
        }

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->discount + 0;
    }

    // get daily net sales
    public function get_daily_discounts_rendered_shift($date, $cashier_id, $disc_type)
    {
        $this->db->select('SUM(discount) AS discount');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('cashier_id', $cashier_id);

        if ($disc_type != 0)
        {
            $this->db->where('disc_type', $disc_type); // can be SC or PWD
        }
        else
        {
            $this->db->where('disc_type !=', 1); // not equal to SC
            $this->db->where('disc_type !=', 2); // not equal to PWD
        }

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->discount + 0;
    }

     // get daily net sales by status
    public function get_daily_sales_by_status($date, $status)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('status', $status); // transaction status should be cleared (paid by customer already)

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    // get daily net sales
    public function get_daily_sales_by_status_shift($date, $cashier_id, $status)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('status', $status); // transaction status should be cleared (paid by customer already)
        $this->db->where('cashier_id', $cashier_id);

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    // get transaction count based on user_id
    public function get_count_trans_cashier($cashier_id)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('cashier_id', $cashier_id);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }
    // get transaction count based on user_id
    public function get_count_trans_cashier_annual($cashier_id, $year)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('cashier_id', $cashier_id);

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }
    // get transaction count based on user_id
    public function get_count_trans_cashier_monthly($cashier_id, $year, $month)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('cashier_id', $cashier_id);

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }
    // get transaction count based on user_id
    public function get_count_trans_cashier_custom($cashier_id, $date_from, $date_to)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('cashier_id', $cashier_id);

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get transaction count based on user_id
    public function get_count_trans_staff($staff_id)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('user_id', $staff_id);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }
    // get transaction count based on user_id
    public function get_count_trans_staff_annual($staff_id, $year)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('user_id', $staff_id);

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }
    // get transaction count based on user_id
    public function get_count_trans_staff_monthly($staff_id, $year, $month)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('user_id', $staff_id);

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }
    // get transaction count based on user_id
    public function get_count_trans_staff_custom($staff_id, $date_from, $date_to)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('user_id', $staff_id);

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get total net sales by user_id
    public function get_total_net_sales_by_cashier($cashier_id)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('cashier_id', $cashier_id);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    // get total net sales by user_id
    public function get_total_net_sales_by_staff($user_id)
    {
        $this->db->select('SUM(cash_amt - change_amt) AS total');    
        
        $this->db->from($this->table);

        $this->db->where('user_id', $user_id);
        
        $query = $this->db->get();

        return $query->row()->total + 0;
    }

    // get daily transaction count based on order type
    public function get_count_trans_total($status, $order_type)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('order_type', $order_type);

        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get all transaction count based on order type
    public function get_count_trans_total_annual($status, $order_type, $year)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('order_type', $order_type);
        
        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get all transaction count based on order type
    public function get_count_trans_total_monthly($status, $order_type, $year, $month)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('order_type', $order_type);
        
        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get all transaction count based on order type
    public function get_count_trans_total_custom($status, $order_type, $date_from, $date_to)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $this->db->where('order_type', $order_type);
        
        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('status', $status);   
        }

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get daily transaction count based on order type
    public function get_count_trans_today($date, $order_type)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('order_type', $order_type);
        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get daily transaction count based on status
    public function get_count_trans_today_status($date, $status)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('status', $status);
        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get current shift transaction count based on order type
    public function get_count_trans_shift($date, $order_type, $cashier_id)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('order_type', $order_type);
        $this->db->where('cashier_id', $cashier_id);
        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get current shift transaction count based on status
    public function get_count_trans_shift_status($date, $status, $cashier_id)
    {
        $this->db->select('COUNT(trans_id) AS trans_count');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        $this->db->where('status', $status);
        $this->db->where('cashier_id', $cashier_id);
        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->trans_count + 0;
    }

    // get current shift beginning receipt
    public function get_start_rcpt($date, $cashier_id)
    {
        $this->db->select('MIN(receipt_no) AS receipt_no');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        if ($cashier_id != 0) // if zero, consider as x reading (daily)
        {
            $this->db->where('cashier_id', $cashier_id);    
        }
        
        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->receipt_no + 0;
    }

    // get current shift end receipt
    public function get_end_rcpt($date, $cashier_id)
    {
        $this->db->select('MAX(receipt_no) AS receipt_no');    
        
        $this->db->from($this->table);

        $date_from = $date . ' 00:00:00'; // get date today to filter
        $date_to = $date . ' 23:59:59';

        if ($cashier_id != 0) // if zero, consider as x reading (daily)
        {
            $this->db->where('cashier_id', $cashier_id);    
        }

        $this->db->where('datetime >=', $date_from);
        $this->db->where('datetime <=', $date_to);
        
        $query = $this->db->get();

        return $query->row()->receipt_no + 0;
    }
 
    function count_filtered($trans_status)
    {
        $this->_get_datatables_query();

        if ($trans_status == 0)
        {
            $this->db->where('status','ONGOING'); // if data is part of the object by ID    
        }
        else if ($trans_status == 1)
        {
            $this->db->where('status','CLEARED'); // if data is part of the object by ID       
        }
        else if ($trans_status == 2)
        {
            $this->db->where('status','CANCELLED'); // if data is part of the object by ID       
        }
        else if ($trans_status == 3)
        {
            $this->db->where('status','REFUNDED'); // if data is part of the object by ID       
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($trans_status)
    {
        $this->db->from($this->table);

        if ($trans_status == 0)
        {
            $this->db->where('status','ONGOING'); // if data is part of the object by ID    
        }
        else if ($trans_status == 1)
        {
            $this->db->where('status','CLEARED'); // if data is part of the object by ID       
        }
        else if ($trans_status == 2)
        {
            $this->db->where('status','CANCELLED'); // if data is part of the object by ID       
        }
        else if ($trans_status == 3)
        {
            $this->db->where('status','REFUNDED'); // if data is part of the object by ID       
        }

        return $this->db->count_all_results();
    }
 
    public function get_by_id($trans_id)
    {
        $this->db->from($this->table);
        $this->db->where('trans_id',$trans_id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_by_receipt_no($receipt_no) // get transaction by receipt number
    {
        $this->db->from($this->table);
        $this->db->where('receipt_no',$receipt_no);
        $query = $this->db->get();
 
        return $query->row();
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