<?php

define("SQL_SERVER", "127.0.0.1");
define("SQL_DATABASE", "lolbin");
define("SQL_USERNAME", "<username>");
define("SQL_PASSWORD", "<password>");

if (!isset($_COOKIE["token"])) {
	$token = sha1(time() + $_SERVER["REMOTE_ADDR"]);
	setcookie("token", $token, time() + (3600 * 24 * 365 * 5));
	$_COOKIE["token"] = $token;
}

if ($_POST["input"]) {
	if (strlen($_POST["input"]) > 65535) {
		echo "wat. that's huge";
		die();
	} else {
		try {
			$key = bin2hex(openssl_random_pseudo_bytes(16));
			$encrypted = cryptoJsAesEncrypt($key, $_POST["input"]);

			$id = bin2hex(openssl_random_pseudo_bytes(5));
			$conn = new PDO("mysql:host=".SQL_SERVER.";dbname=".SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD);
			$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("INSERT INTO pastes VALUES (:id, :paste, :token)");
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":paste", $encrypted);
			$stmt->bindParam(":token", $_COOKIE["token"]);
			$stmt->execute();

			header("Location: p" . $id . '#' . $key);
			die();
		} catch (PDOException $e) {
			echo '500!!!! WAAAAT!!!!!';
			die();
		}
	}
}

// http://stackoverflow.com/questions/24337317/encrypt-with-php-decrypt-with-javascript-cryptojs
function cryptoJsAesEncrypt($passphrase, $value){
    $salt = openssl_random_pseudo_bytes(8);
    $salted = '';
    $dx = '';
    while (strlen($salted) < 48) {
        $dx = md5($dx.$passphrase.$salt, true);
        $salted .= $dx;
    }
    $key = substr($salted, 0, 32);
    $iv  = substr($salted, 32,16);
    $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
    $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
    return json_encode($data);
}

?>

<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/><meta name="language" content="EN"><meta name="keywords" content="code, codebase, snippet, snippets, codebottle, paste, pastebin, function, class, search"><title>LOLBIN</title><style>body{padding: 0 5%;color: white;background: #222;text-align: center;font-family: Consolas, monospace;}h1{font-size: 5em;}#input{min-height: 480px;width: 100%;text-align: left;padding: 16px;border-radius: 4px;resize: vertical;outline: none;box-sizing: border-box;}#paste-btn{padding: 12px 16px;background: #3F51B5;font-weight: 900;border: none;border-radius: 4px;color: white;}</style></head><body><h1 id="title">LOLBIN</h1><form action="" method="post"><textarea id="input" placeholder="PUT UR STUFF HERE LOL!!!!" name="input"></textarea><br/><br/><input type="submit" value="PASTE !!!!!" id="paste-btn"></form></body></html>