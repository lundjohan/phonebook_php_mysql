<?php
//receive id for person than should be removed
$idNr = $_REQUEST['id'];
//database operation
include 'database.php';
$dbconn = connectToDB();
$query = "DELETE FROM phonebook.persons WHERE id = $idNr";
$queryResult = doQuery($dbconn, $query);
// Free queryResultset
freeResultAndClose($dbconn, $queryResult);

//go to page
header('Location: ../show_contacts.php');
