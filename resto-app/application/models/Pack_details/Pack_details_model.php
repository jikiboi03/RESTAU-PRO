<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pack_details_model extends CI_Model {
 
    var $table = 'pack_details';

    var $column_order = array('prod_id','qty','encoded',null); //set column field database for datatable orderable
    var $column_search = array('prod_id','qty','encoded'); //set column field database for datatable searchable

    var $order = array('encoded' => 'desc'); // date descending order 
 
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
 
    function get_datatables($pack_id)
    {        
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->where('pack_id',$pack_id); // if data is part of the object by ID

        $query = $this->db->get();
        return $query->result();
    }

    function get_api_datatables($pack_id) // api function in getting data list
    {        
        $this->db->from($this->table);

        $this->db->where('pack_id',$pack_id); // if data is part of the object by ID

        $query = $this->db->get();
        return $query->result();
    }

    // check for duplicates in the database table for validation
    function get_duplicates($pack_id, $prod_id)
    {      
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);
        $this->db->where('prod_id',$prod_id);

        $query = $this->db->get();

        return $query;
    }

    // get both id and names
    function get_pack_detail_products($pack_id)
    {
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);

        $query = $this->db->get();

        return $query->result();
    }

    // check if the parent data has children in FK
    function check_if_found($pack_id)
    {      
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);

        $query = $this->db->get();

        return $query;
    }
 
    function count_filtered($pack_id)
    {
        $this->_get_datatables_query();
        $this->db->where('pack_id',$pack_id);

        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($pack_id)
    {
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);

        return $this->db->count_all_results();
    }
 
    public function get_by_id($pack_id, $prod_id)
    {
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);
        $this->db->where('prod_id',$prod_id);

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

    public function delete_by_id($pack_id, $prod_id)
    {
        $this->db->where('pack_id', $pack_id);
        $this->db->where('prod_id', $prod_id);
        $this->db->delete($this->table);
    }
}