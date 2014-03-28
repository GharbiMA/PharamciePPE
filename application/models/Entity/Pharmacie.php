<?php
/**
 * Description of Pharmacie
 *
 * @author MedAmineGharbi
 */
namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="pharmacies") 
 */


class Pharmacie extends CI_Model {
    
    
    /**
     * @Id
     * @Column(type="integer", length=32, unique=true, nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id ;
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
     * @OneToOne(targetEntity="InfoSuppliementaire")
     */
    private  $infosuppliementaire;
    
    /**
     * @OneToOne(targetEntity="Adresse")
     */
    private $adresse;
    
    /**
     *
     * @OneToMany(targetEntity="Garde", mappedBy="pharmacie", cascade={"persist"}, orphanRemoval=true)
     */
    private $gardes;
            
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
}
