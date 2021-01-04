# phptoken

## Installation
```
composer require siranta/phptoken
```

### Create token
```
	use siranta\phptoken;
	
	$json = [
		"init" => time(),
		"exp" => time() + 60*10, // Token validity time
		"data" => [
			"id" => 12345678
		]
	];

	$key = "25d55ad283aa400af464c76d713c07ad"; // Private key
	$tt = new phptoken($json, $key);

	echo $tt->encode();
```

### decrypt token
```
$token = new phptoken(TOKEN, KEY);
echo $token->decode();
```