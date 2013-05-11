<?php

class Person{
  //Define private and public variables.
    private $user;
    public  $first_name;
    public  $last_name;
    public  $fullname;
    public  $email;
    public  $date;
    public  $pic;
    public  $pic_type;
    public  $pic_size;
    private $pass1;
    private $pass2;

    public $currentuser = 0;

    //Function to pull in data from POST super global.
    public function updateFromPost(){
		$this->user = trim($_POST['user']);
		$this->first_name = trim($_POST['first_name']);
		$this->last_name = trim($_POST['last_name']);
		$this->fullname = trim($_POST['first_name'] . ' ' . $_POST['last_name']);
		$this->email = trim($_POST['email']);
		$this->pic = trim($_FILES['pic']['name']);
		$this->pic_type = trim($_FILES['pic']['type']);
		$this->pic_size = trim($_FILES['pic']['size']);
		$this->pass1 = trim($_POST['pass1']);
		$this->pass2 = trim($_POST['pass2']);
    }

    //Function to verify required fields have data.
    public function isValid(){
        return !(empty($this->first_name) || empty($this->last_name) || empty($this->email) || empty($this->user) || empty($this->pic) || empty($this->pass1) || empty($this->pass2) || ($pass1 != $pass2));
    }

    //Function to check if the user exists.
    public function isUser(){
		require('dbc.php');

		$query = "SELECT * FROM email_list WHERE username = '$person->user'";

        $result = mysqli_query($dbc, $query) or die('Error querying database when checking for user.');
        if(mysqli_num_rows != 0){
			$this->currentuser = 1;
		}

        mysqli_close($dbc);
    }

    //Function to add data to table.
    public function addtoDb(){

		require('dbc.php');

		$query = "INSERT INTO email_list (first_name, last_name, email, date, pic, username, password) VALUES ('$this->first_name', '$this->last_name', '$this->email', NOW(), '$this->pic', '$this->user', SHA('$this->pass1'))";

        $result = mysqli_query($dbc, $query) or die('Error querying database when adding a user.');

        mysqli_close($dbc);
    }
}

?>
