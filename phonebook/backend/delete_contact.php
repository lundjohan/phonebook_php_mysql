<?php
//receive id for person than should be removed
$idNr = $_REQUEST['id'];
//database operation
include 'database.php';
$dbconn = connectToDB();
$query = "DELETE FROM " .$GLOBALS['database']. ".persons WHERE id = $idNr";
$queryResult = doQuery($dbconn, $query);
closeDB($dbconn);

//go to page
header('Location: ../show_contacts.php');
