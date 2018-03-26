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
 * Class Mdl_Products
 */
class Mdl_Products extends Response_Model
{
    public $table = 'ip_products';
    public $primary_key = 'ip_products.product_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_families.family_name, ip_products.product_name');
    }

    public function default_join()
    {
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $this->db->join('ip_units', 'ip_units.unit_id = ip_products.unit_id', 'left');
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');
    }

    public function by_product($match)
    {
        $this->db->group_start();
        $this->db->like('ip_products.product_sku', $match);
        $this->db->or_like('ip_products.product_name', $match);
        $this->db->or_like('ip_products.product_description', $match);
        $this->db->group_end();
    }

    public function by_family($match)
    {
        $this->db->where('ip_products.family_id', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'product_sku' => array(
                'field' => 'product_sku',
                'label' => trans('product_sku'),
                'rules' => ''
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => trans('product_name'),
                'rules' => 'required'
            ),
            'product_description' => array(
                'field' => 'product_description',
                'label' => trans('product_description'),
                'rules' => ''
            ),
            'product_price' => array(
                'field' => 'product_price',
                'label' => trans('product_price'),
                'rules' => 'required'
            ),
            'purchase_price' => array(
                'field' => 'purchase_price',
                'label' => trans('purchase_price'),
                'rules' => ''
            ),
            'provider_name' => array(
                'field' => 'provider_name',
                'label' => trans('provider_name'),
                'rules' => ''
            ),
            'family_id' => array(
                'field' => 'family_id',
                'label' => trans('family'),
                'rules' => 'numeric'
            ),
            'unit_id' => array(
                'field' => 'unit_id',
                'label' => trans('unit'),
                'rules' => 'numeric'
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => trans('tax_rate'),
                'rules' => 'numeric'
            ),
            // Sumex
            'product_tariff' => array(
                'field' => 'product_tariff',
                'label' => trans('product_tariff'),
                'rules' => ''
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['product_price'] = (empty($db_array['product_price']) ? null : standardize_amount($db_array['product_price']));
        $db_array['purchase_price'] = (empty($db_array['purchase_price']) ? null : standardize_amount($db_array['purchase_price']));
        $db_array['family_id'] = (empty($db_array['family_id']) ? null : $db_array['family_id']);
        $db_array['unit_id'] = (empty($db_array['unit_id']) ? null : $db_array['unit_id']);
        $db_array['tax_rate_id'] = (empty($db_array['tax_rate_id']) ? null : $db_array['tax_rate_id']);

        return $db_array;
    }

        /**
     * Performs validation on submitted form. By default, looks for method in
     * child model called validation_rules, but can be forced to run validation
     * on any method in child model which returns array of validation rules.
     *
     * @param null|string $validation_rules
     *
     * @return mixed
     */
    public function run_specific_validation($data)
    {

        
       $validation_rules = $this->default_validation_rules;

        $values = array_values($data);
        $i = 0;
        foreach (array_keys($data) as $key) {
            $this->form_values[$key] = $values[$i];
            $i++;
        }

        return $this->form_values;

        
        
        // if (method_exists($this, $validation_rules)) {
        //     $this->validation_rules = $validation_rules;

            
        //     $this->load->library('form_validation');

        //     $this->form_validation->set_rules($this->$validation_rules());

        //     $run = $this->form_validation->run();

        //     $this->validation_errors = validation_errors();
    

        //     return $run;
        // }
    }

    
    /**
     * Returns an array based on $_POST input matching the ruleset used to
     * validate the form submission.
     *
     * @return array
     */
    public function to_db_array($data)
    {
        $db_array = [];

        if($data != null){
            $values = array_values($data);
            $i = 0;

            foreach (array_keys($data ) as $key ) {
                $db_array[$key] = $values[$i];
                $i++;
            }
            return $db_array;
        }

       
    }

}
