<?php
  //Start the session
	session_start();

	//Clear error message variable.
	$error_msg = "";

	//If the user is not logged in, try and log them in.
	if(!isset($_SESSION['id'])){
		if(isset($_POST['submit'])){
			//Call database
			require('dbc.php');
			require_once('appvars.php');

			//Grab username/password entered by user.
			$user = mysqli_real_escape_string($dbc, trim($_POST['user']));
			$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));

			if(!empty($user) && !empty($pass)){
				//Query database.
				$query = "SELECT * FROM email_list WHERE username = '$user' AND password = SHA('$pass')";

				//Error check, grab, and store required data.
				$result = mysqli_query($dbc, $query) or die('Error querying database.');

				if(mysqli_num_rows($result) == 1){
					//The login was correct.
					$row = mysqli_fetch_array($result);
					$_SESSION['id'] = $row['id'];
					$_SESSION['user'] = $row['username'];
					setcookie('id', $row['id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
					setcookie('user', $row['user'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
					$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/main.php';
					header('Location: ' . $home_url);
				}
				else{
					//The login was incorrect.
					$error_msg = 'Sorry, you entered an incorrect username and password.';
				}
			}
			else{
				//The login was blank.
				$error_msg = 'Sorry, you must enter your username and password to log in.';
			}
		}
	}
?>

<html>
<head>
	<link rel="stylesheet" href="./css/style.css">
	<meta charset="utf-8">
	<title>Registration</title>
</head>

<body>
	<div id="wrapper">
		<header>
		   <hgroup>
			  <h2>Code Test Project</h2>
			  <h3><a href="http://www.arvixe.com/">arvixe</a></h3>
		   </hgroup>
		</header>

		<h1>Login Page</h1>
		<hr />
		<nav>
		   <ul>
			  <li><a href="./main.php">Home</a></li>
			  <li><a href="./addemail.php">Register</a></li>
		   </ul>
		</nav>

		<div id="content">
			<hr />
				<?php
				//If the cookie is empty, show an error message.
				if(empty($_SESSION['id'])){
					echo '<p>' . $error_msg . '</p>';
					?>
					<form method="post" id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<br />
						<div>
							 <label for="user">Enter username:</label>
							 <input type="text" name="user" id="user" value="<?php if(!empty($user)) echo $user; ?>">
						</div>
						<div>
							 <label for="pass">Enter password:</label>
							 <input type="password" name="pass" id="pass">
						</div>
						<div id="mySubmit">
							 <br/>
							 <input type="submit" value="submit" name="submit">
							 <input type="reset" value="Reset">
						</div>
						<br />
					</form>
					<?php
				}
				else{
					//Confirm successful login.
					echo('<p>You are logged in as ' . $_SESSION['user'] . '.</p>');
					?>
					<meta http-equiv="REFRESH" content="2;url=./main.php">
					<?php
				}
				?>
		</div> <!-- End of content. -->
		<hr />
		<footer>Copyrite &copy; 2012</footer>
	</div> <!-- End of wrapper. -->
</body>
</html>
