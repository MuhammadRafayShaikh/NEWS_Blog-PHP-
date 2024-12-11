<?php 

require 'config.php';

session_start();

// For remove the values of the session variables
session_unset();

session_destroy();

header("Location: index.php");

?>
