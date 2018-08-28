<?php
include 'backend/database.php';
$orderBy;
if (isset($_REQUEST['orderBy'])){
  $orderBy = $_REQUEST['orderBy'];
}
else{
  $orderBy = 'id';
}
//retrieve from database
$dbconn = connectToDB();
$selectQuery = "SELECT * FROM phonebook.persons ORDER BY $orderBy";
$queryResult = doQuery($dbconn, $selectQuery);
$rows = array();
while ($row = mysqli_fetch_array($queryResult)) {
    $person = new stdClass();
    $person->id = $row['id'];
    $person->firstName =$row['first_name'];
    $person->lastName = $row['last_name'];
    $person->email = $row['email_address'];
    $person->phoneNumber = $row['phone_number'];
    array_push($rows, $row);
}

// Free queryResultset
freeResultAndClose($dbconn, $queryResult);
?>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/show_persons.css">
<!--  <script type="text/javascript" src="js/show_persons.js"></script>-->
</head>

<body>
  <button id="add_btn" class="sweet_btn">Add Person</button>
  <span>Order by:</span>
  <select id="orderOptions">
        <option value="id">Id</option>
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="email_address">E-mail</option>
  </select>


  <!--This table will be completed in Javascript-->
  <table id="persons_table">
    <tr>
      <th>Id</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>E-mail</th>
      <th>Phone number</th>
    </tr>
<?php
    foreach ($rows as $row){
      echo "<tr><td>" . $row['id'] ."</td><td>" .
      $row['first_name'] . "</td><td>" .$row['last_name'] . "</td><td>" . $row['email_address'] . "</td>".
        "<td>".$row['phone_number'] . "</td>
        <td><button id = change_".$row['id'] ." class = btnInsideRow>Change</button></td>
        <td><button id = delete_".$row['id'] ." class = btnInsideRow>Delete</td>
      </tr>";
    }
 ?>
  </table>
</body>

</html>
