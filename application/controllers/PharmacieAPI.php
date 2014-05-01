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
     *  @return Pharmacie full  details 
     * @param type $argument : the id of the pharmacie 
     */
    public function detail_post($argument){
        $pharmacie = new Entity\Pharmacie();        
//        $ad = new Entity\Adresse();     $ad->getCite()
        $pharmacie=$this->em->find('Entity\Pharmacie', $argument);        
        if ($pharmacie === null) {
            $this->response ( "No Pharmacie found.\n" , 404 ) ;
            exit(1);
        }else {                
        $result= array();                                 
                 $result = array(                     
                     'NomPharmacien' => $pharmacie->getNom(),
                     'Telephone' => $pharmacie->getTel(),
                     'GPS' => array( 'long,lat' => 
                                     $pharmacie->getCoordonneegps()->getLongitude().','
                                    . $pharmacie->getCoordonneegps()->getLattitude() ) ,
                     'type' => $pharmacie->getType(),
                     'adresse' => array ( 'Numero' =>$pharmacie->getAdresse()->getNumero() ,
                                            'Rue' => $pharmacie->getAdresse()->getRue() ,
                                            'Cite' =>$pharmacie->getAdresse()->getCite()                                            
                                        ),
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
    
    
    public function gardes_post($param) {
        $pharmacie = new Entity\Pharmacie();                
        $pharmacie=$this->em->find('Entity\Pharmacie', $param);        
        if ($pharmacie === null) {
            $this->response ( "No Pharmacie found.\n" , 404 ) ;
            exit(1);
        }else {
            $result = array();
            $value =  new Entity\Garde();
            $gardlist = $pharmacie->getGardes();
            foreach ($gardlist as $value) {
                $result[] = $value->getDate();
            }
            $this->response($result);
        }        
    }

}
