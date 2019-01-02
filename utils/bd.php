<?php

date_default_timezone_set('America/Belem');

try {
	 $conn = new PDO( 'mysql:host=' . 'bd.acompanha.macapa.ap.gov.br' . ';dbname=' . 'bdacompanha', 'run75km8qbjzucu', '9dPRjygrCdWJ7WHe5sHY', 
	// $conn = new PDO( 'mysql:host=' . 'localhost' . ';dbname=' . 'bdacompanha', 'root', '', 
	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch ( PDOException $e ) {
    echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
}

?>