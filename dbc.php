<?php>

  // set server access variables
	$hostname='local';  //Removed database info.
	$username='db_user';
	$password='password';
	$dbname='db_name';

	//Set connection
	$dbc = mysqli_connect($hostname, $username, $password, $dbname)	or die('Error connecting to MySQL server.');

?>
