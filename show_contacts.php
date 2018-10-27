<?php
include 'backend/pdo_connect.php';
include 'backend/database.php';
/*
This file show the contacts to the user.
*/


$orderBy = 'id';
/*Retrieve list sort order from users choice*/
if (isset($_REQUEST['orderBy'])){
  /* need to connect to database to use mysqli... */
  $conn = connectToDB();
  $orderBy = mysqli_real_escape_string($conn, $_REQUEST['orderBy']);
  closeDB($conn);
}

/*Retrieve data from database. NB: In PDO, ORDER BY cannot use placeholders.
But we should be safe from SQL Injection here anyway thanks to escaping-string above.
*/
$stmt = $pdo->prepare("SELECT * FROM " . $GLOBALS['db'] . ".persons ORDER BY $orderBy");
$stmt -> execute([]);
$contacts = $stmt->fetchAll();
?>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/show_contacts.css">
  <script type="text/javascript" src="js/show_contacts.js"></script>
</head>

<body>
  <button id="add_btn" class="sweet_btn">Add Person</button>
  <span>Order by:</span>
  <select id="orderOptions">
        <option value="id" <?php if ($orderBy ==='id'){echo " selected='selected'";} ?> >Id</option>
        <option value="first_name" <?php if ($orderBy ==='first_name'){echo " selected='selected'";} ?> >First Name</option>
        <option value="last_name" <?php if ($orderBy ==='last_name'){echo " selected='selected'";} ?> >Last Name</option>
        <option value="email_address" <?php if ($orderBy ==='email_address'){echo " selected='selected'";} ?> >E-mail</option>
  </select>

  <table id="persons_table">
    <tr>
      <th>Id</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>E-mail</th>
      <th>Phone number</th>
    </tr>

<?php
/*Complete table with data from database*/
    foreach ($contacts as $row){
      echo "<tr><td>" . $row['id'] ."</td><td>" .
      $row['first_name'] . "</td><td>" .$row['last_name'] . "</td><td>" . $row['email_address'] . "</td>".
        "<td>".$row['phone_number'] . "</td>
        <td><button id = change_".$row['id'] ." class = changeBtn>Change</button></td>
        <td><button id = delete_".$row['id'] ." class = deleteBtn>Delete</td>
      </tr>";
    }
  ?>
  </table>
</body>
</html>
