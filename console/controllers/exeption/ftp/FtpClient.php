<?php

namespace console\controllers\exeption\ftp;

//use console\controllers\exeption\ftp\FtpExeptions;

class FtpClient {

    private $host = '185.67.1.128';
    private $login = 'portal-api';
    private $pass = '5W2d8Q1o';
    private $ftp;

    public $errors = '';
    public $errorsCode = 0;

    const FORMAT_TEXT = 0;
    const FORMAT_JSON = 1;
    const FORMAT_RAW = 2;



    public function __construct($host = null, $login = null, $password = null)
    {
        if(!is_null($host)) $this->host = $host;
        if(!is_null($login)) $this->login = $login;
        if(!is_null($password)) $this->pass = $password;

        $this->ftp = self::setFtp();
    }

    private function setFtp(){

        try {
            if (!$ftp = ftp_connect($this->host, 21, 1200)) throw new FtpExeptions(FtpErrors::getErrorMessage(FtpErrors::INVALID_HOST), FtpErrors::INVALID_HOST);
            try {
                if (!ftp_login($ftp, $this->login, $this->pass))  throw new FtpExeptions(FtpErrors::getErrorMessage(FtpErrors::INVALID_AUTH), FtpErrors::INVALID_AUTH);
                ftp_pasv($ftp, true);
                return $ftp;
            } catch (FtpExeptions $e){
                throw $e;
            }
        } catch (FtpExeptions $e) {
            $this->errors = 'Ошибка соедениения: '.$e->getMessage();
            $this->errorsCode = $e->getCode();
            return false;
        }

    }

    public function saveFile($path, $data, $format = self::FORMAT_JSON){
        try {
            $temp = tmpfile();
            fwrite($temp, $data);
            fseek($temp, 0);

            if($ftp = ftp_fput($this->ftp, $path, $temp, $format, 0)){
                return $data;
            } else {
                throw new FtpExeptions(FtpErrors::getErrorMessage(FtpErrors::INVALID_FILE), FtpErrors::INVALID_FILE);
            }



        } catch (FtpExeptions $e){
            $this->errors = 'Ошибка передачи файла: '.$e->getMessage();
            $this->errorsCode = $e->getCode();
            return false;
        } finally {
            fclose($temp);
        }
    }


    public function openFile($path, $format = self::FORMAT_TEXT){

        $temp = tmpfile();

        try {

            if(ftp_fget($this->ftp, $temp, $path, FTP_BINARY, 0)){

                fseek($temp, 0);

                if($format == self::FORMAT_JSON){
                    $data = mb_ereg_replace('["]{1}[\s]{1}|[\s]{1}["]{1}', '"', stream_get_contents($temp));
                    $data = json_decode($data);
                } else {
                    $data = stream_get_contents($temp);
                }

                fclose($temp); // происходит удаление файла

                return $data;
            } else {
                throw new FtpExeptions(FtpErrors::getErrorMessage(FtpErrors::INVALID_FILE), FtpErrors::INVALID_FILE);
            }
        } catch (FtpExeptions $e){
            $this->errors = 'Ошибка передачи файла: '.$e->getMessage();
            $this->errorsCode = $e->getCode();
            return false;
        }


    }
}