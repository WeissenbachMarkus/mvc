<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author markus
 */
class test extends Controller
{
    protected function sectionInhalt()
    {
        echo 'fu';
        $this->view(null,'test/test');
    }


}
