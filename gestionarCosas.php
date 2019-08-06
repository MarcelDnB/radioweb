<?php
function like($conexion,$UID,$SONGNAME) {
	try {
		$stmt=$conexion->prepare('CALL like_song(:USERNAME,:SONGNAME)');
        $stmt->bindParam(':USERNAME',$UID);
        $stmt->bindParam(':SONGNAME',$SONGNAME);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function add($conexion,$SONGNAME) {
	try {
		$stmt=$conexion->prepare('CALL add_song(:SONGNAME)');
        $stmt->bindParam(':SONGNAME',$SONGNAME);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function getMp3StreamTitle($streamingUrl, $interval, $offset = 0, $headers = true)
{    session_start();
	$needle = 'StreamTitle=';
	$ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36';
	$opts = [
			'http' => [
			'method' => 'GET',
			'header' => 'Icy-MetaData: 1',
			'user_agent' => $ua
		]
	];
	if (($headers = get_headers($streamingUrl))) {
		foreach ($headers as $h) {
			if (strpos(strtolower($h), 'icy-metaint') !== false && ($interval = explode(':', $h)[1])) {
				break;
			}
		}
	}
	$context = stream_context_create($opts);
	if ($stream = fopen($streamingUrl, 'r', false, $context)) {
		$buffer = stream_get_contents($stream, $interval, $offset);
		fclose($stream);
		if (strpos($buffer, $needle) !== false) {
            $title = explode($needle, $buffer)[1];
            $aux = substr($title, 0, strpos($title, ';') - 2);
            $aux1 = explode("'", $aux);
            $_SESSION['CANCIONACTUAL'] = $aux1[1];
			return $aux1[1];
		} else {
			return getMp3StreamTitle($streamingUrl, $interval, $offset + $interval, false);
		}
	} else {
		throw new Exception("Unable to open stream [{$streamingUrl}]");
	}
}
function cuentaLikes($conexion,$cancion) {
    try {
		$stmt=$conexion->prepare('SELECT count(*) FROM FAVORITES where SONGNAME=:SONGNAME');
        $stmt->bindParam(':SONGNAME',$cancion);
        $stmt->bindParam(':USERNAME',$USERNAME);
        $stmt->execute();
        $fila = $stmt->fetch();
        $todo = $fila;
        return $todo;
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>