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

    public static function modulObjekthinzufuegen($bildverzeichnis)
    {
        $datenbankverbindung = self::connect();

        $stmt = $datenbankverbindung->prepare("INSERT INTO tbl_mobjekt
                ( mo_reihenfolge, mo_bild, tbl_modul_m_id)
                VALUES  (?,?,?)");
        $tbl_modul_m_id = 1;

        echo $bildverzeichnis;

        $stmt->bind_param("isi", self::reihenfolgeGenerieren($datenbankverbindung, 1), $bildverzeichnis, $tbl_modul_m_id);

        $stmt->execute();

        if ($stmt->error)
            throw new Exception($stmt->error . "iwas nix gut!");
        else
        {
            echo 'super save!';
        }

        $stmt->close();
        $datenbankverbindung->close();
    }

    public static function reihenfolgeGenerieren($datenbankverbindung, $tbl_modul_m_id)
    {
        $vergebeneReihenfolge = self::vergebeneReihenfolgen($datenbankverbindung, $tbl_modul_m_id);



        for ($index = 1; $index <= count($vergebeneReihenfolge); $index++)
        {
            $gefunden = false;
            foreach ($vergebeneReihenfolge as $reihenfolge)
            {
                if ($index == $reihenfolge)
                {
                    $gefunden = true;
                    break;
                }
            }

            if (!$gefunden)
            {
                return $index;
            }
        }

        return count($vergebeneReihenfolge) + 1;
    }

    private static function vergebeneReihenfolgen($datenbankverbindung, $tbl_modul_m_id)
    {
        $sql = "select mo_reihenfolge from tbl_mobjekt where tbl_modul_m_id=" . $tbl_modul_m_id;

        $result = mysqli_query($datenbankverbindung, $sql);

        while ($row = mysqli_fetch_assoc($result))
        {

            foreach ($row as $value)
            {
                $vergebeneReihenfolge[] = $value;
            }
        }


        return $vergebeneReihenfolge;
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
          exit(); */
    }

}
