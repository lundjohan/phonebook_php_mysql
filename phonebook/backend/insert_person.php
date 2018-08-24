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
/*$dbconn = mysqli_connect("localhost", "root", "", "phonebook")
    or die('Could not connect: ' . mysqli_connect_errno());//connectToDB();*/
//echo("$dbconn"); //testing to pring


    //insert into table persons.
    $insertQuery = "INSERT INTO phonebook.persons (first_name, last_name, email_address, phone_number) values ('$firstName', '$lastName', '$eMail', '$phoneNr')";


    //pg_query($insertQuery) or die('Insertion failed: ' . pg_last_error());;
    $result = doQuery($dbconn, $insertQuery);
    //$selectQuery = 'SELECT * FROM phonebook.persons';
    //$result = pg_query($selectQuery) or die('Query failed: ' . pg_last_error());

    // Free resultset
    //pg_free_result($result);
    //pg_close($dbconn);
    freeResultAndClose($dbconn, $result);
    //go to showing_persons page
    header( 'Location: ../show_persons.html' );
?>
