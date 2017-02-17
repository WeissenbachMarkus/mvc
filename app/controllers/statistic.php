<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of statistic
 *
 * @author weiss
 */
class statistic extends Controller
{

    protected function sectionInhalt()
    {
          print_r($_SESSION['data']);
       $this->view(null,'statistic/oneUser',$_SESSION['data']);
      
    }

    public function auswerten($nickname)
    {
        $result = $this->getModel('alexandertechnik')->statisticGetUser($nickname);
        $this->setData($result[0]);
        header('Location: http://localhost/mvc/public/statistic');
    }

}
