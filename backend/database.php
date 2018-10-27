<?php

/*
This file is in this projet solely here for mysqli_real_escape_string
*/
function connectToDB()
{
    $conn = mysqli_connect($GLOBALS['host'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db'])
        or die('Could not connect: ' . mysqli_connect_errno());
    mysqli_set_charset($conn,"utf8mb4");
    return $conn;
}
  function doQuery($dbconn, $query)
  {
      $result = mysqli_query($dbconn, $query) or die('Query failed: ' . mysqli_error($dbconn)); //returns the second argument passed into the function
      return $result;
  }
  //only for SELECT quieries (and some other, not applicable in this project)
  function freeResultAndClose($dbconn, $result)
  {
      mysqli_free_result($result);
      mysqli_close($dbconn);
  }
  function closeDB($dbconn)
  {
      mysqli_close($dbconn);
  }
