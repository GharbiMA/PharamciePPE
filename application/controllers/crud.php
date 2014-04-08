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
        $crud->set_theme('twitter-bootstrap');
        $crud->set_crud_url_path(site_url('crud/pharmacie'));
        //$crud->set_primary_key("id");        
        $crud->set_subject('Pharmacie');
        $crud->set_relation("adresse_id", "adresses", "{numero} {rue} {cite}");
        $crud->set_relation("coordonneegps_id", "coordonneegps", "({lattitude},{longitude})");        
        $crud->display_as("coordonneegps_id" , "Coordonnee GPS ");        
        $crud->display_as("adresse_id" , "Adresse");        
        $crud->display_as("tel" , "Telephone");               
        $crud->columns('nom','tel','type','adresse_id');
        $crud->add_fields('nom','tel','type','gouvernorat_id','localite_id', 'map');
        //$crud->display_as("gouvernorat_id", "Gouvernorat");                        
        $listegov = array();        
        $repo = $this->em->getRepository('Entity\Gouvernorat')->findAll();
        foreach ($repo as $key => $value) {            
            $listegov[$value->getId()] = $value->getNom();            
        }         
        $crud->field_type('gouvernorat_id','dropdown',$listegov ); 
        $listegov = array();        
        $repo = $this->em->getRepository('Entity\Localite')->findAll();        
        foreach ($repo as $key => $value) {            
            $listegov[$value->getId()] = $value->getNom()." (".$value->getCodePostal()." )";            
        }         
        $crud->field_type('localite_id','dropdown',$listegov );
        
        
        $crud->callback_add_field("map", array($this,'map_callback') );
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    function map_callback()
    {           
        
             return '';
    }
    
    
    function adresse() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("adresses");
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
        $crud->set_theme("twitter-bootstrap");
        $crud->set_table("localite");        
        $crud->set_primary_key("id");        
        $crud->set_subject('Localite'); 
        $crud->set_relation("gouvernorat_id", "gouvernorat", "nom");
        $crud->display_as("gouvernorat_id", "Gouvernorat");
        $crud->display_as("coordonnegps_id", "CoordonneGPS");        
        $crud->set_relation("coordonnegps_id", "coordonneegps", "({lattitude} ,{longitude})") ;
        $crud->columns('nom','CodePostal', "gouvernorat_id");
                
        
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
    /*  
create view newpharmacie as 
SELECT `pharmacie`.`nom` AS `nompharmacie` ,`pharmacie`.`tel`,`pharmacie`.`type`,`pharmacie`.`id`,`adresses`.`numero`,`adresses`.`rue`,`adresses`.`cite`,`localite`.`nom` AS `nomlocalite`,`localite`.`CodePostal`,`gouvernorat`.`nom` AS `nomgouvernorat`,`infosupplimentaire`.`specialite`,`infosupplimentaire`.`information`,`coordonneegps`.`longitude`,`coordonneegps`.`lattitude` FROM pharmacie
LEFT JOIN `pharmacie_db`.`adresses` ON `pharmacie`.`adresse_id` = `adresses`.`id` 
LEFT JOIN `pharmacie_db`.`coordonneegps` ON `pharmacie`.`coordonneegps_id` = `coordonneegps`.`id` 
LEFT JOIN `pharmacie_db`.`infosupplimentaire` ON `pharmacie`.`infosuppliementaire_id` = `infosupplimentaire`.`id` 
LEFT JOIN `pharmacie_db`.`localite` ON `adresses`.`localite_id` = `localite`.`id` 
LEFT JOIN `pharmacie_db`.`gouvernorat` ON `localite`.`gouvernorat_id` = `gouvernorat`.`id` 
     * 
     */
    
    function viewpharmacie() {
        
        $crud = new Grocery_CRUD();
        $crud->set_table("newpharmacie");
        //$crud->set_theme('twitter-bootstrap');
        $crud->set_crud_url_path(site_url("crud/viewpharmacie"));
        $crud->set_subject("Pharmacie");        
        $crud->set_primary_key("id");                        
        $crud->columns('nompharmacie', 'tel','type','specialite','rue','nomlocalite','CodePostal','nomgouvernorat');
        $crud->display_as("nompharmacie", "Pharmacien");
        $crud->display_as("nomlocalite", "Localite");
        $crud->display_as("nomgouvernorat", "Gouvernorat");
        $crud->display_as("tel" , "Telephone");
        //$crud->required_fields('nompharmacie', 'tel','type','specialite','information','numero','rue' ,'cite','nomlocalite');
        $crud->fields('id','nompharmacie', 'tel','type','specialite','information','numero','rue' ,'cite','nomlocalite');
        $crud->field_type('type','enum',array ('jour' => 'Jour' , 'nuit' => 'Nuit'));
        $crud->field_type('numero','integer');        
        $crud->field_type('tel','integer');        
        $crud->field_type('id', 'hidden');
        $list_localite = array();                
        $repo = $this->em->getRepository('Entity\Localite')->findAll();                
        foreach ($repo as $key => $value) {                        
            $list_localite[$value->getId()] = $value->getNom()." - ".$value->getGouvernorat()->getNom()." - ( ".$value->getCodePostal()." )";            
        }         
        $crud->field_type('nomlocalite','dropdown',$list_localite );        
        $crud->callback_insert(array($this,'newpharmacie_insert_callback')); 
        $crud->callback_update(array($this,'newpharmacie_update_callback')); 
        $crud->callback_delete(array($this,'newpharmacie_delete_callback'));
        $output = $crud->render();                                    
        $this->_example_output($output);        
    }
    
    function newpharmacie_insert_callback($post_array){
          
        $nPharmacie  = new Entity\Pharmacie();
        $nPharmacie->setNom($post_array['nompharmacie']);
        $nPharmacie->setTel($post_array['tel']);
        $nPharmacie->setType($post_array['type']);
        $nAdresse = new Entity\Adresse();
        $nAdresse->setCite($post_array['cite']);
        $nAdresse->setNumero($post_array['numero']);        
        $nAdresse->setRue($post_array['rue']);          
        $localite = $this->em->find('Entity\Localite',$post_array['nomlocalite']);
        $nAdresse->setLocalite($localite);
        $nPharmacie->setAdresse($nAdresse);
        $ninfo = new Entity\InfoSupplimentaire();
        $ninfo->setSpecialite($post_array['specialite']);
        $ninfo->setInformation( $post_array['information'] ) ;
        $nPharmacie->setInfosuppliementaire($ninfo);
        $this->em->persist($ninfo);
        $this->em->persist($nAdresse);        
        $this->em->persist($nPharmacie);            
        return $this->em->flush();
        
    }
    function newpharmacie_update_callback($post_array){
          
        $nPharmacie  = $this->em->find('Entity\Pharmacie',$post_array['id']);
        $nPharmacie->setNom($post_array['nompharmacie']);
        $nPharmacie->setTel($post_array['tel']);
        $nPharmacie->setType($post_array['type']);
        $nAdresse = $nPharmacie->getAdresse();
        $nAdresse->setCite($post_array['cite']);
        $nAdresse->setNumero($post_array['numero']);        
        $nAdresse->setRue($post_array['rue']);          
        $localite = $this->em->find('Entity\Localite',$post_array['nomlocalite']);
        $nAdresse->setLocalite($localite);
        $nPharmacie->setAdresse($nAdresse);        
        $ninfo = $nPharmacie->getInfosuppliementaire();
        $ninfo->setSpecialite($post_array['specialite']);
        $ninfo->setInformation( $post_array['information'] ) ;
        $nPharmacie->setInfosuppliementaire($ninfo);
        $this->em->persist($ninfo);
        $this->em->persist($nAdresse);        
        $this->em->persist($nPharmacie);                
        return $this->em->flush();
        
    }
    function newpharmacie_delete_callback($primary){
                               
        $nPharmacie  = new Entity\Pharmacie();
        $nPharmacie= $this->em->find('Entity\Pharmacie',$primary);
        foreach ($nPharmacie->getGardes() as $grd) {
            $this->em->remove($grd);
        }
        $ninfo = $nPharmacie->getInfosuppliementaire();
        $nAdresse = $nPharmacie->getAdresse();
        $this->em->remove($ninfo);
        $this->em->remove($nAdresse);        
        $this->em->remove($nPharmacie);        
        return $this->em->flush();
        
    }
    
    

    public function  addCoordonneeGPS (){
        
//        $local =new Entity\CoordonneeGPS;
//        $local->setLattitude(time());
//        $local->setLongitude(time());
//        $this->em->persist($local);
//        $this->em->flush();
       $primary = 8 ; 
        $nPharmacie  = new Entity\Pharmacie();
        $nPharmacie= $this->em->find('Entity\Pharmacie',$primary);
        foreach ($nPharmacie->getGardes() as $grd) {
            $this->em->remove($grd);
        }
        
       

        
        
    }               

}


 
