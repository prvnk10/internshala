<?php

define("servername", "localhost");
define("username", "root");
define("password", "");
define("db_name", "internshala");

session_start();

// connect to database
$conn = new mysqli(servername , username, password , db_name);

if($conn->connect_error){
  echo "Connection problem";
}

?>

<link href="styles/bootstrap.css" rel="stylesheet" type="text/css">
<script src="styles/jquery-3.1.0.js"> </script>
<script src="styles/bootstrap.js"> </script>

<div class="container-fluid">
<div class="page-header col-sm-12">

<div class="col-sm-8">
<a href='index.php'> <img src="internshala_logo.png" class="img img-rounded" height="80"> </a>
</div>

<!-- navigation.php adds navigation to header, like if the user's not logged in then it will show login and register option -->
<?php require_once('navigation.php'); ?>

</div>
