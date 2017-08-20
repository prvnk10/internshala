<?php
require_once('require/connection.php');


# if user's already logged in, then redirect user to home page
if(isset($_SESSION['students_id']) || isset($_SESSION['employers_id']))
{
  header("Location: index.php");
}

require_once('require/test_input.php');

# initialising different variables needed in the script
$show_form = false;
$nameErr = $emailErr = $passwordErr = $confirm_PasswordErr  = $mobileNoErr = '' ;
$error = '';

# check if the form is submitted or not
if($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST['submit'])){

/*
    firstly we extract the $_POST
     then we test the variables
     then it is checked whether the field is empty or not, if yes show corresponding error message
     value of password and confirm_Password fields are matched
     then we query the database using value of enterd email in WHERE clause
      if 0 rows are affected, it means email is unique
      insert values into db and send an email to user for verification of account
*/
   extract($_POST);

   $user = $user;

   if($user == 1)
   {
     $user = 'students';
   }
   else if($user == 2)
   {
     $user = 'employers';
   }

   if(empty($name)){
     $nameErr = "Please fill out name";
     $show_form = true;
   } else {
     $name = test_input($name);
      if(!preg_match("/^[a-zA-Z ]*$/" ,$name)){                      # make sure only alphabets are allowed in name
       $nameErr = "Only letters and white spaces are allowed";
       $show_form = true;
      }
   }

  if(empty($email)){
     $emailErr = "Please fill out email";
     $show_form = true;
  } else {
     $email = test_input($email);
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
       $emailErr = "Invalid email format";
       $show_form = true;
      }
  }

  if(empty($password)){
     $passwordErr = "Please fill out this field" ;
     $show_form = true;
  }

  if(empty($confirm_Password)){
     $confirm_PasswordErr = "Please fill out this field" ;
     $show_form = true;
  }

  if( $password !== $confirm_Password){
     $passwordErr = "Passwords do not match" ;
     $confirm_PasswordErr = "Passwords do not match";
     $show_form = true;
  }

  if(empty($mobile_no))
  {
    $mobileNoErr = "Please fill out this field";
    $show_form = true;
  }
  else
  {
    if( !(preg_match('/^[7-9]\d{9}$/' , $mobile_no)) )
    {
      $mobileNoErr = "Please enter a valid 10 digit number";
      $show_form = true;
    }
    else
    {
      $mobile_no = $mobile_no;
    }
  }


  if( (!empty($name)) && (!empty($email)) && (!empty($password)) && (!empty($confirm_Password)) && ($password === $confirm_Password)  && (!$show_form) ){

   $query = "SELECT * FROM $user WHERE email = '$email' ";
   $result = $conn->query($query);

   if($result->num_rows == 0){                     # make sure that entered email is not registered already

    $password = sha1($password);
    $a_code = substr(md5(uniqid(rand(), true)) , 10, 15);       # generate activation code
    $time = time();
#      $hash = md5($email . $time . "pk");

    $insert = "INSERT INTO $user(name, email, password, mobile, activation_code) VALUES ('$name', '$email', '$password', '$mobile_no', '$a_code' )" ;

    if($conn->query($insert) === TRUE){

    echo "<div class='alert alert-success col-sm-8'> Signed up successfully. You can now <a href='login.php'> login </a> to your account";
    echo " You need to activate your account to get access to all features. We have sent you an email, please click on the link in the email to activate your account";
    echo '<a href="activate_account.php?email=' . $email . '&a_code=' . $a_code . '&t='.$time.'"> Activate your account </a> ';
  #     send an email to the user
  #     show hashed form of diff. parameters in the activation link
  #     echo '<a href="activate_account.php?$hash=" . $hash . '"> Activate </a> ';

    }  else { $show_form = true; $error = 'there is some error connecting to db'; }

  } else { $emailErr =  "Entered email is already registered"; $show_form = true; $error = ''; }
} else {  $show_form = true; $error = 'there is some error connecting to db';}

}

}

else { $show_form = true ; }

if( $show_form ){

  if($error != '')
  {
    echo '<div class="alert alert-danger">' . $error . '</div>';
  }
 ?>

 <form method="post" class="form-horizontal">

   <div class="form-group">
     <label class="control-label col-sm-4" for="password"> Register as: </label>
     <div class="col-sm-4">
       <select name="user" class="form-control" required="required">
         <option value="1"> Student </option>
         <option value="2"> Employer </option>
       </select>
     </div>
     <div class="col-sm-4"> </div>
   </div>

  <div class="form-group">
   <label class="control-label col-sm-4" for="name"> Name: </label>
   <div class="col-sm-4">
   <input class="form-control" type="text" name="name" value="<?php if(!empty($name)) echo $name; ?>" required="required" />
   <span id="nameErr" class="help-block error"> <?= $nameErr ?> </span>
   </div>
  </div>

  <div class="form-group">
   <label class="control-label col-sm-4" for="email"> Email: </label>
   <div class="col-sm-4">
   <input class="form-control" type="email" name="email" id="email" value="<?php if(!empty($email)) echo $email; ?>" required="required" />
   <span id="emailErr" class="help-block error"> <?= $emailErr ?> </span>
   </div>
  </div>

  <div class="form-group">
   <label class="control-label col-sm-4" for="password"> Password: </label>
   <div class="col-sm-4">
   <input class="form-control" type="password" id="password" name="password" required="required" />
   <span id="passwordErr" class="help-block error"> <?= $passwordErr ?> </span>
   </div>
  </div>

  <div class="form-group">
   <label class="control-label col-sm-4" for="confirm_password"> Confirm Password: </label>
   <div class="col-sm-4">
   <input class="form-control" type="password" id="confirm_password" name="confirm_Password" required="required" />
   <span id="confirm_PasswordErr" class="help-block error"> <?= $confirm_PasswordErr ?> </span>
   </div>
  </div>

  <div class="form-group">
   <label class="control-label col-sm-4" for="pasmobile_nosword"> Mobile: </label>
   <div class="col-sm-4">
   <input class="form-control" type="number" id="mobile_no" name="mobile_no" value="<?php if(!empty($mobile_no)) echo $mobile_no; ?>" required="required" size="10"/>
   <span id="mobileNoErr" class="help-block error"> <?= $mobileNoErr ?> </span>
   </div>
  </div>

  <div class="form-group">
   <div class="col-sm-offset-4 col-sm-4">
   <button type="submit" id="signup_btn" name="submit" class="btn btn-info" />
   Sign up
   </button>
   </div>
  </div>

  </form>


<?php
}

?>
