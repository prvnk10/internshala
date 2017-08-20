<?php
require_once('connection.php');

if(!isset($_SESSION['students_id']))
{
  header("Location: login.php");
}

$id = $_SESSION['students_id'];
$query = "SELECT * FROM internships_applicants WHERE id = '$id'";
$q_processing = $conn->query($query);

if($q_processing->num_rows == 0)
{
  echo "You have not applied for any internship yet. <a href='index.php'> Apply Now </a>";
}
else
{
  echo "<table class='table'>";
  echo "<tr> <th> Date </th> <th> Company Name </th> <th> Status </th> <th> No. of Applicants </th>  </tr>";

  while($q_result = $q_processing->fetch_assoc())
  {
    echo "<tr>";
    echo "<td>" . $q_result['date_applied'] . "</td>";

    $internship_id = $q_result['internship_id'];

    $q3 = "SELECT e.name, ip.id FROM employers AS e inner join internships_posted as ip using(id) where internship_id = '$internship_id'";
    $q3_processing = $conn->query($q3);
    $q3_results = $q3_processing->fetch_assoc();

    echo "<td>" . $q3_results['name'] . "</td>";
    echo "<td>" . $q_result['status'] . "</td>";

    $q2 = "SELECT * FROM internships_applicants WHERE internship_id = '$internship_id'";
    $q2_processing = $conn->query($q2);

    echo "<td>" . $q2_processing->num_rows . "</td>";
  #  echo "<td> <a href=''> View Application </td>";


  }

  echo "</table>";
}

 ?>
