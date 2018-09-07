<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PO_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PO/PO_model','po');
    }

    public function index()						
    {
        if($this->session->userdata('administrator') == '0')
        {
            redirect('error500');
        }

        $this->load->helper('url');							

        $data['title'] = '<i class="fa fa-cart-plus"></i> Purchase Oders';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('po/po_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->po->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $po) {
            $no++;
            $row = array();
            $row[] = 'PO' . $po->po_id;
            $row[] = '<b>' . $po->supplier_name . '</b>';
            $row[] = $po->username;
            
            $row[] = $po->date;

            $row[] = $po->status;
            $row[] = $po->encoded;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_po('."'".$po->po_id."'".')" disabled><i class="fa fa-eye"></i> </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->po->count_all(),
                        "recordsFiltered" => $this->po->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($po_id)
    {
        $data = $this->po->get_by_id($po_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'supplier_id' => $this->input->post('supplier_id'),
                'user_id' => $this->input->post('user_id'),
                'date' => $this->input->post('date'),
                'status' => $this->input->post('status'),
            );
        $insert = $this->po->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'supplier_id' => $this->input->post('supplier_id'),
                'user_id' => $this->input->post('user_id'),
                'date' => $this->input->post('date'),
                'status' => $this->input->post('status'),
            );
        $this->po->update(array('po_id' => $this->input->post('po_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a po
    // public function ajax_delete($po_id)
    // {
    //     $data = array(
    //             'removed' => 1
    //         );
    //     $this->po->update(array('po_id' => $po_id), $data);
    //     echo json_encode(array("status" => TRUE));
    // }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('supplier_id') == '')
        {
            $data['inputerror'][] = 'supplier_id';
            $data['error_string'][] = 'Purchase order supplier is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('date') == '')
        {
            $data['inputerror'][] = 'date';
            $data['error_string'][] = 'Date is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }



    // ================================================ API GET REQUEST METHOD ============================================


    public function ajax_api_list()
    {
        $list = $this->po->get_api_datatables();
        $data = array();
        
        foreach ($list as $po) {

            $row = array();
            $row['po_id'] = $po->po_id;
            $row['supplier_id'] = $po->supplier_id;
            $row['supplier_name'] = $po->supplier_name;
            $row['user_id'] = $po->user_id;
            $row['username'] = $po->username;
            
            $row['date'] = $po->date;
            $row['status'] = $po->status;

            $row['encoded'] = $po->encoded;

            $data[] = $row;
        }
    
        //output to json format
        echo json_encode($data);
    }


    // ================================================ API POST REQUEST METHOD ============================================
 }