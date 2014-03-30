<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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
    
    public function index(){
        $this->pharmacie();
    }
            
    function pharmacie() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("pharmacie");
        $crud->set_theme('datatables');
        $crud->set_primary_key("id");        
        $crud->set_subject('Pharmacie');
        $crud->set_relation("adresse_id", "adresse", "{numero} {rue} {cite}");        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    
    function adresse() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("adresse");
        $crud->set_theme('datatables');
        $crud->set_primary_key("id");        
        $crud->set_subject('Adresse');
        $crud->set_relation("localite_id", "localite", "{nom} ({CodePostal})");        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
   
    function localite() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("localite");
        $crud->set_primary_key("id");        
        $crud->set_subject('Localite');        
        $crud->set_relation("gouvernerat_id", "gouvernorat", "nom");
        $crud->display_as("gouvernerat_id", "Gouvernerat");
        $crud->display_as("coordonnegps_id", "CoordonneGPS");
        $crud->set_relation("coordonnegps_id", "coordonneegps", "({lattitude} ,{longitude})") ;
        
        //$crud->set_theme('datatables');
        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    
    function gouvernorat() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("gouvernorat");
        //$crud->set_theme('datatables');
        $crud->set_primary_key("id");        
        $crud->set_subject('Gouvernorat');        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    function garde() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("garde");
        //$crud->set_theme('datatables');
        $crud->set_primary_key("id");        
        $crud->set_subject('Gardes');
        $crud->display_as("pharmacie_id","Pharmacie");
        $crud->set_relation("pharmacie_id", "pharmacie", "{nom}");        
        $crud->required_fields("date","pharmacie_id");
        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    
    
    

    function _example_output($output = null) {
        
        $this->load->view('PharmInsert/crudview', $output);
    }
    
    public function gardes($pharmacie_id = null){
        $cord = new Entity\Pharmacie();
        $cord = $this->em->find('Entity\Pharmacie',1);
        if ($cord){
        $gardes = $cord->getGardes();
        foreach ($gardes as $g){            
            echo '<br>';
            echo $g->getDate()->format('Y m d ') ."  ==> ".$g->getPharmacie()->getNom();
            echo '<br>';
            }          
        }
        
    }

    public function  addCoordonneeGPS (){
        
        $local =new Entity\CoordonneeGPS;
        $local->setLattitude(time());
        $local->setLongitude(time());
        $this->em->persist($local);
        $this->em->flush();
        echo("CoordonneeGPS saved ");
        
    }               
    
}


 
