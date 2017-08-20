<?php

// this function takes one input, and then remove extra slashes, space, and convert special character as
//  per required encoding and returns that input value 
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
