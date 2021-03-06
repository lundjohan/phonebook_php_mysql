<?php
/*
This file can represent
  1. Adding a new contact.
  2. Changing an exisiting contact.
*/
include("backend/pdo_connect.php");
include("backend/database.php");

//new contact OR changing contact
$newContact = true;
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

    //to remove SQL Injection risk: wash id variable
    $id = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
}

if (isset ($_POST['submit_contact'])){

  //escape incoming variables for extra security
  $conn = connectToDB();
  $first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
  $last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
  $e_mail = mysqli_real_escape_string($conn, $_REQUEST['e_mail']);
  $phone_nr = mysqli_real_escape_string($conn, $_REQUEST['phone_nr']);
  closeDB($conn);

  //check that form is filled in ok
  if (empty($_POST["first_name"]) || empty($_POST["last_name"])) {
      echo 'Name is not filled in correctly.<br>';
      $output_form = true;
  }
  if (!filter_var($_POST['e_mail'], FILTER_VALIDATE_EMAIL)) {
      echo 'E-mail is not filled in correctly.<br>';
      $output_form = true;
  }
  if (empty($_POST['phone_nr'])) {
      echo 'Phone number is not filled in correctly.<br>';
      $output_form = true;
  }
}
else{
  $output_form = true;
}

//User has written form correctly =>  save to database
if (!$output_form){
  if ($newContact){
    $stmt = $pdo->prepare("INSERT INTO " . $GLOBALS['db'] . ".persons (first_name, last_name, email_address, phone_number) VALUES
    (?, ?, ?, ?)");
    $stmt ->execute([$first_name, $last_name, $e_mail, $phone_nr]);
  }
  else{
    $stmt = $pdo->prepare("UPDATE " . $GLOBALS['db'] . ".persons SET first_name=?, last_name=?, email_address=?,  phone_number=?
    WHERE id=?");
    $stmt ->execute([$first_name, $last_name, $e_mail, $phone_nr, $id]);
  }

  //go to showing_persons page
  header('Location: show_contacts.php');
}
//changing contact AND form should be outputed -> retrieve person from database
elseif (!$newContact) {

  $stmt = $pdo->prepare("SELECT * FROM " . $GLOBALS['db'].".persons WHERE " . $GLOBALS['db'] . ".persons.id = ?");
  $stmt -> execute([$id]);
  $row = $stmt->fetch();
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
  <link rel="stylesheet" type="text/css" href="css/contact_data.css">
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
