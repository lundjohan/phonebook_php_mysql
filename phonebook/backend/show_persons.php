<?php
include 'database.php';
$orderBy = $_REQUEST['orderBy'];
//retrieve from database
$dbconn = connectToDB();
$selectQuery = "SELECT * FROM phonebook.persons ORDER BY $orderBy";
//$queryResult = pg_query($selectQuery) or die('Query failed: ' . pg_last_error());
$queryResult = doQuery($dbconn, $selectQuery);
$rows = array();
while ($row = mysqli_fetch_array($queryResult)) {
        $person = new stdClass();
        $person->id = $row['id'];
        $person->firstName =$row['first_name'];
        $person->lastName = $row['last_name'];
        $person->email = $row['email_address'];
        $person->phoneNumber = $row['phone_number'];
        array_push($rows, $person);
}

// Free queryResultset
//pg_free_result($queryResult);
freeResultAndClose($dbconn, $queryResult);
//echo sizeof($rows);
$myJSON = json_encode($rows);

echo $myJSON;
?>
