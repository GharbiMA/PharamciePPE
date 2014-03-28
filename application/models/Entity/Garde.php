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


class Garde extends CI_Model {
    
    
    
    private $date;
    
    /**
     * @ManyToOne(targetEntity="Pharmacie", inversedBy="gardes")
     **/
    private $pharmacie;
    
    
    function __construct() {
        parent::__construct();
    }
}
