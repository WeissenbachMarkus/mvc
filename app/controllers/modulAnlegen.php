<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of moduleAnlegen
 *
 * @author weiss
 */
class modulAnlegen extends Controller
{

    protected function sectionInhalt()
    {
        $this->view(null, 'modulAnlegen/modulAnlegenFormular', $data);
    }

    protected function script()
    {
        parent::script();
        $this->setScript('name');
    }

    protected function css()
    {
        parent::css();
         $this->setCss();
    }

}
