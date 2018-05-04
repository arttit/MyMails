<?php
session_start();
include ('mail.php');
$delete = new mail();
$delete->delete_mail();
header('Location: ../view/mail.php');
?>