<?php
# session_start();

if(isset($_SESSION['employers_id']))
{

?>

 <div class="col-sm-3">
  <div class="list-group">
   <a href='index.php' class="col-sm-8 list-group-item"> <?php echo $_SESSION['name']; ?> </a>
   <a href='index.php?e=2' class="col-sm-8 list-group-item"> Post an Internship </a>
   <a href='index.php?e=3' class="col-sm-8 list-group-item"> Applicants Details </a>
   <a href='index.php?e=4' class="col-sm-8 list-group-item"> Change Password </a>
   <a href='logout.php' class="col-sm-8 list-group-item"> Logout </a>
  </div>
 </div>

 <div class="col-sm-9">

  <?php
   $e = isset($_GET['e']) ? $_GET['e'] : 0 ;

   switch ($e)
   {
     case 2:
      require_once('post_an_internship.php');
      break;

     case 3:
      require_once('applicant_details.php');
      break;

     case 4:
       require_once('change_password.php');
       break;

     default:
       require_once('all_internships.php');
       break;
   }
   ?>

 </div>

<?php

}

else if(isset($_SESSION['students_id']))
{

?>

 <div class="col-sm-3">
  <div class="list-group">
   <a href='index.php' class="col-sm-8 list-group-item"> <?php echo $_SESSION['name']; ?> </a>
   <a href='index.php?s=2' class="col-sm-8 list-group-item"> Dashboard </a>
   <a href='index.php?s=3' class="col-sm-8 list-group-item"> Change Password </a>
   <a href='logout.php' class="col-sm-8 list-group-item"> Logout </a>
 </div>
 </div>

 <div class="col-sm-9">
  <?php

   $s = isset($_GET['s']) ? $_GET['s'] : 0 ;

   switch($s)
   {
     case 2:
       require_once('dashboard.php');
       break;

    case 3:
      require_once('change_password.php');
      break;

    default:
     require_once('all_internships.php');
     break;
   }

  ?>

 </div>

<?php

 }  else { require_once('all_internships.php'); }

?>
