<?php
require_once('test_input.php');

if(!isset($_SESSION['employers_id']))
{
  header('index.php');
}

// declare variables that will be used throughout the script and contain any error messages
$no_of_internships_err = $duration_err = $start_date_err = $stipend_err = $location_err = $last_date_err = $internship_details_err = '' ;
$show_form = false;
$no_of_internships = '';
/*
      firstly we extract the $_POST
     then we test the variables
     then each of the field is checked as per required data type and we show error messages accordingly
     if everything fine upto this level, then we update our db with a new internship entry
*/

if($_SERVER["REQUEST_METHOD"] == "POST"){
 if(isset($_POST['submit'])){
  extract($_POST);

  $no_of_internships = test_input($no_of_internships);
  $start_date = test_input($start_date);
  $duration = test_input($duration);
  $stipend = test_input($stipend);
  $location = test_input($location);
  $last_date_to_apply = test_input($last_date);
  $intership_details = test_input($internship_details);
  $category = $category;

  if($category == 1)
  {
    $category = 'Web Development';
  }
  else if($category == 2)
  {
    $category = 'Content Writing';
  }

  if(!is_numeric($no_of_internships) || $no_of_internships < 0)
  {
    $no_of_internships_err = "Please enter a positive numeric value for this field";
    $show_form = true;
  }

  if(!is_numeric($duration) || $duration < 0)
  {
    $duration_err = "Please enter a positive numeric value for this field";
    $show_form = true;
  }

  if(!is_numeric($stipend) || $stipend < 0)
  {
    $stipend_err = "Please enter a positive numeric value for this field";
    $show_form = true;
  }

  if($start_date <= date("Y-m-d"))
  {
    $start_date_err = "Start Date cannot be before or same as " . date("Y-m-d");
    $show_form = true;
  }

  if($last_date > $start_date || ($last_date < date("Y-m-d")))
  {
    $last_date_err = "Last date to apply must be before Start Date of internship and it cannot be before current date";
    $show_form = true;
  }

  if(empty($location))
  {
    $location_err = "Please fill out this field";
    $show_form = true;
  }

  if(empty($internship_details))
  {
    $internship_details_err = "Please fill out this field";
    $show_form = true;
  }

  $employers_id = $_SESSION['employers_id'];


########    this if condition gets executed when there is no error as per our error checking    ##########
  if(!$show_form)
  {
    # generate a unique url for this particular internship page
    $url_code = substr(md5(uniqid(rand(), true)) , 10, 10);

    $query = "INSERT INTO internships_posted(id, url_code, no_of_internships, start_date, duration, stipend, location, details, category, last_date_to_apply)";
    $query .= " VALUES('$employers_id', '$url_code', '$no_of_internships', '$start_date', '$duration', '$stipend', '$location', '$internship_details', '$category', '$last_date_to_apply')";

    # echo $query;

    if($conn->query($query) === TRUE )
    {
      echo '<div class="alert alert-success"> Internship posted successfully. You can check its status on your home screen by clicking on Applicant Details </div>';
      $show_form = false;
    }
    else
    {
      echo '<div class="alert alert-danger"> There\'s some error occured on server. We regret for the inconvience caused. Please try again later. <br/> If this error persists, then please write to us at <a href="mailto:care@internshala.com"> care@internshala.com </a> '  ;
      # echo $conn->error ;
      $show_form = false;
    }

  }
 }
}  else { $show_form = true; }

if($show_form){
?>

<form class="form-horizontal" method="post" action="">

  <div class="form-group">
    <label class="control-label text-left col-sm-3" for="category"> Category </label>
    <div class="col-sm-3">
      <select name="category" class="form-control" required="required">
        <option value="1"> Web Development </option>
        <option value="2"> Content Writing </option>
      </select>
    </div>
  <!--  <div class="col-sm-offset-4 col-sm-8"> </div> -->
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="rollno"> No. of Internships  </label>
    <div class="col-sm-3">
      <input type="number" name="no_of_internships" class="form-control" required="required" />
    </div>
    <div class="col-sm-offset-3 col-sm-8"> <?php if($no_of_internships_err != '') echo $no_of_internships_err; ?> </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3 text-right" for="rollno"> Start Date  </label>
    <div class="col-sm-3">
      <input type="date" name="start_date" class="form-control" required="required"/>
    </div>
    <div class="col-sm-offset-3 col-sm-8"> <?php if($start_date_err != '') echo $start_date_err; ?> </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="rollno"> Duration(in months)  </label>
    <div class="col-sm-3">
      <input type="number" name="duration" class="form-control" required="required" />
    </div>
    <div class="col-sm-offset-3 col-sm-8"> <?php if($duration_err != '') echo $duration_err; ?> </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="rollno"> Stipend(per month)  </label>
    <div class="col-sm-3">
      <input type="number" name="stipend" class="form-control" required="required" />
    </div>
    <div class="col-sm-offset-3 col-sm-8"> <?php if($stipend_err != '') echo $stipend_err; ?> </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="rollno"> Location  </label>
    <div class="col-sm-3">
      <input type="text" name="location" class="form-control" required="required" />
    </div>
    <div class="col-sm-offset-3 col-sm-8"> <?php if($location_err != '') echo $location_err; ?> </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="rollno"> Last Date to Apply  </label>
    <div class="col-sm-3">
      <input type="date" name="last_date" class="form-control" required="required" />
    </div>
    <div class="col-sm-offset-3 col-sm-8"> <?php if($last_date_err != '') echo $last_date_err; ?> </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="rollno"> Intership Details  </label>
    <div class="col-sm-6">
      <textarea name="internship_details" class="form-control" rows="15" cols="20" required="required"></textarea>
    </div>
    <div class="col-sm-offset-3 col-sm-8"> <?php if($internship_details_err != '') echo $internship_details_err; ?> </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-8">
    <button type="submit" id="post_internship_btn" name="submit" class="btn btn-info" />
    Post Internship
    </button>
    </div>
  </div>

</form>

<?php
}
 ?>
