<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Prod_discounts_model extends CI_Model {
 
    var $table = 'prod_discounts';

    var $column_order = array('pd_id','prod_id',null,'remarks','date_start','date_end','status','new_price',null,null,'encoded'); //set column field database for datatable orderable
    var $column_search = array('pd_id','prod_id','remarks','date_start','date_end','status','new_price','encoded'); //set column field database for datatable searchable

    var $order = array('pd_id' => 'desc'); // default order 
 
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

        // get only records that are not currently removed
        $this->db->where('removed', '0');
        $query = $this->db->get();
        return $query->result();
    }

    function get_api_datatables()
    {        
        $this->db->from($this->table);

        // get only records that are not currently removed
        $this->db->where('removed', '0');
        
        $query = $this->db->get();
        return $query->result();
    }

    // check for duplicates in the database table for validation
    function get_duplicates($prod_id)
    {      
        $this->db->from($this->table);
        $this->db->where('prod_id',$prod_id);

        $query = $this->db->get();

        return $query;
    }

    // get both id and names
    function get_prod_discounts()
    {
        $this->db->from($this->table);

        $this->db->where('removed', '0');

        $query = $this->db->get();

        return $query->result();
    }

    function get_prod_discount_id($prod_id)
    {
        $this->db->select('pd_id');
        $this->db->from($this->table);
        $this->db->where('prod_id',$prod_id);

        $query = $this->db->get();

        $row = $query->row();

        return $row->pd_id;
    }

    function get_prod_discount_name($pd_id)
    {
        $this->db->select('prod_id');
        $this->db->from($this->table);
        $this->db->where('pd_id',$pd_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->prod_id;
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();

        // get only records that are not currently remove
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
 
    public function get_by_id($pd_id)
    {
        $this->db->from($this->table);
        $this->db->where('pd_id',$pd_id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_by_prod_id($prod_id)
    {
        $result = null;

        try {

            $this->db->from($this->table);
            $this->db->where('prod_id',$prod_id);

            $this->db->where('status', 'ACTIVE');
            $query = $this->db->get();
            
            $result = $query->row();
            
        } catch (Exception $e) {
            
        }
        return $result;
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