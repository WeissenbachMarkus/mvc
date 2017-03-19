<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schnittstelle
 *
 * @author markus
 */
class schnittstelle extends Controller
{

    public function index()
    {
        $this->view($this, 'schnittstelle/schnittstelleGeneral');
    }

    protected function sectionInhalt()
    {
        
    }

    private function parse($table)
    {
        $result = '[';

        function parseRow($row)
        {
            $position = 0;

            $result = '{';
            foreach ($row as $key => $value)
            {

                if ($position > 0 && $position < count($row))
                    $result.= ',';
                if (strlen($value) == 0)
                    $value = 'null';
                elseif (strpos($value, '../app'))
                    $result.= '"' . $key . '":"' . $value . '"';

                $position++;
            }
            return $result.= '}';
        }

        $position = 0;

        foreach ($table as $value)
        {
            if ($position > 0 && $position < count($table))
                $result.= ',';
            $result.= parseRow($value);

            $position++;
        }

        return $result.= ']';
    }

    public function getAllModuls()
    {

        $result = $this->getModel('alexandertechnik')
                ->schnittstelleGetAllModuls();

        echo $this->parse($result);
    }

    public function getModulContent($modulName)
    {
        $table = $this->getModel('alexandertechnik')
                ->schnittstelleGetModulContent($modulName);

        echo $this->parse($table);
    }

    public function getSpecificContent($modulName, $columnname, $position)
    {
        $table = $this->getModel('alexandertechnik')
                ->schnittstelleGetSpecificModulContent($modulName, $columnname, $position);

        eader("Content-type: text/plain");
        foreach ($table[0] as $key => $value)
        {
            echo base64_encode($value);
        }
    }

}
