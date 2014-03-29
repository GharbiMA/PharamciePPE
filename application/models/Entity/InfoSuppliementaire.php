<?php


namespace Entity;


/**
 * @Entity
 */
class InfoSupplimentaire   {
    /**
     * @Id
     * @Column(type="integer", unique=true, nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id ;
    /**
     *
     * @Column(type="string", length=40, nullable=true) 
     */        
    private $specialite;    
    /**
     *
     * @Column(type="text", nullable=true) 
     */    
    private $information;
    
    /**
     *
     * @OneToOne(targetEntity="Pharmacie",inversedBy="infosuppliementaire")
     */
    private $owner;
    
    
    function __construct() {
                 
    }
}
