<?php
require_once('connection.php');

if(!isset($_SESSION['employers_id']))
{
  header("Location: index.php");
}

$employer_id = $_SESSION['employers_id'];

# $q = "select ia.id, ia.details_submitted, s.name from interships_applicants as ia inner join students as s using(id) where internship_id='select internship_id from internships_posted where id=\"$employer_id \"' ";
# $q_processing = $conn->query($q);

$query = "SELECT * FROM internships_posted WHERE id='$employer_id'";
$query_processing = $conn->query($query);

if($query_processing->num_rows > 0)
{
  # echo '<table> <tr> <th> User Id </th> </tr>';
  echo "Internship(s) posted by you";
  while($q_result = $query_processing->fetch_assoc())
  {
    echo '<div class="alert alert-warning col-sm-12">';
    echo '<h3>' . $q_result['category'] . '</h3>';
    echo '<h5 class="col-sm-4"> <b> Location: </b>' . $q_result['location'] . '</h5>' ;
    echo '<h5 class="col-sm-4"> <b> Stipend: </b>' . $q_result['stipend'] . ' per month </h5>' ;
    echo '<h5 class="col-sm-4"> <b> Start Date:  </b> ' .  $q_result['start_date'] . '</h5>';
    echo '<h5 class="col-sm-4"> <b> Duration: </b> ' . $q_result['duration'] . ' months </h5>';
    echo '<h5 class="col-sm-4"> <b> Deadline: </b>' . $q_result['last_date_to_apply'] . '</h5> ' ;
    echo '<h5 class="col-sm-4"> <b> No. of Internships: </b>' . $q_result['no_of_internships'] . '</h5> ' ;

    echo '<div class="col-sm-12"> <h5> <b> Internship Details: </b> <br />' . $q_result['details'] . ' </h5> </div>';
    echo '<a href="view_status.php?c=' . $q_result['url_code'] . '" target="_blank" class="col-sm-4"> <input type="button" class="btn btn-primary" value="View Status"> </a>';
    echo '</div>';
  }
}

 ?>
