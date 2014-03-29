<?php
/**
 * Description of Pharmacie
 *
 * @author MedAmineGharbi
 */
namespace Entity;

/**
 * @Entity
 * 
 */

class Pharmacie   {
    
    
    /**
     * @Id
     * @Column(type="integer", unique=true, nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    private $id ;
    /**
     *
     * @Column(type="string", length=32, nullable=false) 
     */    
    private $nom;
    /**
     *
     * @Column(type="string", length=32, nullable=false) 
     */    
    private $tel;
    /**
     *
     * @Column(type="string", length=10, nullable=false) 
     */    
    private $type;
    
    /**
     *
     * @OneToOne(targetEntity="CoordonneeGPS")
     */
    private $coordonneegps;
    
    /**
     * 
     * @OneToOne(targetEntity="InfoSupplimentaire" ,mappedBy="owner" )
     */
    private  $infosuppliementaire;
    
    /**
     * @OneToOne(targetEntity="Adresse",mappedBy="pharmacie")
     */
    private $adresse;
    
    /**
     *
     * @OneToMany(targetEntity="Garde", mappedBy="pharmacie")
     */
    private $gardes;
            
    
    function __construct() {
         
      
    }
    
}
