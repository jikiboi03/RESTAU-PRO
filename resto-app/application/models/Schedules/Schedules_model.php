<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Schedules_model extends CI_Model {
 
    var $table = 'schedules';

    var $column_order = array('sched_id','title','date','time','remarks','username',null,'encoded',null); //set column field database for datatable orderable
    var $column_search = array('sched_id','title','date','time','remarks','username','encoded'); //set column field database for datatable searchable

    var $order = array('sched_id' => 'desc'); // default order 
 
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

    // get both id and names
    function get_schedule()
    {
        $this->db->from($this->table);

        $query = $this->db->get();

        return $query->result();
    }

    // get schedules for today
    function get_schedules_today($today)
    {
        $this->db->from($this->table);
        $this->db->where('date',$today);

        $query = $this->db->get();

        return $query->result();
    }

    function get_sched_id($title)
    {
        $this->db->select('sched_id');
        $this->db->from($this->table);
        $this->db->where('title',$title);

        $query = $this->db->get();

        $row = $query->row();

        return $row->sched_id;
    }

    function get_barangay_name($sched_id)
    {
        $this->db->select('title');
        $this->db->from($this->table);
        $this->db->where('sched_id',$sched_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->title;
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
 
    public function get_by_id($sched_id)
    {
        $this->db->from($this->table);
        $this->db->where('sched_id',$sched_id);
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

    // delete schedule data
    public function delete_by_id($sched_id)
    {
        $this->db->where('sched_id', $sched_id);
        $this->db->delete($this->table);
    }
}