<?php
require_once('require/connection.php');
require_once('require/test_input.php');

// if user's already logged in, then redirect user to home page
if(isset($_SESSION['students_id']) || isset($_SESSION['employers_id']))
{
  header("Location: index.php");
}

// declare variables that will be used throughout the script and contain any error messages
$emailErr = $login_result = '';
$show_form = $show_link = false;

// this if block gets executed when user first submits the login form
// first we extract the variables in $_POST superglobal, and then pass the variables through our test_input function
if($_SERVER["REQUEST_METHOD"] == "POST"){
 if(isset($_POST['submit'])){
  extract($_POST);

  $email = test_input($email);
  $password = test_input($password);
  $user = $user;

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
   $emailErr = "Invalid email format";
   $show_form = true;
  }

  if($user == 1)
  {
    $user = 'students';
  }
  else if($user == 2)
  {
    $user = 'employers';
  }

// there must be condition to check the value of $user or not and show the form to user if value is invalid?

  if(!$show_form){

   $password = sha1($password);
   $query = "SELECT * FROM $user WHERE email = '$email' AND password = '$password' ";
   # echo $query;
   $q_result = $conn->query($query);

   if( $q_result->num_rows == 1 )
   {        # login ok
     $user_details = $q_result->fetch_assoc();
     $_SESSION[$user.'_id'] = $user_details['id'];
     $_SESSION['name'] = $user_details['name'];

     # echo var_dump($_SESSION);
     # header("Location: $url");            # redirect to correct page(depending upon user's logged in as employer or student)
     header("Location: index.php");
   }
   else {
    $login_result =  "Invalid credentials";
    $show_form = true;
    $show_link = true;
   }
  }
 }
} else { $show_form = true;}

if($show_form){

 if($login_result != ''){ ?>
  <div class="alert alert-danger alert-dismissable fade in text-center col-sm-12">
  <a href="#" class="close" data-dismiss="alert" aria-label="close"> × x </a>
  <?php echo $login_result; ?>
  </div>
 <?php } ?>

<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

  <div class="form-group">
    <label class="control-label col-sm-4" for="password"> Login as </label>
    <div class="col-sm-4">
      <select name="user" class="form-control" required="required">
        <option value="1"> Student </option>
        <option value="2"> Employer </option>
      </select>
    </div>
    <div class="col-sm-4"> </div>
  </div>

 <div class="form-group">
   <label class="control-label col-sm-4" for="rollno"> Email  </label>
   <div class="col-sm-4">
     <!-- <span class="glyphicon glyphicon-user"> </span> -->
     <input type="email" name="email" class="form-control" required="required" />
   </div>
   <div class="col-sm-4"> <?php if($emailErr != '') echo $emailErr; ?> </div>
 </div>

 <div class="form-group">
   <label class="control-label col-sm-4" for="password"> Password  </label>
   <div class="col-sm-4">
     <input type="password" name="password" class="form-control" required="required" />
   </div>
   <div class="col-sm-4"> </div>
 </div>

<?php if($show_link){  ?>
 <div class="form-group">
   <div class="col-sm-offset-4 col-sm-4"> <a href="forgot_password.php"> Forgot password </a> </div>
  <!-- <div class="col-sm-2"> New User <a href="signup.php"> Register Here </a> </div>  -->
 </div>
<?php } ?>


 <div class="form-group">
   <div class="col-sm-offset-4 col-sm-8">
   <button type="submit" id="login_btn" name="submit" class="btn btn-info" />
   Log In
   </button>
   </div>
 </div>
</form>

<?php
}
 ?>
