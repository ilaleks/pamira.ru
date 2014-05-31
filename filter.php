<?php
include_once '/includes/config.php';

if (isset($_POST['catalog'])) {
	/* Создание подключения */
    /*$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
	$mysqli->query("SET NAMES 'windows-1251';");
	$mysqli->query("SET CHARACTER SET 'windows-1251';");
	$mysqli->query("SET SESSION collation_connection = 'cp1251_general_ci';"); 
	
	// Проверка подключения 
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();        
    }*/
	
	/*$link = mysql_connect($dbhost, $dbuser, $dbpass);
	
	if (!$link) {
		die('Ошибка соединения: ' . mysql_error());
	}
	echo 'Успешно соединились';
	mysql_close($link);*/
	$getquery=mysql_query("SELECT * FROM ".$tablesPrefix."catalog");
	while($rowquery=mysql_fetch_array($getquery)){
		print_r($rowquery);
	}
}