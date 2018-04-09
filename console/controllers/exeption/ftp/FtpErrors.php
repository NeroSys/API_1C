<?php

namespace console\controllers\exeption\ftp;

class FtpErrors extends \Exception {


    const INVALID_HOST = 1;
    const INVALID_AUTH = 2;
    const INVALID_FILE = 3;

    public static function getErrorMessage($code){
        switch ($code){
            case self::INVALID_HOST:
                return 'Не верный хост или порт';
                break;
            case self::INVALID_AUTH:
                return 'Не верный логин или пароль';
                break;
            case self::INVALID_FILE:
                return 'Загружаемый файл не существует или путь не верен';
                break;
            default;
                return 'Чтото пошло не так';
                break;
        }
    }
}