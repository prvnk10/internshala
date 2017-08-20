<?php
# session_start();

############     if no one(student/employer) is logged in, then show the login as well as Register button    ############

if( !isset($_SESSION['students_id']) && !isset($_SESSION['employers_id']) )
{
  echo '<a class="btn btn-info col-sm-offset-1 col-sm-1" href="login.php"> Login </a>';
  echo '<a class="btn btn-info col-sm-offset-1 col-sm-1" href="signup.php"> Register </a>';
}

?>
