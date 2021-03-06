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
                        
        $output = $crud->render();                                    
        $this->_example_output($output);
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
        $crud->columns( 'nom','CodePostal', "gouvernorat_id");                                    
        $crud->fields('nom','CodePostal',"gouvernorat_id" , 'lattitude' , 'longitude','map' ,'id'); 
        $crud->field_type('id', 'hidden');                
        $crud->callback_field('map',array($this,'map_callback'));
        $crud->callback_field('lattitude',array($this,'lattitude_callback'));
        $crud->callback_field('longitude',array($this,'longitude_callback'));        
        $crud->callback_insert(array($this,'localite_insert_callback')); 
        $crud->callback_update(array($this,'localite_update_callback')); 
        $crud->unset_delete();
        $output = $crud->render();                                    
        $this->_example_output($output);
    }
    
     function localite_insert_callback($post_array){                  
        $localite = new Entity\Localite();        
        $localite->setNom($post_array['nom']);
        $localite->setCodePostal($post_array['CodePostal']);
        $localite->setGouvernorat($this->em->find('Entity\Gouvernorat' ,$post_array['gouvernorat_id']));
        $nCordonGPS = new Entity\CoordonneeGPS();
        $nCordonGPS->setLattitude($post_array['lattitude']);
        $nCordonGPS->setLongitude($post_array['longitude']);
        $localite->setCoordonnegps($nCordonGPS);                
        $this->em->persist($nCordonGPS);
        $this->em->persist($localite);            
        return $this->em->flush();
        
    }
    function localite_update_callback($post_array){
          
        $localite =$this->em->find('Entity\Localite',$post_array['id']);
        $localite->setNom($post_array['nom']);
        $localite->setCodePostal($post_array['CodePostal']);
        $localite->setGouvernorat($this->em->find('Entity\Gouvernorat' ,$post_array['gouvernorat_id']));
        $nCordonGPS = $localite->getCoordonnegps();
        $nCordonGPS->setLattitude($post_array['lattitude']);
        $nCordonGPS->setLongitude($post_array['longitude']);
        $localite->setCoordonnegps($nCordonGPS);                
        $this->em->persist($nCordonGPS);
        $this->em->persist($localite);            
        return $this->em->flush();
        
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
        $crud->set_theme('twitter-bootstrap');
        $crud->set_crud_url_path(site_url("crud/viewpharmacie"));
        $crud->set_subject("Pharmacie");        
        $crud->set_primary_key("id");                        
        $crud->columns('nompharmacie', 'tel','type','specialite','rue','nomlocalite','CodePostal','nomgouvernorat');
        $crud->display_as("nompharmacie", "Pharmacien");
        $crud->display_as("nomlocalite", "Localite");
        $crud->display_as("nomgouvernorat", "Gouvernorat");
        $crud->display_as("tel" , "Telephone");
        //$crud->required_fields('nompharmacie', 'tel','type','specialite','information','numero','rue' ,'cite','nomlocalite');
        $crud->fields('id','nompharmacie', 'tel','type','specialite','information','numero','rue' ,'cite','nomlocalite', 'lattitude' , 'longitude','map');
        $crud->field_type('type','enum',array ('jour' => 'Jour' , 'nuit' => 'Nuit'));
        $crud->field_type('numero','integer');        
        $crud->field_type('tel','integer');        
        $crud->field_type('id', 'hidden');                
        
        $crud->callback_field('map',array($this,'map_callback'));
        $crud->callback_field('lattitude',  array($this,'lattitude_callback'));
        $crud->callback_field('longitude' ,  array($this,'longitude_callback'));        
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
        $nCordonGPS = new Entity\CoordonneeGPS();
        $nCordonGPS->setLattitude($post_array['lattitude']);
        $nCordonGPS->setLongitude($post_array['longitude']);
        $nPharmacie->setCoordonneegps($nCordonGPS);
        $this->em->persist($ninfo);
        $this->em->persist($nAdresse);        
        $this->em->persist($nCordonGPS);
        $this->em->persist($nPharmacie);            
        return $this->em->flush();
        
    }
    function newpharmacie_update_callback($post_array){
          
        //$nPharmacie = new Entity\Pharmacie();
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
        $nCordonGPS = $nPharmacie->getCoordonneegps();
        $nCordonGPS->setLattitude($post_array['lattitude']);
        $nCordonGPS->setLongitude($post_array['longitude']);        
        $this->em->persist($ninfo);
        $this->em->persist($nAdresse);        
        $this->em->persist($nCordonGPS);
        $this->em->persist($nPharmacie);                
        return $this->em->flush();
        
    }
    function newpharmacie_delete_callback($primary){
                               
        //$nPharmacie  = new Entity\Pharmacie();
        $nPharmacie= $this->em->find('Entity\Pharmacie',$primary);
        foreach ($nPharmacie->getGardes() as $grd) {
            $this->em->remove($grd);
        }
        $ninfo = $nPharmacie->getInfosuppliementaire();
        $nAdresse = $nPharmacie->getAdresse();
        $nCordonGPS = $nPharmacie->getCoordonneegps();
        $this->em->remove($ninfo);
        $this->em->remove($nAdresse);        
        $this->em->remove($nCordonGPS);
        $this->em->remove($nPharmacie);                
        return $this->em->flush();
        
    }
    
    function map_callback($value = '' , $primary_key = null) {
        
        $output =  '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
            <script type="text/javascript" >
            var mapInstance;
            var marker;
            var defaultlocation;
            $(document).ready(function () {
            var latlng = new google.maps.LatLng('.
            ($primary_key == NULL? '34.29837094826205, 9.743591286242008' : '$("#lattitude").val(),$("#longitude").val()' ).');
            var mapOptions = {
                    zoom: '. ($primary_key == NULL? '7' : '17' ) .',
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DEFAULT
                    }
            };
            mapInstance = new google.maps.Map(document.getElementById("map"), mapOptions);
            google.maps.event.addListener(mapInstance, \'click\' , function (event) {
                if (marker) {
                    marker.setPosition(event.latLng);
                } else {
                    marker = new google.maps.Marker({
                                            position: event.latLng,
                                            map: mapInstance
                                            });
                        }
                $("#lattitude").val(marker.getPosition().lat());
                $("#longitude").val(marker.getPosition().lng());           
            });
            defaultlocation = new google.maps.LatLng($("#lattitude").val(),$("#longitude").val() );
            marker = new google.maps.Marker({
                                position: defaultlocation,
                                map: mapInstance });   
                                });          
            </script>
            <div id="map" style="width: 500px; height: 700px; border: 1px #000 solid;"></div>';
        return $output;
    }
        function lattitude_callback($value = '', $primary_key = null) {

                return '<input type="text" name="lattitude" value="'.$value.'"  id="lattitude" />';
        }
        function longitude_callback($value = '', $primary_key = null) {

                return '<input type="text" name="longitude" value="'.$value.'"  id="longitude" />';
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


 
