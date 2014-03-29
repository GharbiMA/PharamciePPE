<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Insert
 *
 * @author MedAmineGharbi
 */

class crud extends CI_Controller {
    
    public $em;
    function __construct() {
        parent::__construct();
        //$this->load->library('doctrine');
        $this->em = $this->doctrine->em;
        $this->load->database();
        $this->load->library('grocery_CRUD');
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    
    function index() {
        echo 'DDDDDDDDDDDD';
        $crud = new Grocery_CRUD();
        $crud->set_table("pharmacie");
        $crud->set_primary_key("id");
        $crud->set_relation("adresse_id", "adresse", "rue");        
        $output = $crud->render();
        $this->_example_output($output);
    }

    function _example_output($output = null) {
        
        $this->load->view('PharmInsert/example.php', $output);
    }
    
    public function g(){
        $cord = new Entity\CoordonneeGPS();
        $cord = $this->em->find('Entity\CoordonneeGPS',2);
        echo $cord->getLattitude();
        echo 'DDDDDDDDDDDD';
        
        
    }

    public function  add(){
        
        $ph =new Entity\CoordonneeGPS;
        $ph->setLattitude(time());
        $ph->setLongitude(time());
        $this->em->persist($ph);
        $this->em->flush();
        echo("kkkkkkkkkkkk");
        
    }               
    
}


 