<?php

$db = mysqli_connect(
	$_ENV['DB_SERVER'],
	$_ENV['DB_USER'],
	$_ENV['DB_PASSWORD'],
	$_ENV['DB_DATABASE']
);
$db->set_charset('utf8');

if(!$db) {
	echo "Error en la Conexión";
	echo "errno de depuración: " . mysqli_connect_errno();
	echo "error de depuración: " . mysqli_connect_error();

	exit;
}

