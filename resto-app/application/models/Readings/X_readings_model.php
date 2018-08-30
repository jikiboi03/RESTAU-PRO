<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class X_readings_model extends CI_Model {
 
    var $table = 'x_readings';

    var $column_order = array('reading_no', 'pos_no', 'cashier_username', 'date', 'trans_count_dine_in', 'trans_count_take_out', 'trans_count_total', 'trans_count_cleared', 'trans_count_cancelled', 'trans_count_refunded', 'void_items_count', 'net_sales', 'discounts_rendered_sc', 'discounts_rendered_pwd', 'discounts_rendered_promo', 'discounts_rendered_total', 'gross_sales', 'cancelled_sales', 'refunded_sales', 'vat_sales', 'vat_amount', 'vat_exempt', 'start_rcpt_no', 'end_rcpt_no','encoded'); //set column field database for datatable orderable
    var $column_search = array('reading_no', 'pos_no', 'cashier_username', 'date', 'trans_count_dine_in', 'trans_count_take_out', 'trans_count_total', 'trans_count_cleared', 'trans_count_cancelled', 'trans_count_refunded', 'void_items_count', 'net_sales', 'discounts_rendered_sc', 'discounts_rendered_pwd', 'discounts_rendered_promo', 'discounts_rendered_total', 'gross_sales', 'cancelled_sales', 'refunded_sales', 'vat_sales', 'vat_amount', 'vat_exempt', 'start_rcpt_no', 'end_rcpt_no','encoded'); //set column field database for datatable searchable

    var $order = array('reading_no' => 'desc'); // default order 
 
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

    function get_api_datatables()
    {        
        $this->db->from($this->table);
        
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
 
    public function get_by_id($reading_no)
    {
        $this->db->from($this->table);
        $this->db->where('reading_no',$reading_no);
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