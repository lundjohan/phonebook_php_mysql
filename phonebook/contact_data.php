<?php
/*
This file can represent
  1. Adding a new contact.
  2. Changing an exisiting contact.
  It knows the difference by checking that the incoming $_REQUEST['id'] value is valid (Changing) or not (Adding).
This file is self referencing (recursive) => if form is not properly written by user,
  then it will be shown to user which form data he needs to do better.
*/
include("backend/database.php");

//new contact OR changing contact
$newContact = true;
$first_time = true;
$output_form = false;

/*case id == -1 => this file deals with new Contact,
  otherwise changing contact.*/
$id = '-1';
$first_name = '';
$last_name = '';
$e_mail = '';
$phone_nr = '';

//if it exists, retrieve id
if (isset($_REQUEST['id']) && $_REQUEST['id'] != '-1') {
    $newContact = false;

    //to remove SQL Injection risk: id should only be able to store numbers
    $id = preg_replace(array('/[^0-9]/'), '',$_REQUEST['id']);
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
      echo 'Name is not filled in correctly.<br>';
      $output_form = true;
  }
  if (empty($_POST['e_mail'])) {
      echo 'E-mail is not filled in correctly.<br>';
      $output_form = true;
  }
  if (empty($_POST['phone_nr'])) {
      echo 'Phone number is not filled in correctly.<br>';
      $output_form = true;
  }
}
//User has written form correctly =>  save to database
if (!$output_form){
  $dbconn = connectToDB();
  $query;
  if ($newContact){
    $query = "INSERT INTO " . $GLOBALS['database'] . ".persons (first_name, last_name, email_address, phone_number)
    values ('$first_name', '$last_name', '$e_mail', '$phone_nr')";
  }
  else{
    $query = "UPDATE " . $GLOBALS['database'] . ".persons
    SET first_name='$first_name', last_name='$last_name', email_address='$e_mail',  phone_number='$phone_nr'
    WHERE id=$id";
  }
  $result = doQuery($dbconn, $query);


  closeDB($dbconn);

  //go to showing_persons page
  header('Location: show_contacts.php');
}
//changing contact -> retrieve person from database
elseif (!$newContact) {
    $dbconn = connectToDB();
    $selectQuery = "SELECT * FROM " .$GLOBALS['database'].".persons WHERE " . $GLOBALS['database'] . ".persons.id =" . "$id";
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
  else {
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
          <input type="text" name="first_name" value='<?php echo $first_name?>'>
        </td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td>
          <input type="text" name="last_name" value='<?php echo $last_name?>'>
        </td>
      </tr>
      <tr>
        <td>E-mail:</td>
        <td>
          <input type="text" name="e_mail" value='<?php echo $e_mail?>'>
        </td>
      </tr>
      <tr>
        <td>Phone Number:</td>
        <td>
          <input type="text" name="phone_nr" value='<?php echo $phone_nr?>'>
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
