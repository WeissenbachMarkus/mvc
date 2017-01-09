<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class user extends Controller
{

    protected function sectionInhalt()
    {
        $this->listAllUsers();
    }

    private function listAllUsers()
    {
        if ($userData = $this->getModel('Alexandertechnik')->userListAllUsers())
        {
            echo '<table>';
            echo '<th>Icon</th><th>Nickname</th><th>Email</th>';
            foreach ($userData as $key => $row)
            {
                echo '<tr>';

                $this->view(null, 'user/userRow', $row);

                echo '</tr>';
            }
            echo '</table>';
        } else
            echo 'nei!';
    }

}
