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
class Adresse extends CI_Model {
    //put your code here
    var $num;
    var $rue;
    var $cite;
    function __construct() {
        parent::__construct();
    }
}
