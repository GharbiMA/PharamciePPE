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
        $crud->set_relation("coordonneegps_id", "coordonneegps", "({lattitude},{longitude})");
        $crud->display_as("coordonneegps_id" , "Coordonnee GPS ");        
        $crud->display_as("tel" , "Telephone");
        $crud->add_fields('nom','tel','type','gouvernorat','localite');
        $crud->display_as("gouvernorat", "Gouvernorat");
        
                
        $listegov = array();        
        $repo = $this->em->getRepository('Entity\Gouvernorat')->findAll();
        foreach ($repo as $key => $value) {            
            $listegov[$value->getId()] = $value->getNom();            
        }         
        $crud->field_type('gouvernorat','dropdown',$listegov ); 
        $listegov = array();        
        $repo = $this->em->getRepository('Entity\Localite')->findAll();        
        foreach ($repo as $key => $value) {            
            $listegov[] = $value->getNom()." (".$value->getCodePostal()." )";            
        }         
        $crud->field_type('localite','dropdown',$listegov );
        
        
        //$crud->callback_add_field("coordonneegps_id", array($this,'adresse_callback') );
        
        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    function adresse_callback()
    {        
            $this->load->helper('form');
            $options = array('' => 'Please select', 'Beige' => 'Beige' , 'Black' => 'Black', 'Blue' => 'Blue');
            return form_dropdown('adresse', $options,'',"id='color'");
             //return '<input type="text" maxlength="50" value="" name="adresse" style="width:462px">';
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
        $crud->set_relation("gouvernorat_id", "gouvernorat", "nom");
        $crud->display_as("gouvernorat_id", "Gouvernorat");
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
        //$crud->set_primary_key("id");        
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
        $pharm = new Entity\Pharmacie();
        $pharm = $this->em->find('Entity\Pharmacie',1);
        if ($pharm){
        $gardes = $pharm->getGardes();
        foreach ($gardes as $g){            
            echo '<br>';
            echo $g->getDate()->format('Y m d ') ."  ==> ".$pharm->getNom();
            echo '<br>';
            }          
        }
        echo "<br>****************<br>";
        
        
        
    }
    /* CREATE VIEW newpharmacie 
AS
SELECT `pharmacie`.`id`,`pharmacie`.`nom` AS nompharmacie, `pharmacie`.`tel`,`pharmacie`.`type`,`infosupplimentaire`.`specialite`,`infosupplimentaire`.`information`,`coordonneegps`.`longitude`,
`coordonneegps`.`lattitude`,`adresse`.`numero`,`adresse`.`rue`,`localite`.`nom` AS nomlocalite ,`localite`.`CodePostal`,
`gouvernorat`.`nom` AS nomgouvernorat  FROM pharmacie
LEFT JOIN `pharmacie_db`.`adresse` ON `pharmacie`.`adresse_id` = `adresse`.`id` 
LEFT JOIN `pharmacie_db`.`coordonneegps` ON `pharmacie`.`coordonneegps_id` = `coordonneegps`.`id` 
LEFT JOIN `pharmacie_db`.`infosupplimentaire` ON `pharmacie`.`id` = `infosupplimentaire`.`owner_id` 
LEFT JOIN `pharmacie_db`.`localite` ON `coordonneegps`.`id` = `localite`.`coordonnegps_id` 
LEFT JOIN `pharmacie_db`.`gouvernorat` ON `localite`.`gouvernerat_id` = `gouvernorat`.`id`; 
     * 
     */
    
    function view() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("newpharmacie");
        $crud->set_theme('datatables');
        $crud->set_primary_key("id");                        
        //$crud->set_crud_url_path(site_url('pharmacie'));
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    
    

    public function  addCoordonneeGPS (){
        
        $local =new Entity\CoordonneeGPS;
        $local->setLattitude(time());
        $local->setLongitude(time());
        $this->em->persist($local);
        $this->em->flush();
        echo("CoordonneeGPS saved ");
        
        
    }               
    /**
     * $seo_results = array();
foreach ($this->db->get('db_projects')->result() as $row) {
    $seo_results[$row->seo] = $row->seo;
} 
$crud->field_type('seo_url', 'dropdown', $seo_results);
     */
}


 
