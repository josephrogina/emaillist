<?php
//If the user is logged in, delete the cookie.
session_start();
if(isset($_SESSION['id'])){
  //Delete the session by erasing the $_SESSION array
	$_SESSION = array();
}

if(isset($_COOKIE[session_name()])){
	//Set the cookies to an hour ago to remove them.
	setcookie(session_name(), '', time() - 3600);
}

//Destroy session.
session_destroy();

// Redirect to the home page
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/emaillist/login.php';
header('Location: ' . $home_url);
?>
