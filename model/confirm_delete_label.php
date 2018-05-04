<?php
include ('labels.php');
$delete = new labels();
$delete->delete_labels();
header('location: ../view/mail.php');
?>