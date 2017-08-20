<?php
require_once('require/connection.php');
require_once('require/test_input.php');

if(!isset($_SESSION['students_id']))
{
  header("Location: index.php");
}

$user_answer_err = '' ;
$url_code = isset($_GET['c']) ? $_GET['c'] : 0 ;

$q_url = "select internship_id from internships_posted where url_code = '$url_code'" ;
$q_url_processing = $conn->query($q_url);

if($q_url_processing->num_rows == 1)
{
  $q_url_result = $q_url_processing->fetch_assoc();
  $_SESSION['internship_id'] = $q_url_result['internship_id'];
}

$student_id = $_SESSION['students_id'];
$internship_id = $_SESSION['internship_id'];

require_once('require/check_student_availability.php');

$show_form = false;

#################  when the form is submitted, then this part gets executed ####################
if($_SERVER["REQUEST_METHOD"] == "POST"){
 if(isset($_POST['submit'])){
  extract($_POST);

  $user_answer = test_input($user_answer);

   if(empty($user_answer))
   {
     $user_answer_err = 'Please fill out this field';
     $show_form = true;
   }

  if(!$show_form)
  {
    $query = "INSERT INTO internships_applicants(id, internship_id, date_applied, status, details_submitted) VALUES('$student_id', '$internship_id', NOW(), 'Applied', '$user_answer')";

    if($conn->query($query) === true)
    {
     echo '<div class="alert alert-success col-sm-12"> Application submitted successfully <br/> You will be taken to home page in 5 seconds';
     header("Refresh: 5 , url = 'index.php' ");
     $show_form = false;
    }
    else
    {
     echo '<div class="alert alert-danger col-sm-12"> There\'s some error in submiting your application. Please try again later. </div>';
     $show_form = false;
    }

  }
 }
} else { $show_form = true; }

if($show_form){
 ?>

 <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

   <div class="container">
   <div class="form-group">
     <label for="password"> Why you should be hired for this internship? </label>

     <textarea class="form-control" rows="15" cols="20" name="user_answer"></textarea>
     </div>
     <div class="col-sm-offset-4 col-sm-8"> <?php if($user_answer_err != '') echo $user_answer_err; ?> </div>
   </div>
 </div>

   <div class="form-group">
     <div class="col-sm-offset-1 col-sm-8">
     <button type="submit" id="submit_internship_form" name="submit" class="btn btn-info" />
     Submit
     </button>
     </div>
   </div>

</form>

<?php
 }
 ?>
