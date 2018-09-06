<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class PO_model extends CI_Model {
 
    var $table = 'po';

    var $column_order = array('po_id','supplier_name','username','date','status','encoded',null); //set column field database for datatable orderable
    var $column_search = array('po_id','supplier_name','username','date','status','encoded'); //set column field database for datatable searchable

    var $order = array('po_id' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $this->db->select('po.*, suppliers.name, users.username');
        $this->db->from($this->table);

        $this->db->join('suppliers', 'suppliers.supplier_id = po.supplier_id');
        $this->db->join('users', 'users.user_id = po.user_id');
 
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

    function get_api_datatables() // api function in getting data list
    {        
        $this->db->select('po.*, suppliers.name, users.username');
        $this->db->from($this->table);

        $this->db->join('suppliers', 'suppliers.supplier_id = po.supplier_id');
        $this->db->join('users', 'users.user_id = po.user_id');
        
        $query = $this->db->get();
        return $query->result();
    }

    // check for duplicates in the database table for validation
    function get_duplicates($name)
    {      
        $this->db->from($this->table);
        $this->db->where('name',$name);

        $query = $this->db->get();

        return $query;
    }

    // get both id and names
    function get_items()
    {
        $this->db->select('po.*, suppliers.name, users.username');
        $this->db->from($this->table);

        $this->db->join('suppliers', 'suppliers.supplier_id = po.supplier_id');
        $this->db->join('users', 'users.user_id = po.user_id');

        $this->db->order_by("po_id", "desc");

        $query = $this->db->get();

        return $query->result();
    }

    function get_supplier_id($po_id)
    {
        $this->db->select('supplier_id');
        $this->db->from($this->table);
        $this->db->where('po_id',$po_id);

        $query = $this->db->get();

        $row = $query->row();

        return $row->supplier_id;
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
 
    public function get_by_id($po_id)
    {
        $this->db->from($this->table);
        $this->db->where('po_id',$po_id);
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