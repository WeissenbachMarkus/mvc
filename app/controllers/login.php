<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author weiss
 */
class login extends Controller
{

    public function index()
    {
        $this->view('home/index', 'login');
    }

    public function sectionInhalt()
    {
        require_once '../app/views/login/loginformular.php';
    }

}
