<?php

define("SQL_SERVER", "127.0.0.1");
define("SQL_DATABASE", "lolbin");
define("SQL_USERNAME", "<username>");
define("SQL_PASSWORD", "</password>");

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
			$id = bin2hex(openssl_random_pseudo_bytes(4));
			$conn = new PDO("mysql:host=".SQL_SERVER.";dbname=".SQL_DATABASE, SQL_USERNAME, SQL_PASSWORD);
			$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("INSERT INTO pastes VALUES (:id, :paste, :token)");
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":paste", $_POST["input"]);
			$stmt->bindParam(":token", $_COOKIE["token"]);
			$stmt->execute();

			header("Location: p" . $id);
			die();
		} catch (PDOException $e) {
			echo '500!!!! WAAAAT!!!!!';
			die();
		}
	}
}

?>

<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/><meta name="language" content="EN"><meta name="keywords" content="code, codebase, snippet, snippets, codebottle, paste, pastebin, function, class, search"><title>LOLBIN</title><style>body{padding: 0 5%;color: white;background: #222;text-align: center;font-family: Consolas, monospace;}h1{font-size: 5em;}#input{min-height: 480px;width: 100%;text-align: left;padding: 16px;border-radius: 4px;resize: vertical;outline: none;box-sizing: border-box;}#paste-btn{padding: 12px 16px;background: #3F51B5;font-weight: 900;border: none;border-radius: 4px;color: white;}</style></head><body><h1 id="title">LOLBIN</h1><form action="" method="post"><textarea id="input" placeholder="PUT UR STUFF HERE LOL!!!!" name="input"></textarea><br/><br/><input type="submit" value="PASTE !!!!!" id="paste-btn"></form></body></html>