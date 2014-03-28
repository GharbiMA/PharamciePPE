<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of localite
 *
 * @author MedAmineGharbi
 */
class localite extends CI_Model {
    //put your code here
    private $nom;
    private $CodePostal;
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
}
