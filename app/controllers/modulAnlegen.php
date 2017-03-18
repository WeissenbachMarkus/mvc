<?php

/**
 * Description of moduleAnlegen
 *
 * @author weiss
 */
class modulAnlegen extends Controller
{

    const TEXT = 'text', IMG = 'imgTAG', AUD = 'audTAG', TEMPDIR = '../app/models/data/tempModul', DATADIR = '../app/models/data';

    protected function sectionInhalt()
    {
        $this->view(null, 'modulAnlegen/modulAnlegenFormular');
    }

    protected function script()
    {
        $this->setScript('dragNdrop');
        echo '<script type="text/javascript" src="../app/ckeditor/ckeditor.js"></script>';
    }

    protected function css()
    {
        parent::css();
        $this->setCss();
    }

    public function anfrage($name)
    {
        if ($result = $this->getModel('alexandertechnik')->modulAnlegenGetNames($name))
            echo false;
        else
            echo true;
    }

    public function deleteContent()
    {
        echo unlink($this->trimSrc($_POST['src']));
    }

    private function trimSrc($src)
    {
        if (strlen($src) == 0)
            return;
        $path = '../' . substr($src, strpos($src, 'app'));
        return urldecode(str_replace('<br \>', '', $path));
    }

    public function upload()
    {
        if (!is_dir(self::DATADIR))
            mkdir(self::DATADIR);

        $target_dir = self::TEMPDIR . '/';

        if (!is_dir($target_dir))
        {
            mkdir($target_dir);
        }

        $target_file = $target_dir . basename($_FILES["upload"]["name"]);

        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file))
            echo $target_file;
        else
        {
            foreach ($_FILES['upload'] as $key => $value)
            {
                echo 'Key: ' . $key . ' value: ' . $value;
            }
        }
    }

    private function filterKeyGetType($key)
    {
        $constants = [self::AUD, self::IMG, self::TEXT];

        foreach ($constants as $value)
        {
            if (strpos($key, $value) !== false)
                return $value;
        }
    }

    public function submit()
    {
        //Getting all Data send by POST
        $wysiwygContent = explode(',', $_POST['wysiwygContent']);
        $title = $_POST['title'];

        //get Sources for produced textfiles
        $textSources = $this->writeContentToFile($wysiwygContent);

        //Wysiwyg Textsources have to be add here because the client didn't
        //create them
        $keysAndSrcs = $this->getAssocArrayOfFilesAndSrc(explode(',', $_POST['positions']), $textSources);


        $model = $this->getModel('alexandertechnik');

        if (strlen($title) > 0)
        {
            $success = $model->modulAnlegenSetModul($title);
            echo $success;

            if ($success)
            {
                $position = 0;
                foreach ($keysAndSrcs as $key => $src)
                {
                    $type = $this->filterKeyGetType($key);

                    $newSrc = $this->moveFile($title, $src);

                    switch ($type)
                    {
                        case self::TEXT:
                            echo $model->modulAnlegenSetModulInhalt($position, $title, $newSrc, null, null, null);
                            break;

                        case self::IMG:
                            echo $model->modulAnlegenSetModulInhalt($position, $title, null, $newSrc, null, null);
                            break;

                        case self::AUD:
                            echo $model->modulAnlegenSetModulInhalt($position, $title, null, null, $newSrc, null);
                            break;
                    }

                    $position++;
                }

                $this->removeFilesInTempDir();
            }
        } else
            echo 'Kein Name wurde eingegeben!';
    }

    private function getAssocArrayOfFilesAndSrc($SRCsAndTypes, $textSRCs)
    {
        $assocSRCsAndKeys = [];

        $count = 1;
        foreach ($SRCsAndTypes as $key => $typeOrSrc)
        {
            if ($key % 2 == 0)
                $type = $typeOrSrc;
            else
            {
                if ($type === self::TEXT)
                {
                    $firstTextSrc = reset($textSRCs);
                    $assocSRCsAndKeys[$type . $count] = $firstTextSrc;
                    unset($textSRCs[array_search($firstTextSrc, $textSRCs)]);
                } else
                    $assocSRCsAndKeys[$type . $count] = $this->trimSrc($typeOrSrc);
                $count++;
            }
        }

        return $assocSRCsAndKeys;
    }

    private function writeContentToFile($wysiwygContent)
    {
        $sources = [];

        foreach ($wysiwygContent as $key => $content)
        {
            $targetDirectoryAndNameOfFile = self::TEMPDIR . '\text' . $key;
            $text = fopen($targetDirectoryAndNameOfFile, 'w');
            $sources[$key] = $targetDirectoryAndNameOfFile;
            fwrite($text, $content);
            fclose($text);
        }

        return $sources;
    }

    /**
     * 
     * @param String $titleOfDirectory
     * @param String $srcOfFile
     * @return string newSrc
     */
    public function moveFile($titleOfDirectory, $srcOfFile)
    {

        //get name of File
        $arraySrc = explode('/', $srcOfFile);
        $nameOfFile = $arraySrc[count($arraySrc) - 1];

        //create dir, or not
        $targetDir = self::DATADIR . '/' . $titleOfDirectory;
        if (!is_dir($targetDir))
            mkdir($targetDir);

        //move file
        $target = self::DATADIR . '/' . $titleOfDirectory . '/' . $nameOfFile;
        rename($srcOfFile, $target);

        return $target;
    }

    private function removeFilesInTempDir()
    {
        $contentDir = scandir(self::TEMPDIR);
        foreach ($contentDir as $key => $value)
        {
            if ($key > 1)
                unlink(self::TEMPDIR . '/' . $value);
        }
    }

}
