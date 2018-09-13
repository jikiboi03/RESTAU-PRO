<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class PO_temp_model extends CI_Model {
 
    var $table = 'po_temp';

    var $column_order = array('num','item_id','item_name','unit_qty','unit_name','pcs_qty',null); //set column field database for datatable orderable
    var $column_search = array('item_id','item_name','unit_qty','unit_name','pcs_qty'); //set column field database for datatable searchable

    var $order = array('num' => 'asc'); // date descending order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->select('po_temp.*, items.name AS item_name, units.name AS unit_name');
        $this->db->from($this->table);

        $this->db->join('items', 'items.item_id = po_temp.item_id');
        $this->db->join('units', 'units.unit_id = po_temp.unit_id');
 
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
        $this->db->select('po_temp.*, items.name AS item_name, units.name AS unit_name');
        $this->db->from($this->table);

        $this->db->join('items', 'items.item_id = po_temp.item_id');
        $this->db->join('units', 'units.unit_id = po_temp.unit_id');

        $query = $this->db->get();
        return $query->result();
    }

    // get both id and names
    function get_po_temp_items()
    {
        $this->db->select('po_temp.*, items.name AS item_name, units.name AS unit_name');
        $this->db->from($this->table);

        $this->db->join('items', 'items.item_id = po_temp.item_id');
        $this->db->join('units', 'units.unit_id = po_temp.unit_id');

        $query = $this->db->get();

        return $query->result();
    }

    // check if the parent data has children in FK
    // function check_if_found($pack_id)
    // {      
    //     $this->db->from($this->table);
    //     $this->db->where('pack_id',$pack_id);

    //     $query = $this->db->get();

    //     return $query;
    // }
 
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
 
    public function get_by_id($num)
    {
        $this->db->from($this->table);
        $this->db->where('num',$num);

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

    public function delete_by_id($num)
    {
        $this->db->where('num', $num);
        $this->db->delete($this->table);
    }
}