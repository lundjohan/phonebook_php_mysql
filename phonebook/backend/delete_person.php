<?php
//receive id for person than should be removed
$obj = file_get_contents('php://input');//json_decode($_POST["id"], false); <= doesnt work
$idObj = json_decode($obj);
$idNr = $idObj->id;
//database operation
include 'database.php';
$dbconn = connectToDB();
$query = "DELETE FROM phonebook.persons WHERE id = $idNr";
$queryResult = doQuery($dbconn, $query);
// Free queryResultset
freeResultAndClose($dbconn, $queryResult);

echo(json_encode($obj));
?>
