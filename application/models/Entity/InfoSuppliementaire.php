<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InfoSuppliementaire
 *
 * @author MedAmineGharbi
 */
class InfoSupplimentaire extends CI_Model {
    //put your code here
    var $specilite;
    var $information;
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
}
