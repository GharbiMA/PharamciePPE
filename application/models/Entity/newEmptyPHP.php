<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Localite 
 *
 * @author MedAmineGharbi
 */


namespace Entity;

/**
 * @Entity
 */

class Localite    {
        /**
     * @Id
     * @Column(type="integer", unique=true, nullable=false)
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
     * @Column(type="smallint" ,nullable=false) 
     */    
    private $CodePostal;
    /**
     *
     * @ManyToOne(targetEntity="Gouvernorat", inversedBy="localites")
     */
    private $gouvernerat;    
    /**
     *
     *  @OneToOne(targetEntity="CoordonneeGPS")
     */
    private $coordonnegps;
    
    
    /**
     * @OneToMany(targetEntity="Adresse", mappedBy="localite")
     */
    private $pharmacies;
            
    
    
    function __construct() {
                 
    }
}
