<?php 
	
	$host = 'localhost';
	$user = 'flavio';
	$pass = '1Mec@1379*';
	$db = 'test';

	$conn = mysqli_connect($host, $user, $pass, $db);

	$sql = 'SELECT * FROM users';
	$result = mysqli_query($conn, $sql);

	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	//print_r($users);

	mysqli_close($conn);
?>