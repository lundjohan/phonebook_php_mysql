<?php
include("backend/database.php");
//new contact OR changing contact
$newContact = true;
$first_time = true;
$output_form = false;

$id = '-1';
$first_name = '';
$last_name = '';
$e_mail = '';
$phone_nr = '';

//if it exists, retrieve id
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    if ($_REQUEST['id'] != '-1'){
      $newContact = false;
    }
}

if (isset ($_POST['submit_contact'])){
  $first_time = false;
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $e_mail = $_POST['e_mail'];
  $phone_nr = $_POST['phone_nr'];
}
else{
  $output_form = true;
}
//check that form is filled in ok
if (!$first_time){
  if (empty($_POST["first_name"]) || empty($_POST["last_name"])) {
      echo 'Name is not filled in correctly.';
      $output_form = true;
  }
  if (empty($_POST['e_mail'])) {
      echo 'E-mail is not filled in correctly.';
      $output_form = true;
  }
  if (empty($_POST['phone_nr'])) {
      echo 'Phone number is not filled in correctly.';
      $output_form = true;
  }
}
if (!$output_form){
  //save to database
  $dbconn = connectToDB();
  $query;
  if ($newContact){
    $query = "INSERT INTO phonebook.persons (first_name, last_name, email_address, phone_number)
    values ('$first_name', '$last_name', '$e_mail', '$phone_nr')";
  }
  else{
    $query = "UPDATE phonebook.persons
    SET first_name='$first_name', last_name='$last_name', email_address='$e_mail',  phone_number='$phone_nr'
    WHERE id=$id";
  }
  $result = doQuery($dbconn, $query);

  // Free resultset
  freeResultAndClose($dbconn, $result);

  //go to showing_persons page
  header('Location: show_contacts.php');
}
//first time and changing contact -> retrieve person from database
elseif (!$newContact) {
    $dbconn = connectToDB();
    $selectQuery = "SELECT * FROM phonebook.persons WHERE phonebook.persons.id =" . "$id";
    $queryResult = doQuery($dbconn, $selectQuery);
    $row = mysqli_fetch_array($queryResult);
    freeResultAndClose($dbconn, $queryResult);

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $e_mail = $row['email_address'];
    $phone_nr = $row['phone_number'];
}
?>

<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
  <?php
  if ($newContact){
    echo '<h1>Add Contact</h1>';
  }
  else /*changing_contact*/{
    echo '<h1>Change Contact</h1>';
  }
  ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <!-- Hidden input field for id-->
    <input type='hidden' name='id' value=<?php echo $id?>>
    <table>
      <tr>
        <td>First Name:</td>
        <td>
          <input type="text" name="first_name" value=<?php echo $first_name?>>
        </td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td>
          <input type="text" name="last_name" value=<?php echo $last_name?>>
        </td>
      </tr>
      <tr>
        <td>E-mail:</td>
        <td>
          <input type="text" name="e_mail" value=<?php echo $e_mail?>>
        </td>
      </tr>
      <tr>
        <td>Phone Number:</td>
        <td>
          <input type="text" name="phone_nr" value=<?php echo $phone_nr?>>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" class="sweet_btn" name="submit_contact" value=
            <?php
            if ($newContact){
              echo '"Add Person to Database">';
            }
            else{
              echo '"Update Person in Database">';
            }
            ?>
        </td>
      </tr>
    </table>
  </form>
</body>
</html>
