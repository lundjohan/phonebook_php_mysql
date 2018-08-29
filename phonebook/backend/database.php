<?php
$host = "localhost";
$user = "root";
$pwd = "";
$database = "phonebook";
/*
 Convenient methods to abstract away which database is used.
   Parameters might need to change in these functions in case of change to different RDBMS however.
*/
function connectToDB()
{
    $conn = mysqli_connect($GLOBALS['host'], $GLOBALS['user'], $GLOBALS['pwd'], $GLOBALS['database'])
        or die('Could not connect: ' . mysqli_connect_errno());
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
