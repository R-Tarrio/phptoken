<?php
namespace siranta;
use \Exception;

class phptokenException extends Exception {
    public function errorMessage() {
    	$errorMsg = "";
    	switch ($this->getMessage()) {
    		case 'ExistsOnBlacklist':
                return "Token exists on blacklist";
    		break;
    		case 'InvalidToken':
    			return "Invalid Token";
			break;
			case 'TokenExpired':
				return "Token expired";
			break;
    		default:
                return "Invalid Token";
    		break;
    	}
        return $errorMsg;
    }
}
	
?>