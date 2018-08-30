<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Trans_details_model extends CI_Model {
 
    var $table = 'trans_details';

    var $column_order = array(null,null,'price','qty','total',null); //set column field database for datatable orderable
    var $column_search = array('price','qty','total'); //set column field database for datatable searchable

    var $order = array('trans_id' => 'desc'); // date descending order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $this->db->from($this->table);
 
        $i = 0;
    }

    private function _get_datatables_query_sold_today()
    {   
        $this->db->from($this->table);
 
        $i = 0;
    }
 
    function get_datatables($trans_id)
    {        
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->where('trans_id',$trans_id); // if data is part of the object by ID

        $query = $this->db->get();
        return $query->result();
    }

    function get_datatables_sold_today()
    {   
        $this->_get_datatables_query_sold_today();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);

        $this->db->select('trans_details.prod_id as prod_id, trans_details.pack_id as pack_id, trans_details.prod_type as prod_type, SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $today = date('Y-m-d');
        $date_from = $today . ' 00:00:00'; // get date today to filter
        $date_to = $today . ' 23:59:59';

        $this->db->where('trans_details.prod_type !=', 2); // no package-product included
        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $this->db->group_by('trans_details.prod_id');
        $this->db->group_by('trans_details.pack_id');
        $this->db->group_by('trans_details.prod_type');
        
        $this->db->order_by('sold', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    function get_reports_sold_today()
    {   
        $this->_get_datatables_query_sold_today();

        $this->db->select('trans_details.prod_id as prod_id, trans_details.pack_id as pack_id, trans_details.prod_type as prod_type, SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $today = date('Y-m-d');
        $date_from = $today . ' 00:00:00'; // get date today to filter
        $date_to = $today . ' 23:59:59';

        $this->db->where('trans_details.prod_type !=', 2); // no package-product included
        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $this->db->group_by('trans_details.prod_id');
        $this->db->group_by('trans_details.pack_id');
        $this->db->group_by('trans_details.prod_type');
        
        $this->db->order_by('sold', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    function get_sales_by_cat($cat_id)
    {   
        $this->db->select('SUM(trans_details.total) as sales');

        $this->db->from($this->table);
         
        $this->db->join('products', 'products.prod_id = trans_details.prod_id');
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('products.cat_id', $cat_id);

        $query = $this->db->get();

        $row = $query->row();

        return $row->sales + 0;
    }

    function get_sales_pack()
    {   
        $this->db->select('SUM(trans_details.total) as sales');

        $this->db->from($this->table);
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('trans_details.pack_id !=', 0);

        $query = $this->db->get();

        $row = $query->row();

        return $row->sales + 0;
    }

    function get_sold_by_cat($cat_id)
    {   
        $this->db->select('SUM(trans_details.qty) as sold');

        $this->db->from($this->table);
         
        $this->db->join('products', 'products.prod_id = trans_details.prod_id');
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('products.cat_id', $cat_id);
        $this->db->where('trans_details.prod_type', 0);

        $query = $this->db->get();

        $row = $query->row();

        return $row->sold + 0;
    }

    function get_sold_pack()
    {   
        $this->db->select('SUM(trans_details.qty) as sold');

        $this->db->from($this->table);
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('trans_details.pack_id !=', 0);

        $query = $this->db->get();

        $row = $query->row();

        return $row->sold + 0;
    }

    function get_api_datatables($trans_id) // api function in getting data list
    {        
        $this->db->from($this->table);

        $this->db->where('trans_id',$trans_id); // if data is part of the object by ID

        $query = $this->db->get();
        return $query->result();
    }

    // get both id and names
    function get_trans_detail_items($trans_id)
    {
        $this->db->from($this->table);
        $this->db->where('trans_id',$trans_id);

        $query = $this->db->get();

        return $query->result();
    }

    function get_trans_gross($trans_id)
    {
        $this->db->select('SUM(total) as gross');
        $this->db->from($this->table);
        $this->db->where('trans_id',$trans_id);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->gross;
    }

    function get_total_menu_sales($prod_type)
    {
        $this->db->select('SUM(total) as sales');
        $this->db->from($this->table);
        $this->db->where('prod_type',$prod_type);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->sales;
    }

    function get_total_menu_sales_annual($prod_type, $year)
    {
        $this->db->select('SUM(total) as sales');
        $this->db->from($this->table);
        $this->db->where('prod_type',$prod_type);

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->sales;
    }

    function get_total_menu_sales_monthly($prod_type, $year, $month)
    {
        $this->db->select('SUM(total) as sales');
        $this->db->from($this->table);
        $this->db->where('prod_type',$prod_type);

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->sales;
    }

    function get_total_menu_sales_custom($prod_type, $date_from, $date_to)
    {
        $this->db->select('SUM(total) as sales');
        $this->db->from($this->table);
        $this->db->where('prod_type',$prod_type);

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->sales;
    }

    function get_total_prod_sales($prod_id)
    {
        $this->db->select('SUM(total) as sales');
        $this->db->from($this->table);
        
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('prod_id',$prod_id);
        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('trans_details.prod_type', 0);
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->sales;
    }

    function get_total_pack_sales($pack_id)
    {
        $this->db->select('SUM(total) as sales');
        $this->db->from($this->table);
        
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('pack_id',$pack_id);
        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        
        $query = $this->db->get();

        $row = $query->row();

        return $row->sales;
    }

    // get trans_details of a transaction then copy to trans_details_refund table
    // function copy_to_trans_details_refund($trans_id)
    // {
    //     $query = $this->db->query("insert into trans_details_refund (trans_id, prod_id, pack_id, prod_type, price, qty, total, part_of) select trans_id, prod_id, pack_id, prod_type, price, qty, total, part_of from trans_details where trans_id = " . $trans_id . " and (trans_id, prod_id, pack_id) NOT IN (select trans_id, prod_id, pack_id from trans_details_refund);");
    // }

    // check if the parent data has children in FK
    // function check_if_found($trans_id)
    // {      
    //     $this->db->from($this->table);
    //     $this->db->where('trans_id',$trans_id);

    //     $query = $this->db->get();

    //     return $query;
    // }
 
    function count_filtered($trans_id)
    {
        $this->_get_datatables_query();
        $this->db->where('trans_id',$trans_id);

        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($trans_id)
    {
        $this->db->from($this->table);
        $this->db->where('trans_id',$trans_id);

        return $this->db->count_all_results();
    }

    function count_filtered_sold_today()
    {
        $this->_get_datatables_query_sold_today();

        $this->db->select('trans_details.prod_id as prod_id, trans_details.pack_id as pack_id, trans_details.prod_type as prod_type, SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $date_from = date("Y-m-d") . ' 00:00:00'; // get date today to filter
        $date_to = date("Y-m-d") . ' 23:59:59';

        $this->db->where('trans_details.prod_type !=', 2); // no package-product included
        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $this->db->group_by('trans_details.prod_id');
        $this->db->group_by('trans_details.pack_id');
        $this->db->group_by('trans_details.prod_type');

        $this->db->order_by('sold', 'DESC');

        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_sold_today() // count all kinds of product/packages
    {
        $this->db->from($this->table);

        $this->db->select('trans_details.prod_id as prod_id, trans_details.pack_id as pack_id, trans_details.prod_type as prod_type, SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $date_from = date("Y-m-d") . ' 00:00:00'; // get date today to filter
        $date_to = date("Y-m-d") . ' 23:59:59';

        $this->db->where('trans_details.prod_type !=', 2); // no package-product included
        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $this->db->group_by('trans_details.prod_id');
        $this->db->group_by('trans_details.pack_id');
        $this->db->group_by('trans_details.prod_type');

        $this->db->order_by('sold', 'DESC');

        return $this->db->count_all_results();
    }

    public function count_all_sold_today_by_prod_type($prod_type) // count all times qty of product/packages
    {
        $this->db->from($this->table);

        $this->db->select('SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $date_from = date("Y-m-d") . ' 00:00:00'; // get date today to filter
        $date_to = date("Y-m-d") . ' 23:59:59';

        $this->db->where('trans_details.prod_type', $prod_type); // no package-product included
        $this->db->where('transactions.status', 'CLEARED'); // transaction status should be cleared (paid by customer already)
        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $query = $this->db->get();

        $row = $query->row();
        return $row->sold; 
    }

    public function count_all_sold_status_by_prod_type($prod_type, $status) // count all times qty of product/packages
    {
        $this->db->from($this->table);

        $this->db->select('SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('trans_details.prod_type', $prod_type); // no package-product included
        
        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('transactions.status', $status);
        }

        $query = $this->db->get();

        $row = $query->row();
        return $row->sold; 
    }

    public function count_all_sold_status_by_prod_type_annual($prod_type, $status, $year) // count all times qty of product/packages
    {
        $this->db->from($this->table);

        $this->db->select('SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('trans_details.prod_type', $prod_type); // no package-product included
        
        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('transactions.status', $status);
        }

        $date_from = $year . '-' . '01' . '-01 00:00:00';
        $date_to = $year . '-' . '12' . '-31 23:59:59';

        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $query = $this->db->get();

        $row = $query->row();
        return $row->sold; 
    }

    public function count_all_sold_status_by_prod_type_monthly($prod_type, $status, $year, $month) // count all times qty of product/packages
    {
        $this->db->from($this->table);

        $this->db->select('SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('trans_details.prod_type', $prod_type); // no package-product included
        
        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('transactions.status', $status);
        }

        $date_from = $year . '-' . $month . '-01 00:00:00';
        $date_to = $year . '-' . $month . '-31 23:59:59';

        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $query = $this->db->get();

        $row = $query->row();
        return $row->sold; 
    }

    public function count_all_sold_status_by_prod_type_custom($prod_type, $status, $date_from, $date_to) // count all times qty of product/packages
    {
        $this->db->from($this->table);

        $this->db->select('SUM(trans_details.qty) as sold');
         
        $this->db->join('transactions', 'transactions.trans_id = trans_details.trans_id');

        $this->db->where('trans_details.prod_type', $prod_type); // no package-product included
        
        if ($status != 'ALL') //  if transaction status is not set to 'ALL'
        {
            $this->db->where('transactions.status', $status);
        }

        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';

        $this->db->where('transactions.datetime >=', $date_from);
        $this->db->where('transactions.datetime <=', $date_to);

        $query = $this->db->get();

        $row = $query->row();
        return $row->sold; 
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

    public function delete_by_id_prod($trans_id, $prod_id)
    {
        $this->db->where('trans_id', $trans_id);
        $this->db->where('prod_id', $prod_id);
        $this->db->where('prod_type', 0); // prod_type is individual product
        $this->db->delete($this->table);
    }

    public function delete_by_id_pack($trans_id, $pack_id)
    {
        $this->db->where('trans_id', $trans_id);
        $this->db->where('pack_id', $pack_id);
        $this->db->where('prod_type', 1); // prod_type is package
        $this->db->delete($this->table);

        // delete all products that are part of the package
        $this->db->where('trans_id', $trans_id);
        $this->db->where('part_of', $pack_id);
        $this->db->where('prod_type', 2); // prod_type is product package
        $this->db->delete($this->table);        
    }

    public function delete_by_id_trans($trans_id)
    {
        $this->db->where('trans_id', $trans_id);
        $this->db->delete($this->table);
    }
}