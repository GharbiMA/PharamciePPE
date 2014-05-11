<?php

require APPPATH . '/libraries/REST_Controller.php';

/*
 * this is tha main controller of the restful API
 * this controller does not load any view for obvious reasons 
 * 
 */

class PharmacieAPI extends REST_Controller {

    public $em;

    public function __construct() {
        parent::__construct();
        $this->load->library('doctrine');
        $this->em = $this->doctrine->em;
        $this->load->database();       
    }
        
    
    /*
     * Those are the default methods called for get/post/put requestes 
     * no logic will be here just bounces parameters and a welcome messages 
     */
        
    public function index_get($argument = null ) {        
        //TODO: Add a help  message that explain usage 
        $this->response($argument);        
    }
    public function index_post($argument = null ){ 
        
        $this->response("post request response ".$argument);
    }
    public function index_put($argument = null){
        $this->response($argument, 200);               
    }
    
    
    public function echo_get($argument){
        // This Method is called when a GET request is sent to Pharmacie/api/echo/argument
            $this->response($argument);
    }    

    /**
     * This method returns a list of pharmacies for a specific localite 
     * 
     */
    public function findpharmaciebyCodeLocalite_post($CodePostallocalite){
        $local = new \Entity\Localite();
        $local =$this->em->getRepository('Entity\Localite')->findOneBy(array( 'CodePostal' => $CodePostallocalite  ));
        if ($local === null) {            
            $this->response ( "No localite found.\n" , 404 ) ;
            exit(1);
            
        }else {
            $result = array ();
           $Adressespharmaciebylocalite = $local->getPharmacies();
           foreach ($Adressespharmaciebylocalite as $value) {
                $result[] = array( 'NomPharmacien' => $value->getPharmacie()->getNom() ,
                                    'telephone' => $value->getPharmacie()->getTel() ,
                                    'GPS' => '('.$value->getPharmacie()->getCoordonneegps()->getLongitude().','.
                                                 $value->getPharmacie()->getCoordonneegps()->getLattitude() .')',
                                );
           }
            $this->response($result , 200);
        }
          
    }
    
    /**
     * This method returns a list of pharmacies for a specific localite by its name 
     * 
     */
    public function findbyNomLocalite_post($Nomlocalite){
        $local = new \Entity\Localite();
        $local =$this->em->getRepository('Entity\Localite')->findOneBy(array( 'nom' => $Nomlocalite) );
        if ($local === null) {            
            $this->response ( "No localite found.\n" , 404 ) ;
            exit(1);            
        }else {
           $result = array ();
           $Adressespharmaciebylocalite = $local->getPharmacies();
           foreach ($Adressespharmaciebylocalite as $value) {
                $result[] = array( 'NomPharmacien' => $value->getPharmacie()->getNom() ,
                                    'telephone' => $value->getPharmacie()->getTel() ,
                                    'GPS' => '('.$value->getPharmacie()->getCoordonneegps()->getLongitude().','.
                                                 $value->getPharmacie()->getCoordonneegps()->getLattitude() .')',
                                );
           }
            $this->response($result , 200);
        }          
    }
    /**
     * This method returns a list of pharmacies for a specific Gouvernorat by its name 
     * 
     */
    public function findbyGouvernorat_post($NomGouvernorat){
        $local = new \Entity\Gouvernorat();
        $local =$this->em->getRepository('Entity\Gouvernorat')->findOneBy(array( 'nom' => $NomGouvernorat) );
        if ($local === null) {            
            $this->response ( "No Gouvernorat found.\n" , 404 ) ;
            exit(1);            
        }else {
           $result = array ();
           $AdressespharmaciebyGov = $local->getLocalites();
           foreach ($AdressespharmaciebyGov  as $Adressespharmaciebylocalite) {                         
                foreach ($Adressespharmaciebylocalite as $value) {
                    $result[$Adressespharmaciebylocalite->getNom] = array( 'NomPharmacien' => $value->getPharmacie()->getNom() ,
                                         'telephone' => $value->getPharmacie()->getTel() ,
                                         'GPS' => '('.$value->getPharmacie()->getCoordonneegps()->getLongitude().','.
                                                      $value->getPharmacie()->getCoordonneegps()->getLattitude() .')',
                                     );
                }
           }
            $this->response($result , 200);
        }          
    }


