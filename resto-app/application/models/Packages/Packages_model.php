<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Packages_model extends CI_Model {
 
    var $table = 'packages';

    var $column_order = array('pack_id','name','short_name','descr','price','sold','encoded',null); //set column field database for datatable orderable
    var $column_search = array('pack_id','name','short_name','descr','price','sold','encoded'); //set column field database for datatable searchable

    var $order = array('pack_id' => 'desc'); // default order 
 
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

        $this->db->order_by("name", "asc");
        
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

    // check for duplicates in the database table for validation
    function get_sn_duplicates($short_name)
    {      
        $this->db->from($this->table);
        $this->db->where('short_name',$short_name);

        $query = $this->db->get();

        return $query;
    }

    // get both id and names
    function get_packages()
    {
        $this->db->from($this->table);

        $this->db->where('removed', '0');

        $this->db->order_by("name", "asc");

        $query = $this->db->get();

        return $query->result();
    }

    // get both id and names
    function get_packages_annual($year)
    {
        $this->db->from($this->table);

        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('encoded <=', $date_to);

        $this->db->where('removed', '0');

        $this->db->order_by("name", "asc");

        $query = $this->db->get();

        return $query->result();
    }

    // get both id and names
    function get_packages_monthly($year, $month)
    {
        $this->db->from($this->table);

        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('encoded <=', $date_to);

        $this->db->where('removed', '0');

        $this->db->order_by("name", "asc");

        $query = $this->db->get();

        return $query->result();
    }

    // get both id and names
    function get_packages_custom($date_to)
    {
        $this->db->from($this->table);

        $date_to = $date_to . ' 23:59:59';

        $this->db->where('encoded <=', $date_to);

        $this->db->where('removed', '0');

        $this->db->order_by("name", "asc");

        $query = $this->db->get();

        return $query->result();
    }

    function get_package_id($name)
    {
        $this->db->select('pack_id');
        $this->db->from($this->table);
        $this->db->where('name',$name);

        $query = $this->db->get();

        $row = $query->row();

        return $row->pack_id;
    }

    function get_package_name($pack_id)
    {
        $this->db->select('name');
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->name;
    }

    function get_package_short_name($pack_id)
    {
        $this->db->select('short_name');
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->short_name;
    }

    function get_package_price($pack_id)
    {
        $this->db->select('price');
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->price;
    }

    function get_package_img($pack_id)
    {
        $this->db->select('img');
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->img;
    }

    function get_total_pack_sold()
    {
        $this->db->select('SUM(sold) as total_sold');
        $this->db->from($this->table);

        $this->db->where('removed', '0');
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->total_sold;
    }

    function get_total_pack_sold_annual($year)
    {
        $query = $this->db->query("select SUM(trans_details.qty) as total_sold from packages inner join trans_details on packages.pack_id = trans_details.pack_id inner join transactions on trans_details.trans_id = transactions.trans_id where packages.removed = 0 and trans_details.prod_type = 1 and transactions.status = 'CLEARED' and transactions.datetime >= '" . $year . "-01-01 00:00:00' and transactions.datetime <= '" . $year . "-12-31 23:59:59'");

        $row = $query->row();

        return $row->total_sold;
    }

    function get_total_pack_sold_monthly($year, $month)
    {
        $query = $this->db->query("select SUM(trans_details.qty) as total_sold from packages inner join trans_details on packages.pack_id = trans_details.pack_id inner join transactions on trans_details.trans_id = transactions.trans_id where packages.removed = 0 and trans_details.prod_type = 1 and transactions.status = 'CLEARED' and transactions.datetime >= '" . $year . "-" . $month . "-01 00:00:00' and transactions.datetime <= '" . $year . "-" . $month . "-31 23:59:59'");

        $row = $query->row();

        return $row->total_sold;
    }

    function get_total_pack_sold_custom($date_from, $date_to)
    {
        $query = $this->db->query("select SUM(trans_details.qty) as total_sold from packages inner join trans_details on packages.pack_id = trans_details.pack_id inner join transactions on trans_details.trans_id = transactions.trans_id where packages.removed = 0 and trans_details.prod_type = 1 and transactions.status = 'CLEARED' and transactions.datetime >= '" . $date_from . "' and transactions.datetime <= '" . $date_to . "'");

        $row = $query->row();

        return $row->total_sold;
    }

    function get_pack_sold_by_id_annual($pack_id, $year)
    {
        $query = $this->db->query("select SUM(trans_details.qty) as total_sold from packages inner join trans_details on packages.pack_id = trans_details.pack_id inner join transactions on trans_details.trans_id = transactions.trans_id where packages.removed = 0 and trans_details.prod_type = 1 and trans_details.pack_id = '" . $pack_id . "' and transactions.status = 'CLEARED' and transactions.datetime >= '" . $year . "-01-01 00:00:00' and transactions.datetime <= '" . $year . "-12-31 23:59:59'");

        $row = $query->row();

        return $row->total_sold;
    }

    function get_pack_sold_by_id_monthly($pack_id, $year, $month)
    {
        $query = $this->db->query("select SUM(trans_details.qty) as total_sold from packages inner join trans_details on packages.pack_id = trans_details.pack_id inner join transactions on trans_details.trans_id = transactions.trans_id where packages.removed = 0 and trans_details.prod_type = 1 and trans_details.pack_id = '" . $pack_id . "' and transactions.status = 'CLEARED' and transactions.datetime >= '" . $year . "-" . $month . "-01 00:00:00' and transactions.datetime <= '" . $year . "-" . $month . "-31 23:59:59'");

        $row = $query->row();

        return $row->total_sold;
    }

    function get_pack_sold_by_id_custom($pack_id, $date_from, $date_to)
    {
        $query = $this->db->query("select SUM(trans_details.qty) as total_sold from packages inner join trans_details on packages.pack_id = trans_details.pack_id inner join transactions on trans_details.trans_id = transactions.trans_id where packages.removed = 0 and trans_details.prod_type = 1 and trans_details.pack_id = '" . $pack_id . "' and transactions.status = 'CLEARED' and transactions.datetime >= '" . $date_from . "' and transactions.datetime <= '" . $date_to . "'");

        $row = $query->row();

        return $row->total_sold;
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

    public function count_all_annual($year)
    {
        $this->db->from($this->table);

        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('encoded <=', $date_to);

        // get only records that are not currently removed
        $this->db->where('removed', '0');
        return $this->db->count_all_results();
    }

    public function count_all_monthly($year, $month)
    {
        $this->db->from($this->table);

        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('encoded <=', $date_to);

        // get only records that are not currently removed
        $this->db->where('removed', '0');
        return $this->db->count_all_results();
    }

    public function count_all_custom($date_to)
    {
        $this->db->from($this->table);

        $date_to = $date_to . ' 23:59:59';

        $this->db->where('encoded <=', $date_to);

        // get only records that are not currently removed
        $this->db->where('removed', '0');
        return $this->db->count_all_results();
    }
 
    public function get_by_id($pack_id)
    {
        $this->db->from($this->table);
        $this->db->where('pack_id',$pack_id);
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

    public function update_sold_pack($pack_id, $qty)
    {
        $this->db->set('sold', 'sold + ' . (int) $qty, FALSE);
        $this->db->where('pack_id',$pack_id);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }
}