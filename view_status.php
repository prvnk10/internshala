<?php
require_once('require/connection.php');
require_once('require/test_input.php');

if(!isset($_SESSION['employers_id']))
{
  header("Location: index.php");
}

$url_code = isset($_GET['c']) ? $_GET['c'] : 0 ;

$q = "select ip.internship_id, ia.id, ia.details_submitted from internships_posted as ip inner join internships_applicants as ia using(internship_id) where url_code = '$url_code'" ;
$q_processing = $conn->query($q);

if($q_processing->num_rows > 0)
{
  echo '<div class="col-sm-8">';
  echo '<table class="table table-bordered table-hover"> <tr> <th> Applicant\'s Name </th> <th> Applicant\'s Email </th> <th> Details Submitted </th> </tr>';

  while($q_results = $q_processing->fetch_assoc())
  {
    $student_id = $q_results['id'];
    $q2 = "select name, email from students where id='$student_id' ";
    $q2_processing = $conn->query($q2);

    $q2_results = $q2_processing->fetch_assoc();

    echo '<tr>';
    echo '<td>' . $q2_results['name'] . '</td> <td>' . $q2_results['email'] . '</td> <td>' . $q_results['details_submitted'] . '</td>';
    echo '</tr>';
  }

  echo '</table>';
  echo '</div>';
}

else
{
  echo '<div class="alert alert-warning col-sm-12"> It appears that no one has applied for this internship yet </div>';
}
/*
else
{
  echo $conn->error;
}
*/

?>
