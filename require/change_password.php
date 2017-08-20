<?php
require_once('connection.php');

// declare variables that will be used throughout the script and contain any error messages
$show_form = $show_update_form = false;
$password_changed_successfully = $identity_verification_failed = '';

// this if block gets executed when user first submits his/her current password
if(isset($_POST['change_password'])){
  extract($_POST);

// hash the input value of password
  $current_password = sha1($current_password);

// check whether the user's logged in as student or employer and then proceed accordingly
  if(isset($_SESSION['students_id'])){
    $user = 'students';
    $user_id = $_SESSION['students_id'];
  }
  else if(isset($_SESSION['employers_id'])){
    $user = "employers";
    $user_id = $_SESSION['employers_id'];
  }

// query the db looking for the validity of credentials
  $query = "SELECT * FROM $user WHERE id = '$user_id' AND password = '$current_password'";
  $q_processing = $conn->query($query);

// if no of affected row is 1, this means that credentials are valid and we will show the form to enter new password
// otherwise we show them an error message
  if($q_processing->num_rows == 1){
    $show_update_form = true;
    $show_form = false;
  } else { $identity_verification_failed = "Incorrect Password" ; $show_form = true;}


// curly brace below closes the if block which gets executed when submits his/her current password
} else { $show_form = true;}


// if the new pw is submitted then this block gets executed
if(isset($_POST['update_password'])){
  extract($_POST);

// hash the new pw
  $new_password = sha1($new_password);

  if(isset($_SESSION['students_id'])){
    $user = "students";
    $user_id = $_SESSION['students_id'];
  }
  else if(isset($_SESSION['employers_id'])){
    $user = "employers";
    $user_id = $_SESSION['employers_id'];
  }

// update db
  $query = "UPDATE $user SET password = '$new_password' WHERE id = '$user_id' LIMIT 1";
  # echo $query;
  $q_processing = $conn->query($query);

  if($q_processing === true){
    $show_update_form = true;
    $show_form = false;
    $password_changed_successfully = "Password updated successfully";
  }
}            # this closes block which gets executed when new pw is submitted by user

if($show_form){

 if($identity_verification_failed != ''){
   echo "<div class='alert alert-danger alert-dismissable fade in'> <a href='#' class='close' data-dismiss='alert' aria-label='close'> &times; </a>" . $identity_verification_failed . "</div>";
 }
?>

<form action="" method="post" class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-sm-4" for="password"> Please enter your current password </label>
    <div class="col-sm-4">
      <input type="password" class="form-control" name="current_password">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-6">
    <button class="btn btn-info" type="submit" name="change_password"> Continue </button>
    </div>
  </div>

</form>

<?php
}

if($password_changed_successfully != ''){
  echo "<div class='alert alert-success alert-dismissable fade in'> <a href='#' class='close' data-dismiss='alert' aria-label='close'> × </a>" . $password_changed_successfully . "</div>";
  $show_update_form = false;
}

if($show_update_form){

?>

<form action="" method="post" class="form-horizontal">
 <div class="form-group">
  <label class="control-label col-sm-4" for="password"> New Password </label>
  <div class="col-sm-4">
  <input type="password" class="form-control" name="new_password">
  </div>
 </div>

 <div class="form-group">
  <div class="col-sm-offset-4 col-sm-8 ">
  <button class="btn btn-info " type="submit" name="update_password"> Change Password </button>
  </div>
 </div>

</form>

<?php
 }
?>
