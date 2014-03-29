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
class Insert extends CI_Controller {
    
    public $em;
            function __construct() {
        parent::__construct();
        //$this->load->library('doctrine');
        $this->em = $this->doctrine->em;
        //$this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
    }
    public function index()
    {                
       $this->load->view('PharmInsert/PharmInsert_view');
    }
    public function  save(){
        
        $ph =new Entity\CoordonneeGPS;
        $ph->setLattitude(time());
        $ph->setLongitude(time());
        $this->em->persist($ph);
        $this->em->flush();
        echo("kkkkkkkkkkkk");
        
    }               
    public function  show(){
        $co = new Entity\CoordonneeGPS();
        
        $co = $this->em->find("Entity\CoordonneeGPS" ,3);
        var_dump($cord);

 

        
    }
}


 