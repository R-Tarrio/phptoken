<?php
namespace siranta;
use \Exception;

class phptokenExceptionBlock extends Exception {
    function errorMessage($arg = null)
    {
        return "Token exists on blacklist";
    }
}
	
?>