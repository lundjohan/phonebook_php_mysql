<?php
if (empty($_POST['submit'])){
    die( 'Form is not submitted');
}
if (empty($_POST["first_name"]) || empty($_POST["last_name"]) ){
    die( 'First name or last name is not filled in.');
}
$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$eMail = $_POST["e_mail"];
$phoneNr = $_POST["phone_nr"];
include 'database.php';
$dbconn = connectToDB();

    //insert into table persons.
    $insertQuery = "INSERT INTO phonebook.persons (first_name, last_name, email_address, phone_number) values ('$firstName', '$lastName', '$eMail', '$phoneNr')";
    $result = doQuery($dbconn, $insertQuery);

    // Free resultset
    freeResultAndClose($dbconn, $result);
    //go to showing_persons page
    header( 'Location: ../show_persons.html' );
?>
