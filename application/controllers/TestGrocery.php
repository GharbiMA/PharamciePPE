<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestGrocery
 *
 * @author MedAmineGharbi
 */
class TestGrocery extends CI_Controller{
    //put your code here
    function __construct() {
        parent::__construct();

        $this->load->database();        
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    function pharmacie() {
        $crud = new Grocery_CRUD();
       
        $crud->set_table("pharmacie");
                       
        $output = $crud->render();
        $this->_example_output($output);
    }

    function _example_output($output = null) {
        
        $this->load->view('grocery_view', $output);
    }
}
