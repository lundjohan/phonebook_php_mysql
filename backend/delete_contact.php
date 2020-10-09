<?php
//receive id for person that should be removed, only allow numbers
$idNr = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);

//database operation
include("pdo_connect.php");
$stmt = $pdo->prepare("DELETE FROM " .$GLOBALS['db']. ".persons WHERE id = ?");
$stmt -> execute([$idNr]);

//go to page
header('Location: ../show_contacts.php');
