<?php
  session_start();

  //If the user is not logged in, try and log them in with a cookie.
  if (!isset($_SESSION['id'])) {
    if (isset($_COOKIE['id']) && isset($_COOKIE['user'])) {
      $_SESSION['id'] = $_COOKIE['id'];
      $_SESSION['user'] = $_COOKIE['user'];
    }
  }
?>
