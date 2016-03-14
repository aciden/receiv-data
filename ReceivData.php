<?php

namespace aciden\receivData;

use aciden\receivData\FtpUpload;
use aciden\receivData\FetchDataFile;

class ReceivData extends \yii\base\Component
{
    public $ftpPasv = true;
    public $clear = true;

    private $_uploadFilePath = '';
    private $_loadFile;
    private $_fetchData;

    public function initialise($fileName, $uploadFilePath = null)
    {        
        $this->_loadFile = $fileName;
        $this->_uploadFilePath = $uploadFilePath ? $uploadFilePath : $this->_uploadFilePath;
    }

    public function uploadFtp($host, $login, $pas, $ftpPath)
    {
        $fileUpload = new FtpUpload($host, $login, $pas, $this->ftpPasv);
        $fileUpload->upload($this->_uploadFilePath, $ftpPath, $this->_loadFile);
        
    }
    
    public function fecthPreload($startLine, $numLoadLine, $separator = null)
    {
        $this->_fetchData = new FetchDataFile($this->_uploadFilePath . '/' . $this->_loadFile, $startLine, $numLoadLine, $separator);
        
        return $this->_fetchData->getData();
    }

    public function fetchRow($startLine = 1, $separator = null)
    {
        $this->_fetchData = new FetchDataFile($this->_uploadFilePath . '/' . $this->_loadFile, $startLine, 20, $separator);
        
        return $this->_fetchData->getData();
    }
    
    public function fetchAssoc(array $assoc, $startLine = 1, $separator = null)
    {
        $this->_fetchData = new FetchDataFile($this->_uploadFilePath . '/' . $this->_loadFile, $startLine, 0, $separator, $assoc);
        
        return $this->_fetchData->getData();
    }
    
    public function __destruct()
    {        
        if ($this->clear && file_exists(__DIR__ . '/' . $this->_uploadFilePath . '/' . $this->_loadFile)) {
            
            unlink(__DIR__ . '/' .$this->_uploadFilePath . '/' . $this->_loadFile);   
        }
    }
}
