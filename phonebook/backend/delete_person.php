<?php
//receive id for person than should be removed
$obj = file_get_contents('php://input');//json_decode($_POST["id"], false); <= doesnt work
$idObj = json_decode($obj);
$idNr = $idObj->id;
//database operation
include 'database.php';
$dbconn = connectToDB();
//$dbconn = pg_connect("host=localhost dbname=phonebook user=postgres password=postgres") or die ('Could not connect: ' . pg_last_error());
$query = "DELETE FROM phonebook.persons WHERE id = $idNr";
//$queryResult = pg_query($query) or die('Query failed: ' . pg_last_error());
//$queryResult = pg_query($query) or die('Query failed: ' . pg_last_error());
$queryResult = doQuery($dbconn, $query);
// Free queryResultset
freeResultAndClose($dbconn, $queryResult);

echo(json_encode($obj));
?>
