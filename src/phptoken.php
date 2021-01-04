<?php 
namespace siranta;
ini_set('error_reporting', 0);
use Jajo\JSONDB;
use siranta\phptokenException;
use siranta\phptokenExceptionBlock;
use siranta\phptokenExceptionExpired;
/**
 * 
 */
class phptoken
{
	

	public $json = false;
	public $key = false;
	public $json_db = null;

	function __construct($json = false, $key = false)
	{
		$this->json_db = new JSONDB( __DIR__ );
		$this->json = $json;
		$this->key = $key;
		if(!$this->json && is_array($this->json)){
			throw new Exception("invalid json", 1);
		}

		if(!$this->key){
			throw new Exception("A key was not set", 1);
		}
	}

	public function encode()
	{
		$json = json_encode($this->json);
		$json_cod = bin2hex($json);
		$adc = md5($json_cod.$this->json["init"].$this->key);
		return $json_cod.".".$adc;
	}
	public function decode()
	{

		try {
			$this->valido();

			$json_a = explode(".", $this->json)[0];
			$md5 = explode(".", $this->json)[1];
			$json = hex2bin($json_a);
			$json_arr = json_decode($json, true);
			if( md5( bin2hex($json).$json_arr["init"].$this->key ) == $md5 ){
				return $json;
			}else{
				return "Invalid";
			}

		} catch (phptokenException $e) {
			return $e->errorMessage();
		} catch (phptokenExceptionBlock $e) {
			return $e->errorMessage();
		} catch (phptokenExceptionExpired $e) {
			return $e->errorMessage();
		}

	}

	public function valido()
	{

		if($this->getListBlock()){
			throw new phptokenExceptionBlock("ExistsOnBlacklist");
		}

		$json_a = explode(".", $this->json)[0];
		$md5 = explode(".", $this->json)[1];
		$json = hex2bin($json_a);
		$json_arr = json_decode($json, true);
		if( md5( bin2hex($json).$json_arr["init"].$this->key ) == $md5 ){
			if($json_arr["exp"] < time()){
				throw new phptokenExceptionExpired("TokenExpired");
			}
			return true;
		}else{
			throw new phptokenException("InvalidToken");
		}
	}

	public function getListBlock($token = null)
	{
		if(!$token){
			$token = $this->json;
		}

		$blockList = $this->json_db->select('*')
		->from( 'tokenListBlock.json' )
		->where( [ 'token' => $token ] )
		->get();

		if(count($blockList) > 0){
			return true;
		}else{
			return false;
		}


	}

	public function addBlock($token = null)
	{
		if(!$token){
			$token = $this->json;
		}

		$blockList = $this->json_db->select('*')
		->from( 'tokenListBlock.json' )
		->where( [ 'token' => $token ] )
		->get();

		if(count($blockList) > 0){
			return true;
		}else{
			$this->json_db->insert( 'tokenListBlock.json', 
				[ 
					'token' => $token, 
					'time' => time()
				]
			);
			return true;
		}
	}

}