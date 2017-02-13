<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bildhochladen
 *
 * @author markus
 */
class bildhochladen extends Controller
{

    public function sectionInhalt()
    {
        $this->view($this, '/bildhochladen/FormularBildHochladen');
    }

    public function verarbeitung($target)
    {
        $target_dir = "../app/models/pictures/".$target."/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"]))
        {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

            if ($check !== false)
            {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else
            {
                $this->setFehler('File is not an image.');
                $uploadOk = 0;
            }
        }
        
        // Check if file already exists
        if (file_exists($target_file))
        {
           $this->setFehler('Sorry, file already exists.');
            $uploadOk = 0;
        }
        
        // Check file size
        print_r($_FILES["fileToUpload"]);
        if ($_FILES["fileToUpload"]["size"] > 1000000)
        {
            $this->setFehler('Sorry, your file is too large.');
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
        {
           $this->setFehler('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            $this->setFehler('Sorry, your file was not uploaded.');
            header('Location: http://localhost/mvc/public/bildhochladen');
            // if everything is ok, try to upload file
        } else
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
            {
                $this->linkHochladen($target_file);
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded to: " . $target_dir;
            } else
            {
                $this->setFehler('Sorry, there was an error uploading your file.');
            }
        }
    }

    /**
     * Verwendet Model um Pfad zum Bild in die Datenbank zu schreiben
     * @param type $bildverzeichnis : Pfad
     */
    private function linkHochladen($bildverzeichnis)
    {
        header('Location: http://localhost/mvc/public/bildHochgeladen');
    }

}
