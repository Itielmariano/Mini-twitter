<?php
	date_default_timezone_set("America/Sao_Paulo");
	define('BASE', 'http://tfmeventos.esy.es/mini');

	$pdo = new PDO('mysql:host=localhost;dbname=u365417210_mini', 'u365417210_mini','1234567i');
	$pdo->exec("set names utf8");
?>