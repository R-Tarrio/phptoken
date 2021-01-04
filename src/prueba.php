<?php 
	require_once '../vendor/autoload.php';
	use siranta\phptoken;


	// $json = [
	// 	"init" => time(),
	// 	"exp" => time() + 60*10,
	// 	"data" => [
	// 		"id" => 26139565
	// 	]
	// ];

	// $key = "rdjtycsf";
	// $tt = new phptoken($json, $key);

	// echo $tt->encode();

	$token = new phptoken("7b22696e6974223a313630393731373530342c22657870223a313630393731373536342c2264617461223a7b226964223a32363133393536357d7d.503163a6077861ba05bf9da525da73fa", "rdjtycsf");
	echo $token->decode();
	// $token->addBlock();


?>