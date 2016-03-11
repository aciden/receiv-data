<?php

namespace aciden\receivData;

use yii2mod\ftp\FtpClient;
use aciden\receivData\ErrorException;

class FtpUpload
{
    private $_ftpObj;

    public function __construct($host, $login, $pass, $pasv)
    {
        $this->_ftpObj = new FtpClient;
        $this->_ftpObj->connect($host);
        $this->_ftpObj->login($login, $pass);
        $this->_ftpObj->pasv($pasv);
    }
    
    public function upload($uploadFile, $filePath, $file)
    {
        try {
                        
            $f = fopen($uploadFile . '/' . $file, 'w+');
            $this->_ftpObj->fget($f, $filePath . '/' . $file, FTP_BINARY);
            fclose($f);
                        
        } catch (ErrorException $e) {
                       
            
            return false;
        }
    }
}
