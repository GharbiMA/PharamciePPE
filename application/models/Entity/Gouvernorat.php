<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gouvernorat
 *
 * @author MedAmineGharbi
 */
namespace Entity;

/**
 * @Entity
 */

class Gouvernorat   {
    
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
     * @OneToMany(targetEntity="Localite", mappedBy="gouvernerat", orphanRemoval=false)
     */
    private $localites;
    
    function __construct() {
         
    
    }
}
