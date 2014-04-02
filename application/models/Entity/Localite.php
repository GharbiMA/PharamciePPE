<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Localite 
 *
 * @ORM\author MedAmineGharbi
 */


namespace Entity;
use \Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */

class Localite    {
        /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id ;
    /**
     *
     * @ORM\Column(type="string", length=32, nullable=false) 
     */    
    private $nom;
    /**
     *
     * @ORM\Column(type="smallint" ,nullable=false) 
     */    
    private $CodePostal;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Gouvernorat", inversedBy="localites")
     */
    private $gouvernorat;    
    /**
     *
     *  @ORM\OneToOne(targetEntity="CoordonneeGPS")
     */
    private $coordonnegps;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Adresse", mappedBy="localite")
     */
    private $pharmacies;
            
    
    
    function __construct() {
                 
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Localite
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set CodePostal
     *
     * @param smallint $codePostal
     * @return Localite
     */
    public function setCodePostal($codePostal)
    {
        $this->CodePostal = $codePostal;
        return $this;
    }

    /**
     * Get CodePostal
     *
     * @return smallint 
     */
    public function getCodePostal()
    {
        return $this->CodePostal;
    }

    /**
     * Set gouvernorat
     *
     * @param Entity\Gouvernorat $gouvernorat
     * @return Localite
     */
    public function setGouvernorat(\Entity\Gouvernorat $gouvernorat = null)
    {
        $this->gouvernorat = $gouvernorat;
        return $this;
    }

    /**
     * Get gouvernorat
     *
     * @return Entity\Gouvernorat 
     */
    public function getGouvernorat()
    {
        return $this->gouvernorat;
    }

    /**
     * Set coordonnegps
     *
     * @param Entity\CoordonneeGPS $coordonnegps
     * @return Localite
     */
    public function setCoordonnegps(\Entity\CoordonneeGPS $coordonnegps = null)
    {
        $this->coordonnegps = $coordonnegps;
        return $this;
    }

    /**
     * Get coordonnegps
     *
     * @return Entity\CoordonneeGPS 
     */
    public function getCoordonnegps()
    {
        return $this->coordonnegps;
    }

    /**
     * Add pharmacies
     *
     * @param Entity\Adresse $pharmacies
     * @return Localite
     */
    public function addAdresse(\Entity\Adresse $pharmacies)
    {
        $this->pharmacies[] = $pharmacies;
        return $this;
    }

    /**
     * Get pharmacies
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPharmacies()
    {
        return $this->pharmacies;
    }
}