<?php
function doDB(){
  global $mysqli;
  $mysqli = mysqli_connect("localhost", "root", "", "forum");
  if(mysqli_connect_errno()){
    printf("Connection faild : %s\n", mysqli_connect_error());
    exit();
  }
}
 ?>
