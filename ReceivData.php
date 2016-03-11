<?php

namespace aciden\receivData;

use aciden\receivData\FtpUpload;
use aciden\receivData\FileHandler;

class ReceivData extends \yii\base\Component
{
    public $ftpPasv = true;

    private $_uploadFilePath = '';
    private $_file;
    private $_loadFile;
    private $_data = [];

    
    public function init($uploadFilePath, $fileName, $arcName = null)
    {
        parent::init();
        
        $this->_loadFile = $arcName ? $arcName : $fileName;
        $this->_uploadFilePath = $uploadFilePath;
    }

    public function uploadFtp($host, $login, $pas, $ftpPath)
    {
        $fileUpload = new FtpUpload($host, $login, $pas, $this->ftpPasv);
        $fileUpload->upload($this->_uploadFilePath, $ftpPath, $this->_loadFile);
        
    }
    
    public function fetch(array $assoc = [])
    {
        $data = new FileHandler($this->_uploadFilePath . '/' . $this->_loadFile);
    }

    public function setData($data)
    {
        $this->_data = $data;
    }
}
