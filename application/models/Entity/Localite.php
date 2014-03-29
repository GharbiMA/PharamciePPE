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
    private $gouvernerat;    
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
}
