<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PO_temp_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PO_temp/PO_temp_model','po_temp');
    }

    public function index()						
    {
        if($this->session->userdata('administrator') == '0')
        {
            redirect('error500');
        }

        $this->load->helper('url');							

        $data['title'] = '<i class="fa fa-archive"></i> Create Purchase Order';					
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('po_temp/po_temp_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');

    }
   
    public function ajax_list()
    {
        $list = $this->po_temp->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $po_temp) {
            $no++;
            $row = array();
            $row[] = $po_temp->num;
            $row[] = 'I' . $po_temp->item_id;
            $row[] = '<b>' . $po_temp->item_name . '</b>';

            $row[] = $po_temp->unit_qty;
            $row[] = $po_temp->unit_name;

            $row[] = $po_temp->pcs_qty;

            //add html for action
            $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_po_temp('."'".$po_temp->num."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
                      <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_item('."'".$po_temp->num."'".', '."'".$po_temp->name."'".')"><i class="fa fa-trash"></i></a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->po_temp->count_all(),
                        "recordsFiltered" => $this->po_temp->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($num)
    {
        $data = $this->po_temp->get_by_id($num);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'item_id' => $this->input->post('item_id'),
                'unit_id' => $this->input->post('unit_id'),
                'unit_qty' => $this->input->post('unit_qty'),
                'pcs_qty' => $this->input->post('pcs_qty')
            );
        $insert = $this->po_temp->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'item_id' => $this->input->post('item_id'),
                'unit_id' => $this->input->post('unit_id'),
                'unit_qty' => $this->input->post('unit_qty'),
                'pcs_qty' => $this->input->post('pcs_qty')
            );
        $this->po_temp->update(array('num' => $this->input->post('num')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a record
    public function ajax_delete($num)
    {
        $this->po_temp->delete_by_id($num);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('item_id') == '')
        {
            $data['inputerror'][] = 'item_id';
            $data['error_string'][] = 'item is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('unit_id') == '')
        {
            $data['inputerror'][] = 'unit_id';
            $data['error_string'][] = 'Unit to use is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('unit_qty') == '')
        {
            $data['inputerror'][] = 'unit_qty';
            $data['error_string'][] = 'Unit quantity is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

 }