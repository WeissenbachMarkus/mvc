<?php

/**
 * Description of moduleAnlegen
 *
 * @author weiss
 */
class modulAnlegen extends Controller
{

    protected function sectionInhalt()
    {
        $this->view(null, 'modulAnlegen/modulAnlegenFormular');
    }

    protected function script()
    {
        parent::script();
        $this->setScript('dragNdrop');
         echo '<script type="text/javascript" src="../app/ckeditor/ckeditor.js"></script>';
    }

    protected function css()
    {
        parent::css();
        $this->setCss();
    }

    public function sichereInhalt()
    {
        $this->setData($_POST['modulIDs']);
    }

    public function anfrage($name)
    {
        if ($result = $this->getModel('alexandertechnik')->modulAnlegenGetNames($name))
            echo false;
        else
            echo true;
    }

}
