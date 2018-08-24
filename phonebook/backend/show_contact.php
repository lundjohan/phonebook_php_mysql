<?php

//error handling doesn't seem to have any effect, but letting it stand for now.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//retrieve id
$id;
if (isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
}


include("database.php");
//retrieve from database
$dbconn = connectToDB();
$selectQuery = "SELECT * FROM phonebook.persons WHERE phonebook.persons.id =" . "$id";
//$queryResult = pg_query($selectQuery) or die('Query failed: ' . pg_last_error());
$queryResult = doQuery($dbconn, $selectQuery);


/*$dbconn = pg_connect("host=localhost dbname=phonebook user=postgres password=postgres") or die('Could not connect: ' . pg_last_error());
$selectQuery = "SELECT * FROM phonebook.persons WHERE phonebook.persons.id =" . "$id";
$queryResult = pg_query($selectQuery) or die('Query failed: ' . pg_last_error());*/

//$row = pg_fetch_row($queryResult, null, PGSQL_ASSOC);
$row = mysqli_fetch_array($queryResult);
freeResultAndClose($dbconn, $queryResult);

$myJSON = json_encode($row);

echo $myJSON;
?>
