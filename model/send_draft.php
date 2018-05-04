<?php 
include ('mail.php');
$draft = new mail();
$draft->mail_draft();
header('location: ../view/drafts.php');
?>