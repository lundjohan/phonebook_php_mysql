<?php
function connectToDB(){
    $conn = mysqli_connect("localhost", "root", "", "phonebook")
        or die('Could not connect: ' . mysqli_connect_errno());
    return $conn;
}
  function doQuery($dbconn, $query){
      $result = mysqli_query($dbconn, $query) or die('Query failed: ' . mysqli_error($dbconn)); //returns the second argument passed into the function
      return $result;
  }
  function freeResultAndClose($dbconn, $result){
      mysqli_free_result($result);
      mysqli_close($dbconn);
  }
?>
