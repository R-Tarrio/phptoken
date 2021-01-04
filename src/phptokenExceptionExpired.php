<?php
namespace siranta;
use \Exception;

class phptokenExceptionExpired extends Exception {
    function errorMessage($arg = null)
    {
        return "Token expired";
    }
}
	
?>