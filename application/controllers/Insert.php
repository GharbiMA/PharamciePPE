<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Insert
 *
 * @author MedAmineGharbi
 */
class Insert extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
    }
    public function index()
    {
       $this->load->view('PharmInsert/PharmInsert_view');
    }
}
