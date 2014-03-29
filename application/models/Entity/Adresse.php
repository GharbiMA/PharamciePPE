<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adresse
 *
 * @author MedAmineGharbi
 */
namespace Entity;


/**
 * @Entity
 * 
 */


class Adresse   {
    
    /**
     * @Id
     * @Column(type="integer", unique=true, nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id ;
    /**
     *
     * @Column(type="smallint") 
     */    
    private $num;
    /**
     *
     * @Column(type="string", length=32, nullable=false) 
     */    
    private $rue;
    /**
     *
     * @Column(type="string", length=32, nullable=false) 
     */    
    private $cite;
       
    /**
     *  
     *  @ManyToOne(targetEntity="Localite" , inversedBy="pharmacies")
     */
    private $localite; 
    
    /**
     *
     * @OneToOne(targetEntity="Pharmacie", inversedBy="adresse")
     */
    private $pharmacie;
    
    function __construct() {
         
    }
}
