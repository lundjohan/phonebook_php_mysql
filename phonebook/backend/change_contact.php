<?php
include 'database.php';
$new_first_name = $_REQUEST['first_name'];
$new_last_name = $_REQUEST['last_name'];
$new_e_mail = $_REQUEST['e_mail'];
$new_phone_nr = $_REQUEST['phone_nr'];
$id = $_REQUEST['id'];
$dbconn = connectToDB();
$selectQuery = "UPDATE phonebook.persons SET first_name='$new_first_name', last_name='$new_last_name', email_address='$new_e_mail',  phone_number='$new_phone_nr' WHERE id=$id";
//$queryResult = pg_query($selectQuery) or die('Query failed: ' . pg_last_error());

$queryResult = doQuery($dbconn, $selectQuery);


// Free queryResultset
freeResultAndClose($dbconn, $queryResult);

//go to showing_persons page
header( 'Location: ../show_persons.html' );
?>
