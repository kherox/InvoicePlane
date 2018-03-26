<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Products
 */
class Products extends Admin_Controller
{
    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_products');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_products->paginate(site_url('products/index'), $page);
        $products = $this->mdl_products->result();

        $this->layout->set('products', $products);
        $this->layout->buffer('content', 'products/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('products');
        }

        if ($this->mdl_products->run_validation()) {
            // Get the db array
            $db_array = $this->mdl_products->db_array();
            $this->mdl_products->save($id, $db_array);
            redirect('products');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_products->prep_form($id)) {
                show_404();
            }
        }

        $this->load->model('families/mdl_families');
        $this->load->model('units/mdl_units');
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->layout->set(
            array(
                'families' => $this->mdl_families->get()->result(),
                'units' => $this->mdl_units->get()->result(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
            )
        );

        $this->layout->buffer('content', 'products/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_products->delete($id);
        redirect('products');
    }


    public function upload($id = null){

        if ($this->input->post('btn_submit')) {
           

                $config['upload_path']          = 'uploads/';
                $config['allowed_types']        = 'csv';
                $this->load->library('upload', $config);
                 if($this->upload->do_upload('files_content')){
                    $data =  $this->upload->data();
                    $csv = array_map('str_getcsv', file($data["full_path"]));
                    //to remove in header product_id
                    unset($csv[0][0]);
                    //initilisation to skip first iterate
                    $i = 0;
                    array_walk($csv, function(&$a) use ($csv) {
                        //to remove product_id to column
                        unset($a[0]);
                        $a   =  array_combine($csv[0], $a);
                        $res       = $this->mdl_products->run_specific_validation($a);
                        $db_array  = $this->mdl_products->to_db_array($res);
                        $this->mdl_products->save($id, $db_array);                         
                    });

                 }else{
                      $error = array('error' => $this->upload->display_errors());
                      var_dump($error);
                }
                redirect('products');
                
               
                
        }

         $this->layout->buffer('content', 'products/upload');
        $this->layout->render();

    }

}
