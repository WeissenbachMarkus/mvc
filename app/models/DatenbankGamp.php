<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author weiss
 */
class DatenbankGamp
{

    public static function connect()
    {
        $servername = "192.168.159.128";
        $username = "gamp_db_user";
        $password = "gamp_db_user";
        $dbname = "gamp_dp";

        $db = new mysqli($servername, $username, $password, $dbname);


        if ($db->connect_error)
        {

            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";

        return $db;
    }

    public static function getAllModuls()
    {
        $db = self::connect();
        $sql = "SELECT * from tbl_modul;";
        $result = mysqli_query($db, $sql);
        $string = '';


        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {

                foreach ($row as $key => $value)
                {
                    $string .= '' . $key . ': ' . $value . '<br>';
                }
            }
            mysqli_close($db);
            return $string;
        } else
        {
            return null;
        }
    }

    public static function getModulNamen()
    {
        $db = self::connect();
        $sql = "SELECT m_name from tbl_modul;";
        $result = mysqli_query($db, $sql);
        $string = '';

        if (mysqli_num_rows($result) > 0)
        {
            mysqli_close($db);

            while ($row = mysqli_fetch_assoc($result))
            {

                foreach ($row as $key => $value)
                {
                    $string .= $key . ': ' . $value . '<br>';
                }
            }
            return $string;
        } else
        {
            return null;
        }
    }

    static function register()
    {

        session_start();
        $conn = DatenbankGamp::connect();

        $usernickname = filter_var($_POST['Nickname'], FILTER_DEFAULT);
        $userpassword = filter_var($_POST['Passwort'], FILTER_DEFAULT);
        $userpassword2 = filter_var($_POST['Passwort2'], FILTER_DEFAULT);

        if ($userpassword != $userpassword2)
        {
            header('Location: stimmtNichtUeberein');
            exit();
        }

/*
        $stmt = $conn->prepare("INSERT INTO tbl_user (u_name,u_password) VALUES (?,?)");
        $stmt->bind_param("ss", $usernickname, hash('sha256', $userpassword));
        echo $userpassword;

        $stmt->execute();

        if (!$stmt->error)
        {
            $_SESSION['erfolg'] = 1;
            header('Location: http://localhost/GampAufgabe3/index.php');
            echo 'Succsess';
        } else
        {
            if (preg_match('/Duplicate/', $stmt->error))
            {
                header('Location: http://localhost/GampAufgabe3/index.php?register=1&duplikat=1');
            }
            die("Errorrrrrr: " . $stmt->error . $userpassword);
        }

        $stmt->close();
        $conn->close();
        exit();*/
    }

}
