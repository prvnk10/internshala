<?php
require_once('connection.php');

$query = "select ip.internship_id, ip.no_of_internships, ip.url_code, ip.start_date, ip.duration, ip.stipend, ip.location, ip.details, ip.category, " ;
$query .= "ip.last_date_to_apply, e.name FROM internships_posted AS ip INNER JOIN employers AS e USING(id) ORDER BY start_date DESC";

# echo $query;

$q_processing = $conn->query($query);

# echo '<div class="col-sm-offset-1 col-sm-11">';
if($q_processing->num_rows > 0)
{
  echo "<h4 class='col-sm-offset-1'> Recently posted internships </h4>";
  while($q_result = $q_processing->fetch_assoc())
  {

    if(date("Y-m-d") < $q_result['last_date_to_apply'])
    {

    echo '<div class="well well-sm col-sm-offset-1 col-sm-8"> ' ;

    echo '<h3>' . $q_result['category'] . '</h3>';
    echo '<h5 class="col-sm-3"> <b> Company Name: </b>' . $q_result['name'] . '</h5>' ;
    echo '<h5 class="col-sm-3"> <b> Location: </b>' . $q_result['location'] . '</h5>' ;
    echo '<h5 class="col-sm-3"> <b> Stipend: </b>' . $q_result['stipend'] . ' per month </h5>' ;
    echo '<h5 class="col-sm-3"> <b> Start Date:  </b> ' .  $q_result['start_date'] . '</h5>';
    echo '<h5 class="col-sm-3"> <b> Duration: </b> ' . $q_result['duration'] . '</h5>';
    echo '<h5 class="col-sm-3"> <b> Deadline: </b>' . $q_result['last_date_to_apply'] . '</h5> ' ;
    echo '<h5 class="col-sm-3"> <b> No. of Internships: </b>' . $q_result['no_of_internships'] . '</h5> ' ;

    echo '<div class="col-sm-12">  Internship Details:  <br />' . $q_result['details'] . '</div>';

    echo '<div class="col-sm-8 text-center">';
    if(isset($_SESSION['students_id']))
    {
      $id = $_SESSION['students_id'];
      $internship_id = $q_result['internship_id'];
      $q2 = "SELECT * FROM internships_applicants WHERE id='$id' AND internship_id = '$internship_id'";
      $q2_processing = $conn->query($q2);

      if($q2_processing->num_rows == 0)
      {
       echo '<a href="apply-now.php?c=' . $q_result["url_code"] . '">' ;
       echo '<input type="button" class="btn btn-info" value="APPLY NOW">';
       echo '</a>';
      }
      else if($q2_processing->num_rows == 1)
       echo '<button class="btn btn-info disabled" > Already Applied </button>';
    }
    echo '</div>';
    echo '</div>';
  }

  }                      # while loop ends here

}
# echo "</div>";
 ?>
