<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of l 
 *
 * @author MedAmineGharbi
 */
class l  extends CI_Model {
    //put your code here
    var $nom;
    var $CodePostal;
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
}
