<?php

$q = "select * from internships_applicants where id='$student_id' and internship_id='$internship_id' ";
$q_processing = $conn->query($q);

if($q_processing->num_rows == 1)
{
  echo '<div class="alert alert-danger"> You have already applied for this internship. You will be taken to home page in 5 seconds </div>';
  header("Refresh: 5 , url = 'index.php' ");
  $show_form = false;
  die();
}

?>
