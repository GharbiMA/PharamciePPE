<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Garde
 *
 * @author MedAmineGharbi
 */

namespace Entity;
/**
 *  @Entity
 * 
 */

class Garde   {
    
    /**
     * @Id
     * @Column(type="integer", length=32, unique=true, nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    private  $id;
    /**     
     * @Column(type="date",  unique=false, nullable=false)
     */
    private $date;
    
    /**
     * @ManyToOne(targetEntity="Pharmacie", inversedBy="gardes")
     **/
    private $pharmacie;
    
    
    function __construct() {
         
    }
}
