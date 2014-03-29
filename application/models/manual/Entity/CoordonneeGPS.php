<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoordonneeGPS
 *
 * @author MedAmineGharbi
 */

namespace Entity;

/**
 * @Entity
 */


class CoordonneeGPS   {
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
    private $longitude;    
    /**
     *
     * @Column(type="string", length=32, nullable=false) 
     */    
    private $lattitude;
    
                            
    function __construct() {
         
    }
}
