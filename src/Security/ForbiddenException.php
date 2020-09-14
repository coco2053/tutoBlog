<?php


namespace App\Security;


class ForbiddenException extends \Exception
{
    public function check()
    {
        if(!isset($_SESSION['auth'])) {
            throw new ForbiddenException();
        }
    }
}