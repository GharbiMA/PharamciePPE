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
    private $num;
    private $rue;
    private $cite;
    function __construct() {
        parent::__construct();
    }
}
