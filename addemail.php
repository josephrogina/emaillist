<!DOCTYPE html>
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

		<h1>Register as a user</h1>
		<hr />
		<nav>
		   <ul>
				  <li><a href="./main.php">Home</a></li>
				  <li><a href="./logout.php">Log out</a></li>
		   </ul>
		</nav>

		<div id="content">
			<hr />
			<p>Signup to become a member!</p>
			<?php
				//Include the class.
				require_once('PersonClass.php');

				//Creates a new person with the class.
				$person = new Person();

				//Define application variables.
				require_once('appvars.php');

				if (isset($_POST['submit'])) {

					//Fills in all the data from the POST.
					$person->updateFromPost();

					//Verify no required fields are left blank.
					if ($person->isValid()) {
						//Verify the piture is a certain type and size.
						if ((($person->pic_type == 'image/gif') || ($person->pic_type == 'image/jpeg') || ($person->pic_type == 'image/pjpeg') || ($person->pic_type == 'image/png')) && ($person->pic_size > 0) && ($person->pic_size <= MAXFILESIZE)) {
							if ($_FILES['pic']['error'] == 0) {
								//Move the file to the target upload folder
								$target = UPLOADPATH . $person->pic;

									$regex = '/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/';
									if (preg_match($regex, $person->email)) {
										//Strip out everything but the domain from the email
										$domain = preg_replace($regex, $replacement, $person->email);

										//Now check if $domain is registered
										if (checkdnsrr($domain)) {

												if (move_uploaded_file($_FILES['pic']['tmp_name'], $target)) {

													//Query database for user.
													$person->isUser();

													if($person->currentuser == 0){
														//No current user with that username and password.
														//Then add them to the database.

														$subject = "Signup for arvixe test form." ;
														$message = "$person->fullname would like to sign up for the arvixe test form.\n";

														mail("joseph@rogina.net", $subject,
														$message, "From:" . $person->email);

														$person->addtoDb();

														echo "<p>Thank you for registering, $person->fullname. Watch your inbox for our newsletter!</p>";

														?>
														<meta http-equiv="REFRESH" content="5;url=./login.php">
														<?php
													}
													else {
														echo '<p>Sorry, that username is taken.</p>';
													}
												}
												else {
													echo '<p>Sorry, there was a problem uploading your avatar image.</p>';
												}
										}
										else {
											echo '<p>Your email address is invalid - checkdnsrr()</p>';
										}
									}
									else {
										echo '<p>Your email address is invalid - LocalName</p>';
									}
							}
						}
						else{
							echo '<p>The picture must be a GIF, JPEG, or PNG image file no greater than ' . (MAXFILESIZE / 1024) . ' KB in size.</p>';
						}
						// Try to delete the temporary screen shot image file
						@unlink($_FILES['screenshot']['tmp_name']);
					}
					else {
						echo '<p>Please enter all of the information to register for the Newsletter.</p>';
					}
				}
			?>
			<form enctype="multipart/form-data" method="post" id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" />
				<input type="hidden" name="MAX_FILE_SIZE" value="32768" />
				<br />
				<div>
					 <label for="first_name">First Name:</label>
					 <input type="text" name="first_name" id="first_name" value="<?php if (!empty($first_name)) echo $first_name; ?>" />
				</div>
				<div>
					 <label for="last_name">Last Name:</label>
					 <input type="text" name="last_name" id="last_name" value="<?php if (!empty($last_name)) echo $last_name; ?>" />
				</div>
				<div>
					 <label for="email">E-mail:</label>
					 <input type="text" name="email" id="email" value="<?php if (!empty($email)) echo $email; ?>" />
				</div>
				<div>
					 <label for="pic">Upload picture:</label>
					 <input type="file" name="pic" id="pic" />
				</div>
				<div>
					 <label for="user">Pick a username:</label>
					 <input type="text" name="user" id="user">
				</div>
				<div>
					 <label for="pass1">Set a password:</label>
					 <input type="password" name="pass1" id="pass1" />
				</div>
				<div>
					 <label for="pass2">Confirm password:</label>
					 <input type="password" name="pass2" id="pass2" />
				</div>
				<div id="mySubmit">
					 <br/>
					 <input type="submit" value="submit" name="submit" />
					 <input type="reset" value="Reset" />
				</div>
				<br />
			</form>
		</div> <!-- End of content. -->
		<hr />
		<footer>Copyrite &copy; 2012</footer>
	</div> <!-- End of wrapper. -->
</body>
</html>
