<?php

class gestiongardes extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    public function index (){
        $crud = new Grocery_CRUD();
        $crud->set_table("garde");
        $crud->set_theme('datatables');
        $crud->set_primary_key("id");        
        $crud->set_subject('Gardes');
        $crud->display_as("pharmacie_id","Pharmacie");
        $crud->set_relation("pharmacie_id", "pharmacie", "{nom} ");        
        $crud->required_fields("date","pharmacie_id");
        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    
    
    

    function _example_output($output = null) {
        
        $this->load->view('PharmInsert/crudview', $output);
    }
    
}