    /**
     *  @return Pharmacie full  details 
     * @param type $argument : the id of the pharmacie 
     */
    public function detail_post($argument){
        $pharmacie = new Entity\Pharmacie();        
        $pharmacie=$this->em->find('Entity\Pharmacie', $argument);        
        if ($pharmacie === null) {
            $this->response ( "No Pharmacie found.\n" , 404 ) ;
            exit(1);
        }else {                        
                 $result = array(                     
                     'NomPharmacien' => $pharmacie->getNom(),
                     'Telephone' => $pharmacie->getTel(),
                     'GPS' => array( 'long,lat' => $pharmacie->getCoordonneegps()->getLongitude().','. $pharmacie->getCoordonneegps()->getLattitude() ) ,
                     'type' => $pharmacie->getType(),
                     'adresse' => array ( 'Numero' =>$pharmacie->getAdresse()->getNumero() ,
                                            'Rue' => $pharmacie->getAdresse()->getRue() ,
                                            'Cite' =>$pharmacie->getAdresse()->getCite(),
                                            'Localite' => array( "localite" => $pharmacie->getAdresse()->getLocalite()->getNom(),
                                                                 "CodePostal" => $pharmacie->getAdresse()->getLocalite()->getCodePostal()),
                                            'Gouvernorat' => $pharmacie->getAdresse()->getLocalite()->getGouvernorat()->getNom(),
                                        ),
                     'Specielite' => $pharmacie->getInfosuppliementaire()->getSpecialite(),
                     'texte' => $pharmacie->getInfosuppliementaire()->getInformation()
                 );
        $this->response($result);
        }
    }           
    /**
     * This method returns the ids of all pharmacies 
     */
    public function id_get(){
        $pharmacie = new Entity\Pharmacie();                        
        $pharmalist = $this->em->getRepository('Entity\Pharmacie')->findAll();
        $result= array();                                 
        foreach ($pharmalist as $pharmacie) {                
                 $result[$pharmacie->getId()] = $pharmacie->getId();
        }
        $this->response($result);
    }
    
    
    /**
     * This method returns the list of gardes of a specific Pharmacie
     * @param type $param the identifier of pharmacie 
     * @return List of date 
     */
    
    
    public function gardes_post($pharmacie) {
        $pharmacie = new Entity\Pharmacie();                
        $pharmacie=$this->em->find('Entity\Pharmacie', $param);        
        if ($pharmacie === null) {
            $this->response ( "No Pharmacie found.\n" , 404 ) ;
            exit(1);
        }else {
            $result = array();
            $value =  new Entity\Garde();
            $gardlist = $pharmacie->getGardes();
            $now = new DateTime();
            foreach ($gardlist as $value) { 
                if ( intval($now->diff($value->getDate())->format('%R%a')) >= 0 ) {
                    $result [] =$value->getDate();                
                }
            }
            $this->response($result);
        }                
    }
    
    public  function listegouvernerat_get(){        
        $listegov = $this->em->getRepository('Entity\Gouvernorat')->findAll();
        $response=array();
        foreach ($listegov as $gov ){
            $response[$gov->getId()] = $gov->getNom();            
        }
        $this->response($response);
    }
    
    
    public function getlocalitesbygouvernorat_post($idGov){
        $selectedgov = new Entity\Gouvernorat();
        $localite= new Entity\Localite();
        $selectedgov = $this->em->find('Entity\Gouvernorat',$idGov);
        if ($selectedgov === null) {
            $this->response ( "Wrong identifier\n" , 404 ) ;
            exit(1);
        }else {
            $response = array();
            $listelocalite = $selectedgov->getLocalites();
            foreach ( $listelocalite as $localite){
                $response[$localite->getCodePostal()]= $localite->getNom();
            }
            $this->response($response);
        }
    }

}
