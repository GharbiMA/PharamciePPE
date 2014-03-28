<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pharmacie
 *
 * @author MedAmineGharbi
 */
class Pharmacie extends CI_Model {
    //put your code here
    var $nom;
    var $tel;
    var $type;
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
}
